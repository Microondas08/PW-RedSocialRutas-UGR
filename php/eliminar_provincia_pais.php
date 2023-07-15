<?php
// Obtener los datos del formulario
$eliminarPais = isset($_POST['eliminarPais']) ? $_POST['eliminarPais'] : 0;
$eliminarCiudad = isset($_POST['eliminarCiudad']) ? $_POST['eliminarCiudad'] : 0;
$Codigo = $_POST['Codigo'];
$Ciudad = $_POST['Ciudad'];

$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Eliminar país
if ($eliminarPais == 1 && !empty($Codigo)) {
    $sql_pais = "DELETE FROM paises WHERE Codigo = '$Codigo'";
    if ($conn->query($sql_pais) === TRUE) {
        echo '<script>alert("País eliminado correctamente.");</script>';
    } else {
        echo '<script>alert("Error al eliminar país: ' . $conn->error . '");</script>';
    }
}

// Eliminar ciudad
if ($eliminarCiudad == 1 && !empty($Ciudad)) {
    $sql_ciudad = "DELETE FROM ciudades WHERE Ciudad = '$Ciudad'";
    if ($conn->query($sql_ciudad) === TRUE) {
        echo '<script>alert("Ciudad eliminada correctamente.");</script>';
    } else {
        echo '<script>alert("Error al eliminar ciudad: ' . $conn->error . '");</script>';
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

echo '<script>window.location.href = "editar_provincia_localidad.php";</script>';
?>