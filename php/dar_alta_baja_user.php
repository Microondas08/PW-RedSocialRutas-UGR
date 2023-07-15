<?php
require '../config/config.php';

$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Comprobación del botón "dar de baja" pulsado
if (isset($_POST['dar_de_baja'])) {
    $user = isset($_POST['username']) ? $_POST['username'] : $_SESSION['user'];
    $date = date("Y-m-d");

    // Actualizar la fecha de terminación del usuario
    $sql = "UPDATE users SET termination_date = '$date' WHERE user = '$user'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('$user se ha dado de BAJA.');</script>";
    } else {
        echo "Error al dar de baja al usuario: " . $conn->error;
    }
}

// Comprobación del botón "dar de alta" pulsado
if (isset($_POST['dar_de_alta'])) {
    $user = isset($_POST['username']) ? $_POST['username'] : $_SESSION['user'];
    // Actualizar la fecha de terminación del usuario a NULL
    $sql = "UPDATE users SET termination_date = NULL WHERE user = '$user'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('$user se ha dado de ALTA.');</script>";
    } else {
        echo "Error al dar de alta al usuario: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();


echo '<script>window.location.href = "configuracion.php";</script>';

?>