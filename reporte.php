<?php
// Iniciar la sesión al principio
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit();
}

include 'conexion.php';

if (!isset($conn)) {
    die("Conexión a la base de datos fallida.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Incidentes</title>
    <link rel="icon" href="/SmartkeyMapa/Imagenes/smartkey.jpg" type="image/jpg">
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales */
        .navbar-custom {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: bold;
            color: #343a40;
        }

        .nav-link {
            margin: 0 10px;
        }

        .btn-custom {
            border-radius: 20px;
        }

        .btn-graph {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .container {
            margin-top: 30px;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .btn-submit {
            margin-top: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .no-results {
            margin-top: 20px;
            font-size: 1.2rem;
            color: #6c757d;
        }

        .logout {
            padding: 12px 25px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-left: auto;
        }

        .logout:hover {
            background-color: #e53935;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-custom">
        <a class="navbar-brand" href="#">Monitoreo de Incidentes</a>
        <div class="collapse navbar-collapse justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-primary btn-custom" href="menu.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-secondary btn-custom" href="reporte.php">Reportes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-graph btn-custom" href="mapa.php">Mapa</a>
                </li>
                <!-- Botón Cerrar Sesión -->
                <form action="/SMARTKEYMAPA/Finalizar_Sesion.php" method="POST">
                    <button class="logout" type="submit">Cerrar Sesión</button>
                </form>
            </ul>
        </div>
    </nav><br>

    <div class="container">
        <h1 class="text-center">Reportes de Incidentes 📊</h1><br>
        <h3>Ingrese las fechas para ver los reportes:</h3><br>
        <form method="get" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha"><b>Fecha Inicio:</b></label>
                    <input type="date" id="fecha" name="fecha" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="fechafin"><b>Fecha Fin:</b></label>
                    <input type="date" id="fechafin" name="fechafin" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Buscar</button>
        </form>

        <?php
        if (isset($_GET['fecha']) && isset($_GET['fechafin'])) {
            $fecha = $conn->real_escape_string($_GET['fecha']);
            $fechafin = $conn->real_escape_string($_GET['fechafin']);

            // Obtener el id del usuario logueado
            $usuario_id = $_SESSION['usuario_id'];

            // Modificar la consulta para que solo devuelva registros del usuario logueado
            $sql = "SELECT * FROM acciones WHERE fecha_hora BETWEEN '$fecha 00:00:00' AND '$fechafin 23:59:59' AND id_usuario = '$usuario_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table'><thead><tr><th>Id</th><th>Fecha y Hora</th><th>ID Usuario</th><th>ON</th><th>Start</th><th>Off</th><th>Open Door</th><th>Close Door</th><th>Latitud</th><th>Longitud</th></tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['fecha_hora']}</td>";
                    echo "<td>{$row['id_usuario']}</td>";
                    echo "<td>" . (isset($row['on1']) ? $row['on1'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($row['start1']) ? $row['start1'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($row['off1']) ? $row['off1'] : 'N/A') . "</td>";
                    echo "<td>{$row['opendoor']}</td>";
                    echo "<td>{$row['closedoor']}</td>";
                    echo "<td>{$row['latitud']}</td>";
                    echo "<td>{$row['longitud']}</td>";
                    echo "</tr>";
                }
                echo "</tbody></table></div>";

                // Enlace para descargar CSV
                echo '<a href="descargar_csv.php?fecha=' . urlencode($fecha) . '&fechafin=' . urlencode($fechafin) . '" class="btn btn-success mt-3">Descargar CSV</a>';
            } else {
                echo "<p class='no-results'>No se encontraron datos para este rango de fechas.</p>";
            }
        }

        if (isset($conn)) {
            $conn->close();
        }
        ?>

    </div>
</body>
</html>