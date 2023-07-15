<?php

// Verificar si se ha enviado una solicitud para eliminar una imagen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_imagen"])) {
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

    // Obtener el ID de la imagen a eliminar
$imagen_id = $_POST["eliminar_imagen"];

// Eliminar los registros relacionados en la tabla 'posts_imagenes'
$sql_delete_posts_imagenes = "DELETE FROM posts_imagenes WHERE imagen_id = '$imagen_id'";
$conn->query($sql_delete_posts_imagenes);

// Eliminar la imagen de la tabla 'imagenes'
$sql_delete_imagenes = "DELETE FROM imagenes WHERE id = '$imagen_id'";
$conn->query($sql_delete_imagenes);

echo "<script>alert('Imagen eliminada exisitosamente');</script>";


header("Location: configuracion.php");

}
?>