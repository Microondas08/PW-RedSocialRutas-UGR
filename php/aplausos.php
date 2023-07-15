<?php
require '../config/config.php';

$conexion_aplausos = mysqli_connect("localhost", "root", "", "redsocialrutas");

$postId = $_POST['id'];

// Obtener el ID de usuario de la sesión actual
$userId = $_SESSION['user'];


echo $postId . " ". $userId;
// Verificar la conexión
if ($conexion_aplausos->connect_error) {
    die("Error de conexión: " . $conexion_aplausos->connect_error);
}

// Verificar si el usuario ya ha aplaudido el post
$sql = "SELECT user_id FROM usuarios_posts_aplaudieron WHERE user_id = '$userId' AND post_id = $postId";
$result = $conexion_aplausos->query($sql);

if ($result->num_rows === 0) {
    // El usuario no ha aplaudido el post, agregar un nuevo registro en usuarios_posts_aplaudieron
    $insertSql = "INSERT INTO usuarios_posts_aplaudieron (user_id, post_id) VALUES ('$userId', $postId)";
    $conexion_aplausos->query($insertSql);

    // Aumentar el número de aplausos en la tabla posts
    $updateSql = "UPDATE posts SET aplausos = aplausos + 1 WHERE id = $postId";
    $conexion_aplausos->query($updateSql);
}else{
    // Aumentar el número de aplausos en la tabla posts
    $updateSql = "UPDATE posts SET aplausos = aplausos + 1 WHERE id = $postId";
    $conexion_aplausos->query($updateSql);
}



// Cerrar la conexión
$conexion_aplausos->close();

$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

$sql = "SELECT * FROM users WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId); // "s" indica que $userId es una cadena
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

if ($row['rol'] == 0) {
    header("Location: index.php");
} else if ($row['rol'] == 1) {
    header("Location: index_admin.php");
}

// Redirigir al usuario a la página del post después de aplaudir  

?>