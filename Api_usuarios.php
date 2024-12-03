//API URL: http://localhost/SmartKeyMapa/Api_usuarios.php
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

// Configurar encabezados
header('Content-Type: application/json');

// Manejo de la solicitud
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Crear un nuevo usuario
    $data = json_decode(file_get_contents("php://input"), true);
    if (
        isset($data['usuario'], $data['clave'], $data['placa'], $data['modelo'], $data['id_smart'], $data['nombres'])
    ) {
        $stmt = $pdo->prepare(
            "INSERT INTO usuario (usuario, clave, placa, modelo, id_smart, nombres) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        try {
            // Ejecutar la inserción de los datos
            $stmt->execute([
                $data['usuario'],
                password_hash($data['clave'], PASSWORD_DEFAULT), // Encriptar la clave
                $data['placa'],
                $data['modelo'],
                $data['id_smart'],
                $data['nombres'] // Incluir el campo 'nombres'
            ]);
            
            // Obtener el ID del nuevo usuario insertado
            $lastInsertId = $pdo->lastInsertId();

            // Recuperar los datos del usuario recién insertado
            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
            $stmt->execute([$lastInsertId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Devolver el mensaje de éxito con los datos del usuario
            echo json_encode([
                "message" => "Usuario creado correctamente",
                "usuario" => $user
            ]);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error al insertar: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Datos incompletos"]);
    }
} else {
    echo json_encode(["error" => "Método no soportado"]);
}
?>
