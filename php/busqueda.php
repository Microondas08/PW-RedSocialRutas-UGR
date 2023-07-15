<?php
// Conexión a la base de datos
$mysqli = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Verificar si la conexión tuvo éxito
if ($mysqli->connect_errno) {
    echo 'Error al conectar a la base de datos: ' . $mysqli->connect_error;
    exit();
}

// Consulta a la base de datos
if (isset($_GET['searching_user'])) {
    $userName = $_GET['searching_user'];

    /* create a prepared statement */
    $stmt = $mysqli->prepare("SELECT user, email, activity_type FROM users WHERE user LIKE CONCAT('%', ?, '%')");

    /* bind parameters for markers */
    $stmt->bind_param("s", $userName);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($user, $email, $activity_type);

    /* fetch value */
    $users = array();
    while ($stmt->fetch()) {
        /* create an array with the result */
        $user = array(
            'user' => $user,
            'email' => $email,
            'activity_type' => $activity_type
        );
        array_push($users, $user);
    }

    /* close statement */
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
