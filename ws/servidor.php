<?php
// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Verificar la conexión
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Obtener el parámetro de consulta
$query = $_GET['query'];

// Consultar los usuarios basados en la query
$sql = "SELECT * FROM users WHERE user LIKE '%$query%'";
$result = $conn->query($sql);

// Crear un array para almacenar los usuarios
$users = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array de usuarios
    while ($row = $result->fetch_assoc()) {
        $user = array(
            'user' => $row['user'],
            'name' => $row['name'],
            'activity_type' => $row['activity_type']
            // Agrega más propiedades si es necesario
        );

        $users[] = $user;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($users);
?>