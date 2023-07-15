<?php
include("../includes/header.php");
?>

<head>

    <script src="../js/jquery-3.6.3.min.js"></script>
    <script src="../dist/leaflet.js"></script>
    <script src="../dist/gpx.min.js"></script>
    <link rel="stylesheet" href="../dist/leaflet.css" />
    <style type="text/css">
        .map-container-class {
            height: 500px;
            width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>

</head>

<body>
    <?php

    // Crear conexión
    $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");
    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }


    // Obtener amigos del usuario $_SESSION['user']
    $user = $_SESSION['user'];

    $sql = "SELECT usuario1, usuario2 FROM friendship WHERE usuario1 = '$user' OR usuario2 = '$user'";
    $result = $conn->query($sql);

    $amigos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['usuario1'] == $user) {
                $amigos[] = $row['usuario2'];
            } else {
                $amigos[] = $row['usuario1'];
            }
        }
    }

    // Obtener las publicaciones de los amigos
    $publicaciones = array();

    foreach ($amigos as $amigo) {
        $sql = "SELECT * FROM posts ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $publicaciones[] = $row;
            }
        }
    }


    $map_initialized = false; // Variable para controlar la inicialización del mapa
// Mostrar las publicaciones
    foreach ($publicaciones as $publicacion) {
        // Obtener los datos de la publicación
        $actividad_id = $publicacion['actividad_id'];
        $titulo = $publicacion['titulo'];
        $map_path = $publicacion['map_path'];
        $user_id = $publicacion['user_id'];
        $id = $publicacion['id'];
        $aplausos = $publicacion['aplausos'];

        // Obtener el nombre del usuario
        $sql = "SELECT name FROM users WHERE user = '$user_id'";
        $result = $conn->query($sql);
        $name = "";


        // Consulta SQL para obtener el nombre del tipo de actividad
        $sqlactividad = "SELECT tipoactividad.Nombre
			FROM posts
			INNER JOIN tipoactividad ON posts.actividad_id = tipoactividad.Identificador
			WHERE posts.id = $id";

        $resultactividad = $conn->query($sqlactividad);

        // Recorrer los resultados y obtener el nombre del tipo de actividad
        $row = $resultactividad->fetch_assoc();
        $activity_type = $row['Nombre'];


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
        }




        // Mostrar la estructura de la publicación
        echo '<tr>';
        echo '	<div class="columna_dcha_index">';
        echo '		<ul>';

        $conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");

        // Suponiendo que tienes una conexión a la base de datos establecida previamente
        $user = $_SESSION['user'];
        // Obtener el valor de la columna "profile_picture" de la base de datos
        $query = "SELECT profile_picture FROM users WHERE user = '$user_id' ";
        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);
        $profilePicture = $row['profile_picture'];

        // Verificar si la columna "profile_picture" es nula
        if ($profilePicture === null) {
            echo '<li><img src="../icons/running.png" alt="Perfil" style="width: 25; height: 25; border-radius: 15px;margin-left: auto;margin-right: auto;"><strong> ' . $name . ' </strong> </a></a></li>';
        } else {
            // Mostrar la imagen devuelta por la base de datos
            echo '<li><img src="../images/' . $profilePicture . '" alt="Perfil" style="width: 25; height: 25; border-radius: 15px;margin-left: auto;margin-right: auto;"><strong> ' . $name . ' </strong> </a></li>';
        }

        echo 'junto a <strong>';

        // Consulta SQL para obtener los user_id con el post_id especificado
        $query = "SELECT user_id FROM user_posts WHERE post_id = '$id'";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            // Mostrar el valor de user_id
            echo $row['user_id'] . ' ';
        }
        echo '</strong></strong></li>';
        echo '			<br><br>';
        echo '			<table>';
        echo '				<tr>';
        echo '					<td>';
        echo '						<li><strong>Tipo de actividad:</strong> ' . $activity_type . '</li>';
        echo '						<br><br>';
        echo '						<li>' . $titulo . '</li>';
        echo '						<br><br>';
        echo '					</td>';




        // Consulta SQL para obtener el nombre de la tabla imagenes
        $query = "SELECT i.nombre FROM imagenes i
				INNER JOIN posts_imagenes pi ON i.id = pi.imagen_id
				WHERE pi.post_id = '$id'";

        $result = $conn->query($query);


        // Mostrar todas las imágenes en filas de a tres
        //$numNames = $result->num_rows;
        $total_imagenes = $result->num_rows;
        $imagenes_por_fila = 3;
        $num_imagenes_actual = 0;

        // Verificar si se encontraron resultados
        if ($result->num_rows > 0) {
            // Recorrer cada fila de resultados
            while ($row = $result->fetch_assoc()) {
                // Construir la URL completa de la imagen
                $imagen_url = '../images/';



                // Verificar si es necesario abrir una nueva fila
                if ($num_imagenes_actual % $imagenes_por_fila === 0) {
                    echo '<tr>';
                }

                $imagen_completa = $imagen_url . $row['nombre'];
                // Mostrar el nombre de la tabla imagenes
                echo "<td><img src='$imagen_completa' alt='Imagen'></td>";
                // Verificar si es necesario cerrar la fila actual
                if ($num_imagenes_actual % $imagenes_por_fila === $imagenes_por_fila - 1 || $num_imagenes_actual === $total_imagenes - 1) {
                    echo '</tr>';
                }

                $num_imagenes_actual++;
            }
        }




        echo '				</tr>';
        echo '			</table>';
        echo '		</ul>';




        ?>
        <?php
        $url_base = '..\maps\\';
        $gpx_file = $url_base . $map_path;

        ?>
        <script>
            function msToTime(milliseconds) {
                //Get hours from milliseconds
                var hours = milliseconds / (1000 * 60 * 60);
                var absoluteHours = Math.floor(hours);
                var h = absoluteHours > 9 ? absoluteHours : '0' + absoluteHours;

                //Get remainder from hours and convert to minutes
                var minutes = (hours - absoluteHours) * 60;
                var absoluteMinutes = Math.floor(minutes);
                var m = absoluteMinutes > 9 ? absoluteMinutes : '0' + absoluteMinutes;

                //Get remainder from minutes and convert to seconds
                var seconds = (minutes - absoluteMinutes) * 60;
                var absoluteSeconds = Math.floor(seconds);
                var s = absoluteSeconds > 9 ? absoluteSeconds : '0' + absoluteSeconds;

                return h == "00" ? m + ':' + s : h + ':' + m + ':' + s;
            }
            $(document).ready(function () {
                var map<?php echo $id; ?> = L.map('map-container<?php echo $id; ?>').setView([51.505, -0.09], 13);

                L.tileLayer("http://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map<?php echo $id; ?>);

            $('.leaflet-control-attribution').html('Programaci&oacute;n Web');

            //Carga de una ruta GPX
            var gpxData<?php echo $id; ?> =<?php echo "'../maps/$map_path'" ?>; // URL to your GPX file or the GPX itself
            var gpx<?php echo $id; ?> = new L.GPX(gpxData<?php echo $id; ?>, {
                async: true,
                marker_options: {
                    startIconUrl: '../images/pin-icon-start.png',
                    endIconUrl: '../images/pin-icon-end.png',
                    shadowUrl: '../images/pin-shadow.png'
                },
                polyline_options: {
                    color: 'red',
                    opacity: 0.75,
                    weight: 3,
                    lineCap: 'round'
                }
            }).on('loaded', function (e) {
                map<?php echo $id; ?>.fitBounds(e.target.getBounds());
                const inicio = new Date(gpx<?php echo $id; ?>.get_start_time()).toLocaleString();
            const fin = new Date(gpx<?php echo $id; ?>.get_end_time()).toLocaleString();
            const kms = (gpx<?php echo $id; ?>.get_distance() / 1000).toFixed(2);
            const tiempoTotal = msToTime(gpx<?php echo $id; ?>.get_total_time());
            const tiempoMovimiento = msToTime(gpx<?php echo $id; ?>.get_moving_time());
            $("#datos").html(
                "<ul>" +
                "<li>Inicio: " + inicio + "</li>" +
                "<li>Fin: " + fin + "</li>" +
                "<li>Distancia: " + kms + "Km</li>" +
                "<li>Duracion: " + tiempoTotal + " </li>" +
                "<li>En movimiento: " + tiempoMovimiento + " </li>" +
                "</ul>");
                }).addTo(map<?php echo $id; ?>);
        });

        </script>
        <div id="map-container<?php echo $id; ?>" class="map-container-class"></div>


        <?php


        // Consulta SQL
        $sql = "SELECT user_id FROM usuarios_posts_aplaudieron WHERE post_id = $id";

        // Ejecutar la consulta
        $result = $conn->query($sql);


        // Verificar si hay usuarios que hayan aplaudido
        if (!empty($result)) {
            // Mostrar la lista de usuarios que han aplaudido
            echo '<li><img src="../images/team.png" alt="Team" style="width: 25px;"> Gente que le ha gustado esta publicacion: <br>';
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['user_id'] . "</li>";
            }
            echo '</li>';
        } else {
            // Mostrar un mensaje indicando que no hay usuarios que hayan aplaudido
            echo '<li><img src="../images/team.png" alt="Team" style="width: 25px;"> Ningún usuario ha aplaudido aún.</li>';
        }

        echo '<li class="aplausos">';

        if (isset($_GET['exito']) && $_GET['exito'] == 1) {
            echo '<p>¡La acción se realizó correctamente!</p>';
        }

        echo '<form method="post" action="aplausos.php">';
        echo '<input type="image" src="../images/aplausos.png" alt="aplauso" style="width: 50px;" name="aplauso">';
        echo "<input type='hidden' name='id' value='$id'>";
        echo '</form>';

        echo '</li>';
        echo '<li>Número de aplausos: ' . $aplausos . '</li>';


        echo '	</div>';
        echo '</tr>';
    }

    // Cerrar la conexión
    $conn->close();
    ?>



</body>

</html>