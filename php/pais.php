<?php
// Conectarse a la base de datos
$conexion_pais = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Consultar todos los países disponibles
$query = "SELECT pais FROM paises";
$resultado = mysqli_query($conexion_pais, $query);

// Mostrar los países en un select HTML
echo "<select id='pais' name='pais'>";
echo "<option value=''>Seleccione un país</option>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<option value='" . $fila["pais"] . "'>" . $fila["pais"] . "</option>";
}
echo "</select>";

// Cerrar la conexión a la base de datos
mysqli_close($conexion_pais);
?>