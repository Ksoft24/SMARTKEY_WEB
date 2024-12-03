//API URL: http://localhost/SmartKeyMapa/Api_acciones.php
<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$dbname = "bd_smartkey";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit();
}

// Manejo de solicitudes
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                // Obtener un registro por ID
                $id = intval($_GET['id']);
                $stmt = $pdo->prepare("SELECT * FROM acciones WHERE id = ?");
                $stmt->execute([$id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    echo json_encode($result);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Registro no encontrado"]);
                }
            } else {
                // Obtener todos los registros
                $stmt = $pdo->query("SELECT * FROM acciones ORDER BY id DESC");
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            }
            break;

        case 'POST':
            // Crear un nuevo registro
            $data = json_decode(file_get_contents("php://input"), true);

            // Validar que todos los campos requeridos estén presentes
            if (!isset($data['fecha_hora'], $data['id_usuario'], $data['on1'], $data['start1'], $data['off1'], $data['opendoor'], $data['closedoor'], $data['latitud'], $data['longitud'])) {
                http_response_code(400);
                echo json_encode(["error" => "Datos incompletos"]);
                exit();
            }

            // Insertar los datos en la base de datos
            $stmt = $pdo->prepare("INSERT INTO acciones (fecha_hora, id_usuario, on1, start1, off1, opendoor, closedoor, latitud, longitud) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['fecha_hora'],
                $data['id_usuario'],
                $data['on1'],      // Asegurarse de que se usa 'on1' en vez de 'on'
                $data['start1'],   // Asegurarse de que se usa 'start1' en vez de 'start'
                $data['off1'],     // Asegurarse de que se usa 'off1' en vez de 'off'
                $data['opendoor'],
                $data['closedoor'],
                $data['latitud'],
                $data['longitud']
            ]);

            echo json_encode([
                "message" => "Registro creado exitosamente",
                "id" => $pdo->lastInsertId(),
                "data" => $data
            ]);
            break;

        case 'PUT':
            // Actualizar un registro existente
            if (!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(["error" => "ID no proporcionado"]);
                exit();
            }

            $id = intval($_GET['id']);
            $data = json_decode(file_get_contents("php://input"), true);

            // Validar que todos los campos requeridos estén presentes
            if (!isset($data['fecha_hora'], $data['id_usuario'], $data['on1'], $data['start1'], $data['off1'], $data['opendoor'], $data['closedoor'], $data['latitud'], $data['longitud'])) {
                http_response_code(400);
                echo json_encode(["error" => "Datos incompletos"]);
                exit();
            }

            // Actualizar el registro en la base de datos
            $stmt = $pdo->prepare("UPDATE acciones SET fecha_hora = ?, id_usuario = ?, on1 = ?, start1 = ?, off1 = ?, opendoor = ?, closedoor = ?, latitud = ?, longitud = ? WHERE id = ?");
            $stmt->execute([
                $data['fecha_hora'],
                $data['id_usuario'],
                $data['on1'],      // Asegurarse de que se usa 'on1' en vez de 'on'
                $data['start1'],   // Asegurarse de que se usa 'start1' en vez de 'start'
                $data['off1'],     // Asegurarse de que se usa 'off1' en vez de 'off'
                $data['opendoor'],
                $data['closedoor'],
                $data['latitud'],
                $data['longitud'],
                $id
            ]);

            echo json_encode(["message" => "Registro actualizado exitosamente", "id" => $id]);
            break;

        case 'DELETE':
            // Eliminar un registro
            if (!isset($_GET['id'])) {
                http_response_code(400);
                echo json_encode(["error" => "ID no proporcionado"]);
                exit();
            }

            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("DELETE FROM acciones WHERE id = ?");
            $stmt->execute([$id]);

            echo json_encode(["message" => "Registro eliminado exitosamente", "id" => $id]);
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Método no soportado"]);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error interno: " . $e->getMessage()]);
}
?>
