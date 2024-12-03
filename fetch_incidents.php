<?php
session_start();
include 'conexion.php'; 

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$id_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null; // Verificar que 'usuario_id' esté disponible


// Obtener las fechas del parámetro GET
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

if ($start_date && $end_date) {
    // Validar que las fechas tengan un formato correcto (Y-m-d)
    if (!preg_match("/\d{4}-\d{2}-\d{2}/", $start_date) || !preg_match("/\d{4}-\d{2}-\d{2}/", $end_date)) {
        echo json_encode(['error' => 'Formato de fecha incorrecto.']);
        exit;
    }

    // Sanitizar las fechas de entrada
    $start_date = $conn->real_escape_string($start_date);
    $end_date = $conn->real_escape_string($end_date);

    // Consulta SQL para obtener solo los incidentes del usuario autenticado
    $sql = "SELECT id, fecha_hora, id_usuario, latitud, longitud, opendoor, on1, start1, off1, closedoor
            FROM acciones 
            WHERE DATE (fecha_hora) BETWEEN ? AND ? 
            AND id_usuario = ?";

    // Preparar la consulta
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssi", $start_date, $end_date, $id_usuario);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            $incidentes = [];

            // Recoger todos los incidentes encontrados
            while ($row = $result->fetch_assoc()) {
                $incidentes[] = $row;
            }

            // Enviar los datos en formato JSON
            echo json_encode($incidentes);
        } else {
            echo json_encode(['message' => 'No se encontraron incidentes en este rango de fechas para el usuario especificado.']);
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error en la consulta a la base de datos.']);
    }
} else {
    echo json_encode(['error' => 'Por favor, proporcione las fechas de inicio y fin.']);
}

// Cerrar la conexión
$conn->close();
?>