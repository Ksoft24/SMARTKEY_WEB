<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "bd_smartkey";
$username = "root";
$password = "";

// Conexión a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}

// Conexión a la base de datos
include 'conexion.php';

// Iniciar la sesión
session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si existen los parámetros 'usuario' y 'clave'
    if (isset($_POST['usuario']) && isset($_POST['clave'])) {
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        // Sanitizar los valores de entrada para evitar inyecciones SQL
        $usuario = $conn->real_escape_string($usuario);
        $clave = $conn->real_escape_string($clave);

        // Consulta SQL para buscar al usuario con el nombre de usuario
        $sql = "SELECT id, usuario, clave FROM usuario WHERE usuario = ?";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular los parámetros
            $stmt->bind_param("s", $usuario);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado
            $result = $stmt->get_result();

            // Verificar si se encontró el usuario
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verificar la contraseña utilizando password_verify
                if (password_verify($clave, $user['clave'])) {
                    // Iniciar sesión
                    $_SESSION['usuario_id'] = $user['id'];
                    $_SESSION['nombres'] = $user['usuario'];

                    // Redirigir a la página principal del sistema (por ejemplo, dashboard.php)
                    header("Location: /SmartKeyMapa/menu.php");
                    exit; // Terminar la ejecución para evitar que el código posterior se ejecute
                } else {
                    echo "Usuario o contraseña incorrectos.";
                }
            } else {
                echo "Usuario o contraseña incorrectos.";
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        echo "Por favor, ingrese usuario y contraseña.";
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartKey</title>
    <link rel="icon" href="/SmartkeyMapa/Imagenes/smartkey.jpg" type="image/jpg">
    <style>
        /* Estilos generales */
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(45deg, #2c3e50, #3498db); /* Fondo degradado con contraste */
    overflow: hidden;
}

.login-wrapper {
    display: flex;
    width: 100%;
    max-width: 1200px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    flex-wrap: wrap; /* Permite que las secciones se apilen en pantallas pequeñas */
}

.left-section {
    flex: 1;
    background: linear-gradient(45deg, #2c3e50, #3498db);
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

.right-section {
    flex: 1;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.right-section h2 {
    font-size: 2em;
    margin-bottom: 20px;
    color: #4a00e0;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
    width: 100%;
}

input[type="text"],
input[type="password"] {
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

.right-logo {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
}

/* Media Queries */
@media screen and (max-width: 768px) {
    .login-wrapper {
        flex-direction: column;
        width: 90%;
    }

    .left-section,
    .right-section {
        width: 100%;
        padding: 20px;
    }

    .left-section h1 {
        font-size: 2.5em;
    }

    .left-section p {
        font-size: 1.5em;
    }

    .right-section h2 {
        font-size: 1.8em;
    }

    .form-group {
        margin-bottom: 15px;
    }

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
        font-size: 14px;
    }
}

@media screen and (max-width: 480px) {
    .left-section h1 {
        font-size: 2em;
    }

    .right-section h2 {
        font-size: 1.5em;
    }

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
        font-size: 14px;
        padding: 10px;
    }

    .error-message {
        font-size: 14px;
    }
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
            <img src="/SmartkeyMapa/Imagenes/login2.png" alt="imagen1" class="right-logo">
            <h2>Iniciar Sesión</h2>
            <!-- Formulario de login -->
            <form action="Login.php" method="POST">
                <div class="form-group">
                    <input type="text" name="usuario" placeholder="NickName" required>
                </div>
                <div class="form-group">
                    <input type="password" name="clave" placeholder="Contraseña" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Ingresar">
                </div>
            </form>

            <?php
            // Mostrar el mensaje de error si hay uno
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>

            <div class="extra-links">
                <a href="/SmartkeyMapa/Registro.php">Registrarse</a> |
                <a href="recuperar_clave.php">Recuperar Cuenta</a>
            </div>
        </div>
    </div>

</body>

</html>
