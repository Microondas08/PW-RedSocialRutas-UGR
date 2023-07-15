<!DOCTYPE html>
<html>
<head>
	<title>Consulta AJAX de ciudades por país</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#pais").change(function(){
				var pais = $(this).val();
				$.ajax({
					url: "ciudades.php",
					type: "POST",
					data: {pais: pais},
					success: function(data){
						$("#ciudades").html(data);
					}
				});
			});
		});
	</script>
</head>
<body>
	<h1>Consulta AJAX de ciudades por país</h1>
	<label for="pais">Seleccione un país:</label>
	<?php
	// Conectarse a la base de datos
	$conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");
	
	// Consultar todos los países disponibles
	$query = "SELECT pais FROM paises";
	$resultado = mysqli_query($conexion, $query);
	
	// Mostrar los países en un select HTML
	echo "<select id='pais' name='pais'>";
	echo "<option value=''>Seleccione un país</option>";
	while($fila = mysqli_fetch_assoc($resultado)){
		echo "<option value='".$fila["pais"]."'>".$fila["pais"]."</option>";
	}
	echo "</select>";
	
	// Cerrar la conexión a la base de datos
	mysqli_close($conexion);
	?>
	<ul id="ciudades"></ul>
</body>
</html>
