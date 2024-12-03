<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'bd_smartkey'); // Cambia estos datos si es necesario

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener parámetros de fecha
if (isset($_GET['fecha']) && isset($_GET['fechafin'])) {
    $fecha = $conn->real_escape_string($_GET['fecha']);
    $fechafin = $conn->real_escape_string($_GET['fechafin']);

    // Consulta para obtener los registros dentro del rango de fechas
    $sql = "SELECT * FROM acciones WHERE fecha_hora BETWEEN '$fecha 00:00:00' AND '$fechafin 23:59:59'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Definir nombre del archivo CSV y tipo de contenido
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="reporte_incidentes.csv"');

        // Abrir salida en modo de escritura
        $output = fopen('php://output', 'w');

        // Escribir los encabezados en el CSV
        fputcsv($output, ['ID', 'Fecha y Hora', 'ID Usuario', 'ON', 'Start', 'Off', 'Open Door', 'Close Door', 'Latitud', 'Longitud']);

        // Escribir los datos en el CSV
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, [
                $row['id'],
                $row['fecha_hora'],
                $row['id_usuario'],
                $row['on'],
                $row['start'],
                $row['off'],
                $row['opendoor'],
                $row['closedoor'],
                $row['latitud'],
                $row['longitud']
            ]);
        }

        // Cerrar salida
        fclose($output);
    } else {
        echo "No se encontraron datos para el rango de fechas proporcionado.";
    }
} else {
    echo "Parámetros de fecha no proporcionados.";
}

// Cerrar la conexión
if (isset($conn)) {
    $conn->close();
}
?>
