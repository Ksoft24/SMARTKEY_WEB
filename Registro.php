<?php
session_start();

// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "bd_smartkey";
$username = "root";
$password = "";

// Establecer conexión con la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesar formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $clave = $_POST['clave'];
    $placa = trim(filter_input(INPUT_POST, 'placa', FILTER_SANITIZE_STRING));
    $modelo = trim(filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING));
    $id_smart = trim(filter_input(INPUT_POST, 'id_smart', FILTER_SANITIZE_STRING));
    $nombres = trim(filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING));

    if (empty($usuario) || empty($clave) || empty($placa) || empty($modelo) || empty($id_smart) || empty($nombres)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO usuario (usuario, clave, placa, modelo, id_smart, nombres) 
            VALUES (:usuario, :clave, :placa, :modelo, :id_smart, :nombres)"
        );

        try {
            $stmt->execute([
                ':usuario' => $usuario,
                ':clave' => password_hash($clave, PASSWORD_DEFAULT),
                ':placa' => $placa,
                ':modelo' => $modelo,
                ':id_smart' => $id_smart,
                ':nombres' => $nombres
            ]);

            $_SESSION['usuario_id'] = $pdo->lastInsertId();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['nombres'] = $nombres;

            $message = "Registro exitoso. Redirigiendo...";
            header("Refresh:0; url=menu.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error al registrar el usuario: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - SmartKey</title>
    <link rel="icon" href="/SmartkeyMapa/Imagenes/smartkey.jpg" type="image/jpg">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(45deg, #2c3e50, #3498db); /* Fondo degradado con contraste */
        }

        .login-wrapper {
            display: flex;
            width: 70%;
            max-width: 1200px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .left-section {
            flex: 1;
            background: linear-gradient(45deg, #2c3e50, #3498db); /* Fondo degradado con contraste */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            text-align: center;
        }

        .left-section h1 {
            margin: 10px;
            font-size: 3em;
        }

        .left-section p {
            font-size: 2em;
            margin: 10px 0;
        }

        /* Estilo para el logo */
        .left-section img {
            margin-top: 10px;
            width: 100%;
            /* Esto hace que ocupe el 100% del contenedor */
            max-width: 220px;
            /* Aumenta el tamaño máximo del logo */
            border-radius: 10%;
        }

        .right-section {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-section h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #4a00e0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #8e2de2, #4a00e0);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #682ae9;
        }

        .error-message {
            color: #f44336;
            margin-top: 10px;
        }

        .extra-links {
            text-align: center;
            margin-top: 20px;
        }

        .extra-links a {
            color: #4a00e0;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }
        .logo {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- Sección izquierda -->
    <div class="left-section">
        <h1>Bienvenido</h1>
        <div class="logo">
            <img src="/SmartkeyMapa/Imagenes/smartkey.jpg" alt="Logo de SmartKey">
        </div>
    </div>

    <!-- Sección derecha -->
    <div class="right-section">
        <h2>Registro de Usuario</h2>

        <form action="Registro.php" method="POST">
            <div class="form-group">
                <input type="text" name="nombres" placeholder="Nombre Completo" required>
            </div>
            <div class="form-group">
                <input type="text" name="usuario" placeholder="NickName" required>
            </div>
            <div class="form-group">
                <input type="password" name="clave" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <input type="text" name="placa" placeholder="Placa del Vehículo" required>
            </div>
            <div class="form-group">
                <input type="text" name="modelo" placeholder="Modelo del Vehículo" required>
            </div>
            <div class="form-group">
                <input type="text" name="id_smart" placeholder="ID del Smart Key" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Registrar">
            </div>
        </form>

        <?php
        if (isset($message)) {
            echo "<p class='success-message'>$message</p>";
        } elseif (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>

        <div class="extra-links">
            <p>¿Ya tienes cuenta? <a href="Login.php">Iniciar sesión</a></p>
        </div>
    </div>
</div>

</body>
</html>
