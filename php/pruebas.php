<?php

$con_paises = mysqli_connect("localhost", "root", "", "redsocialrutas");

$query_paises = "SELECT Pais FROM paises ORDER BY Pais ASC";

$array_paises = mysqli_query($con_paises, $query_paises);

echo "<select>";
while ($fila = mysqli_fetch_array($array_paises)) {
    echo "<option value='" . $fila['Pais'] . "'>" . $fila['Pais'] . "</option>";
}
echo "</select>";

 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar ciudad según país</title>
</head>
<body>
    <h1>Seleccionar ciudad según país</h1>
    
    <form method="post" action="ciudades.php">
        <label for="country">País:</label>
        <select name="country" id="country">
            <option value="1">México</option>
            <option value="2">Estados Unidos</option>
            <option value="3">Canadá</option>
        </select>
        <br>
        <input type="submit" value="Seleccionar">
    </form>
    
    <?php
    // Conexión a la base de datos
    $host = "localhost";
    $user = "mi_usuario";
    $password = "mi_contraseña";
    $db_name = "mi_base_de_datos";

    $connection = mysqli_connect($host, $user, $password, $db_name);

    // Obtener el país seleccionado
    $country_id = $_POST["country"];

    // Consulta para obtener la lista de ciudades
    $query = "SELECT id, name FROM cities WHERE country_id = $country_id";

    // Ejecutar la consulta
    $result = mysqli_query($connection, $query);

    // Verificar si la consulta devuelve algún resultado
    if(mysqli_num_rows($result) > 0) {
        // Recorrer los resultados y crear una lista de opciones
        echo "<label for='city'>Ciudad:</label>";
        echo "<select name='city' id='city'>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
        }
        echo "</select>";
    } else {
        echo "No hay ciudades disponibles para este país.";
    }
    ?>
    
</body>
</html>

