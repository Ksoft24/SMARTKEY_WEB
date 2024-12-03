<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /SmartKeyMapa/Login.php"); // Redirige al login
    exit();
}

// Obtiene el nombre del usuario de la sesión
$nombres = isset($_SESSION['nombres']) ? $_SESSION['nombres'] : 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMARTKEY</title>
    <link rel="icon" href="/SmartkeyMapa/Imagenes/smartkey.jpg" type="image/jpg">
    <style>
        /* Estilos globales */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(45deg, #2c3e50, #3498db);
            /* Fondo degradado con contraste */
            color: #fff;
        }

        /* Contenedor del menú */
        .menu-container {
            text-align: center;
            padding: 40px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            /* Fondo oscuro para resaltar el menú */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        /* Título */
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #ecf0f1;
            /* Color blanco suave */
        }

        /* Estilo de los enlaces del menú */
        .menu-item {
            display: block;
            margin: 15px 0;
            font-size: 20px;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #2980b9;
            /* Botones con fondo azul */
            transition: background-color 0.3s, transform 0.2s;
        }

        /* Hover en los enlaces */
        .menu-item:hover {
            background-color: #1abc9c;
            /* Cambia a verde cuando pasas el mouse */
            transform: scale(1.05);
        }

        /* Estilo para los botones */
        .menu-item:active {
            background-color: #16a085;
            /* Cuando el botón es presionado */
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
    <div class="menu-wrapper">
        <!-- Sección izquierda -->
        <div class="left-section">
            <h1>Bienvenido, <?php echo htmlspecialchars($nombres); ?></h1>
        </div>

        <div class="menu-container">
            <h1>SMARTKEY</h1>
            <a href="registro.html" class="menu-item">Registrar Datos</a>
            <a href="Editar_Datos_Usuario.php" class="menu-item">Editar Mis Datos</a>
            <a href="reporte.php" class="menu-item">Reporte de Incidentes</a>
            <a href="mapa.php" class="menu-item">Reporte de Mapa</a>
            <!-- Botón Cerrar Sesión -->
            <form action="/SmartKeyMapa/Finalizar_Sesion.php" method="POST">
                <button class="logout" type="submit">Cerrar Sesión</button>
            </form>
        </div>

</body>

</html>