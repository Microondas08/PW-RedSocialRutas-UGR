<?php
// Obtener los datos del formulario
$Paises_Codigo = $_POST['Paises_Codigo'];
$Ciudad = $_POST['Ciudad'];
$Codigo = $_POST['Codigo'];
$Pais = $_POST['Pais'];

$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Realizar el INSERT en la tabla "ciudades"
$sql_ciudades = "INSERT INTO ciudades (Paises_Codigo, Ciudad) VALUES ('$Paises_Codigo', '$Ciudad')";


// Realizar el INSERT en la tabla "paises" solo si no existe ya
$sql_check_paises = "SELECT * FROM paises WHERE Codigo = '$Paises_Codigo'";
$result_check_paises = $conn->query($sql_check_paises);

if ($result_check_paises->num_rows == 0) {
    $sql_paises = "INSERT INTO paises (Codigo, Pais) VALUES ('$Paises_Codigo', '$Pais')";
    if ($conn->query($sql_paises) === TRUE) {
        echo '<script>alert("Inserción en la tabla \'paises\' realizada correctamente.");</script>';
    } else {
        echo '<script>alert("Error al insertar en la tabla \'paises\': ' . $conn->error . '");</script>';
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

echo '<script>window.location.href = "editar_provincia_localidad.php";</script>';
?>