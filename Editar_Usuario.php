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
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];  // Ahora el 'id' está presente en el POST
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $id_smart = $_POST['id_smart'];
    $nombres = $_POST['nombres'];

    // Encriptar la nueva clave
    $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

    // Actualizar los datos del usuario
    $stmt = $pdo->prepare(
        "UPDATE usuario SET usuario = ?, clave = ?, placa = ?, modelo = ?, id_smart = ?, nombres = ? WHERE id = ?"
    );

    try {
        // Ejecutar la actualización
        $stmt->execute([
            $usuario,
            $clave_encriptada,
            $placa,
            $modelo,
            $id_smart,
            $nombres,
            $id  // El id ya está disponible aquí
        ]);

        // Redirigir o mostrar mensaje de éxito
        echo "Usuario actualizado correctamente.";
        header("Location: /SmartkeyMapa/menu.php");
    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
    }
}
