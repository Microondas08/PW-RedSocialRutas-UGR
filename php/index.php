<?php include("../includes/header.php"); ?>

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
	<div id="columna_dcha_index"> 
	</div>

<input type="submit" value="Cargar más" id="cargar-mas-btn" class="cargar_posts">

</body>
<script>
	$(document).ready(function () {
    var publicacionesContainer = $('#columna_dcha_index');
    var offset = 0;
    var limit = 1;

    function obtenerPublicaciones() {
        $.ajax({
            url: 'obtener_publicaciones.php',
            method: 'GET',
            data: { offset: offset, limit: limit },
            dataType: 'html',
            success: function (response) {
                // Vaciar el contenedor de publicaciones antes de agregar las nuevas
                publicacionesContainer.empty();
                // Agregar las nuevas publicaciones al contenedor
                publicacionesContainer.append(response);
                offset += limit; // Actualizar el desplazamiento para la siguiente carga
            },
            error: function () {
                alert('Error al obtener las publicaciones.');
            }
        });
    }

    obtenerPublicaciones(); // Obtener las primeras publicaciones al cargar la página

    // Cargar más publicaciones al hacer clic en el botón "Cargar más"
    $('#cargar-mas-btn').click(function () {
        limit++; // Aumentar el límite en 1
        obtenerPublicaciones();
    });
});

</script>

</html>