<?php
// Verificar que se recibió un valor de país válido
if (isset($_POST["pais"])) {
    // Conectarse a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");

    // Obtener el país seleccionado
    $pais = $_POST["pais"];

    // Consultar las ciudades correspondientes al país seleccionado
    $query = "SELECT ciudad FROM ciudades WHERE Paises_Codigo = (SELECT codigo FROM paises WHERE pais = '$pais') ORDER BY ciudad ASC";
    $resultado = mysqli_query($conexion, $query);

    // Mostrar las ciudades en formato HTML
    if (mysqli_num_rows($resultado) > 0) {
        echo "<select name='ciudad'>";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<option value='" . $fila["ciudad"] . "'>" . $fila["ciudad"] . "</option>";
        }
        echo "</select>";
    } else {
        echo "<p>No se encontraron ciudades para " . $pais . "</p>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>