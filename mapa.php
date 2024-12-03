<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Incidentes</title>
    <link rel="icon" href="/SmartkeyMapa/Imagenes/smartkey.jpg" type="image/jpg">
    <link rel="stylesheet" href="styles.css">
    <!-- Agregar el CSS de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map {
            height: 70vh;
            /* Aumentar la altura del mapa (80% de la altura de la ventana) */
            width: 100%;
            margin-bottom: 20px;
        }

        /* Estilo para el contenedor de las fechas y el botón */
        .date-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            /* Permite que los elementos se ajusten en pantallas pequeñas */
        }

        .date-container div {
            margin-right: 20px;
            margin-bottom: 10px;
            width: 450px;
        }

        .btn-verde {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-verde:hover {
            background-color: #0056b3;
        }

        /* Estilos adicionales para el encabezado */
        .navbar-custom {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            /* Color de fondo claro */
            border-bottom: 1px solid #dee2e6;
            /* Línea inferior para definir el área del nav */
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: bold;
            color: #343a40;
            /* Color de texto oscuro */
        }

        .nav-link {
            margin: 0 10px;
        }

        .btn-custom {
            border-radius: 20px;
            /* Bordes redondeados para los botones */
        }

        .btn-graph {
            background-color: #dc3545;
            /* Rojo */
            color: #fff;
            /* Texto blanco */
            border: none;
            /* Eliminar borde */
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

        /* Media queries para mejorar la responsividad */
        @media (max-width: 768px) {

            /* Hacer que los campos de fecha se apilen en pantallas pequeñas */
            .date-container {
                flex-direction: column;
                align-items: stretch;
            }

            .date-container div {
                width: 100%;
                margin-bottom: 10px;
                /* Espaciado entre los campos */
            }

            /* Ajustar la altura del mapa en pantallas más pequeñas */
            #map {
                height: 50vh;
            }

            /* Ajustar el tamaño de la navbar */
            .navbar-brand {
                font-size: 1.5rem;
            }
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
    <!-- Barra de navegación (encabezado) -->
    <nav class="navbar navbar-expand-md navbar-custom">
        <a class="navbar-brand" href="#">Reporte de Incidente en el Mapa 🌍</a>
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
    </nav>

    <!-- Contenedor para el formulario y el mapa -->
    <div class="form-container container">
        <h1 class="text-center">Reporte de Incidente en el Mapa 📌</h1>
        <form id="incident-form"><br>
            <!-- Contenedor para las fechas y el botón -->
            <div class="date-container">
                <div>
                    <label for="start_date"><b>Fecha de inicio:</b></label>
                    <input type="date" id="start_date" name="start_date" required class="form-control">
                </div>

                <div>
                    <label for="end_date"><b>Fecha de fin:</b></label>
                    <input type="date" id="end_date" name="end_date" required class="form-control">
                </div>

                <button type="button" class="btn-verde" id="search-btn">Buscar</button>
            </div>

            <!-- Mapa -->
            <div id="map"></div>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
// Colores para los marcadores
const colors = ['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF', '#00FFFF']; 

// Función para generar la descripción dinámica
function generateDescription(on1, start1, off1, opendoor, closedoor, incidente) {
    let description = "<b></b><br>";

    if (on1 == "1") {
        description += "🟢 Contacto<br>";
    }
    if (start1 == "1") {
        description += "🔑 Encendido<br>";
    }
    if (off1 == "1") {
        description += "🔴 Apagado<br>";
    }
    if (opendoor == "1") {
        description += "🔓 Puerta Abierta<br>";
    }
    if (closedoor == "1") {
        description += "🔒 Puerta Cerrada<br>";
    }

    // Si no hay acciones, agregar un texto por defecto
    if (!description.includes("Acción:")) {
        description += "";
    }

    return description;
}

// Función para obtener un color de marcador único
function getRandomColor() {
    return colors[Math.floor(Math.random() * colors.length)];
}

// Inicializar el mapa
let map;
function initMap() {
    const huanucoLocation = [-9.9755, -76.2422]; // Ubicación inicial
    map = L.map('map').setView(huanucoLocation, 13);

    // Agregar la capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
}

// Buscar incidentes
document.getElementById('search-btn').addEventListener('click', function () {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (startDate && endDate) {
        const userId = <?php echo json_encode($_SESSION['usuario_id']); ?>;

        fetch(`fetch_incidents.php?start_date=${startDate}&end_date=${endDate}&user_id=${userId}`)
            .then(response => response.json())
            .then(data => {
                map.eachLayer(layer => {
                    if (layer instanceof L.Marker) map.removeLayer(layer);
                });

                if (data.error) {
                    alert(data.error);
                } else if (data.length === 0) {
                    alert('No se encontraron incidentes para este usuario en las fechas seleccionadas.');
                } else {
                    data.forEach(incident => {
                        const { latitud, longitud, fecha_hora, description, on1, start1, off1, opendoor, closedoor } = incident;

                        // Generar descripción dinámica
                        const dynamicDescription = generateDescription(on1, start1, off1, opendoor, closedoor, incident);

                        // Crear marcador con descripción dinámica
                        L.marker([latitud, longitud], {icon: L.divIcon({className: 'leaflet-div-icon', iconSize: [20, 20], iconAnchor: [10, 10], bgPos: [0, 0], html: `<div style="background-color:${getRandomColor()}; width: 20px; height: 20px; border-radius: 50%;"></div>`})})
                            .bindPopup(`<b>Fecha y hora:</b> ${fecha_hora}<br><b>Descripción:</b> ${dynamicDescription}`)
                            .addTo(map);
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert('Por favor, seleccione ambas fechas.');
    }
});

initMap();
</script>
</body>

</html>