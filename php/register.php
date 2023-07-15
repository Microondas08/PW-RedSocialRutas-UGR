<?php
// Conectarse a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Obtener los datos del formulario
$username = mysqli_real_escape_string($conexion, $_POST["username"]);
$email = mysqli_real_escape_string($conexion, $_POST["email"]);
$password = mysqli_real_escape_string($conexion, $_POST["password"]);
$name = mysqli_real_escape_string($conexion, $_POST["name"]);
$surname = mysqli_real_escape_string($conexion, $_POST["surname"]);
$dob = mysqli_real_escape_string($conexion, $_POST["dob"]);
$activity_type = mysqli_real_escape_string($conexion, $_POST["activity_type"]);
$pais = mysqli_real_escape_string($conexion, $_POST["pais"]);
$ciudad = mysqli_real_escape_string($conexion, $_POST["ciudad"]);
$location = mysqli_real_escape_string($conexion, $_POST["location"]);

// Verificar si el tipo de actividad existe en la tabla
$existsQuery = "SELECT Identificador FROM tipoactividad WHERE Nombre = '$activity_type'";
$existsResult = mysqli_query($conexion, $existsQuery);

if (mysqli_num_rows($existsResult) == 0) {
    // El tipo de actividad no existe en la tabla, insertarlo
    $insertQuery = "INSERT INTO tipoactividad (Nombre) VALUES ('$activity_type')";
    mysqli_query($conexion, $insertQuery);
}

// Insertar los datos en la tabla de usuarios
$query = "INSERT INTO users (user, email, password, name, surname, date_birth, activity_type, location, province, country, rol, termination_date) 
            VALUES ('$username', '$email', '$password', '$name', '$surname', '$dob', '$activity_type', '$location', '$pais', '$ciudad', '0', null)";
$resultado = mysqli_query($conexion, $query);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "<script>alert('Registro exitoso. Por favor, inicie sesión');window.location.href='login.php';</script>";
} else {
    echo "<script>alert('Error al registrar usuario. Por favor, inténtelo de nuevo.');window.location.href='login.php';</script>";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>