<?php
// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener el usuario del formulario
$user = $_POST['user'];

// Escapar caracteres especiales para evitar inyección de SQL
$user = $conn->real_escape_string($user);

// Obtener los datos del formulario y construir la consulta SQL
$sql = "UPDATE users SET ";

// Verificar cada columna y agregarla a la consulta SQL solo si se proporciona un valor
if (!empty($_POST['name'])) {
    $name = $_POST['name'];
    $name = $conn->real_escape_string($name);
    $sql .= "name='$name', ";
}

if (!empty($_POST['surname'])) {
    $surname = $_POST['surname'];
    $surname = $conn->real_escape_string($surname);
    $sql .= "surname='$surname', ";
}

if (!empty($_POST['activity_type'])) {
    $activity_type = $_POST['activity_type'];

    // Verificar si el tipo de actividad existe en la tabla
    $existsQuery = "SELECT Identificador FROM tipoactividad WHERE Nombre = '$activity_type'";
    $existsResult = mysqli_query($conn, $existsQuery);

    if (mysqli_num_rows($existsResult) == 0) {
        // El tipo de actividad no existe en la tabla, insertarlo
        $insertQuery = "INSERT INTO tipoactividad (Nombre) VALUES ('$activity_type')";
        mysqli_query($conn, $insertQuery);
    }

    $activity_type = $conn->real_escape_string($activity_type);
    $sql .= "activity_type='$activity_type', ";
}

if (!empty($_POST['date_birth'])) {
    $date_birth = $_POST['date_birth'];
    $date_birth = $conn->real_escape_string($date_birth);
    $sql .= "date_birth='$date_birth', ";
}

if (!empty($_POST['location'])) {
    $location = $_POST['location'];
    $location = $conn->real_escape_string($location);
    $sql .= "location='$location', ";
}

if (!empty($_POST['province'])) {
    $province = $_POST['province'];
    $province = $conn->real_escape_string($province);
    $sql .= "province='$province', ";
}

if (!empty($_POST['country'])) {
    $country = $_POST['country'];
    $country = $conn->real_escape_string($country);
    $sql .= "country='$country', ";
}

// Eliminar la coma y el espacio extra al final de la consulta SQL
$sql = rtrim($sql, ", ");

// Agregar la cláusula WHERE para actualizar solo el usuario especificado
$sql .= " WHERE user='$user'";

if ($conn->query($sql) === TRUE) {
    // Actualizar los datos de la sesión con los valores actualizados
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['activity_type'] = $activity_type;
    $_SESSION['date_birth'] = $date_birth;
    $_SESSION['location'] = $location;
    $_SESSION['province'] = $province;
    $_SESSION['country'] = $country;

    // Reiniciar la sesión para aplicar los cambios en todo el proyecto
    session_start();
    echo "<script>alert('Registro actualizado correctamente');</script>";
} else {
    echo "<script>alert('Error al actualizar el registro: " . $conn->error . "');</script>";
}

header("Location: configuracion.php");

exit();
?>