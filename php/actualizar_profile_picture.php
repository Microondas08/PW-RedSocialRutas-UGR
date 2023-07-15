<?php
require '../config/config.php';
$conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Verificar si se ha enviado un archivo
if(isset($_FILES['profile_picture'])) {
    // Obtener detalles del archivo
    $nombreArchivo = $_FILES['profile_picture']['name'];
    $rutaArchivo = $_FILES['profile_picture']['tmp_name'];

    // Mover el archivo a la carpeta de imágenes
    $directorioDestino = '../images/';
    $rutaDestino = $directorioDestino . $nombreArchivo;
    move_uploaded_file($rutaArchivo, $rutaDestino);

    // Actualizar la base de datos con el nombre del archivo
    $user = $_SESSION['user'];
    // Suponiendo que ya tienes una conexión a la base de datos establecida previamente
    $query = "UPDATE users SET profile_picture = '$nombreArchivo' WHERE user = '$user'"; // Cambia "id = 1" por la condición adecuada para actualizar el perfil del usuario actual
    mysqli_query($conexion, $query);

    //echo "Imagen subida y actualizada correctamente.";
}


// Si los datos de inicio de sesión no fueron enviados, redirigir a la página de inicio de sesión
header("Location: configuracion.php");
exit();
?>


