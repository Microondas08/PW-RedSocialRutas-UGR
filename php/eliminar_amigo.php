<?php


// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Obtener los IDs de los usuarios desde el cuerpo de la petición
$usuario1 = mysqli_real_escape_string($conn, $_POST['usuario1']);
$usuario2 = mysqli_real_escape_string($conn, $_POST['usuario2']);

// Comprobar si los usuarios son amigos
$sql = "SELECT COUNT(*) AS count FROM friendship WHERE (usuario1 = '$usuario1' AND usuario2 = '$usuario2') OR (usuario1 = '$usuario2' AND usuario2 = '$usuario1')";
$resultado = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($resultado);

if ($row['count'] > 0) {
    // Eliminar el registro de amistad
    $sql = "DELETE FROM friendship WHERE (usuario1 = '$usuario1' AND usuario2 = '$usuario2') OR (usuario1 = '$usuario2' AND usuario2 = '$usuario1')";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        echo "¡Amigo eliminado con éxito!";
    } else {
        echo "Error al eliminar amigo: " . mysqli_error($conn);
    }
} else {
    // Los usuarios no son amigos
    echo "Los usuarios no son amigos.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

?>