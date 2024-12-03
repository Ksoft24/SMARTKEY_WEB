<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "bd_smartkey"; // Reemplaza con el nombre de tu base de datos
$username = "root"; // Reemplaza con tu usuario de la base de datos
$password = ""; // Reemplaza con tu contraseña de la base de datos

// Conectar a la base de datos
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Comprobar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si todos los campos requeridos están presentes
    if (
        isset($data['fecha_hora'], $data['id_usuario'], $data['on1'], $data['start1'], 
              $data['off1'], $data['opendoor'], $data['closedoor'], 
              $data['latitud'], $data['longitud'])
    ) {
        // Preparar la consulta SQL
        $sql = "INSERT INTO acciones (fecha_hora, id_usuario, on1, start1, off1, opendoor, closedoor, latitud, longitud)
                VALUES (:fecha_hora, :id_usuario, :on1, :start1, :off1, :opendoor, :closedoor, :latitud, :longitud)";

        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta con los datos enviados
        try {
            $stmt->execute([
                ':fecha_hora' => $data['fecha_hora'],
                ':id_usuario' => $data['id_usuario'],
                ':on1' => $data['on1'],
                ':start1' => $data['start1'],
                ':off1' => $data['off1'],
                ':opendoor' => $data['opendoor'],
                ':closedoor' => $data['closedoor'],
                ':latitud' => $data['latitud'],
                ':longitud' => $data['longitud']
            ]);
            echo json_encode(["success" => true, "message" => "Acción registrada correctamente."]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Error al registrar la acción: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>