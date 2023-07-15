<?php
require '../config/config.php';


// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Obtener los IDs de los usuarios desde el cuerpo de la petición
$usuario1 = mysqli_real_escape_string($conn, $_POST['usuario1']);
$usuario2 = mysqli_real_escape_string($conn, $_POST['usuario2']);


// Obtener la fecha actual del sistema
$fecha = date("Y-m-d");

if ($usuario1 == $usuario2) {
    // El usuario intenta agregar su propio nombre como amigo
    echo "No puedes agregarte a ti mismo como amigo.";
} else {
    // Comprobar si los usuarios no son amigos ya
    $sql = "SELECT COUNT(*) AS count FROM friendship WHERE (usuario1 = '$usuario1' AND usuario2 = '$usuario2') OR (usuario1 = '$usuario2' AND usuario2 = '$usuario1')";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        $row = mysqli_fetch_assoc($resultado);

        if ($row['count'] == 0) {
            // Insertar un nuevo registro en la tabla amistades
            $sql = "INSERT INTO friendship (usuario1, usuario2, fecha_amistad) VALUES ('$usuario1', '$usuario2', '$fecha')";
            $resultado = mysqli_query($conn, $sql);

            if ($resultado) {
                echo "¡Amigo agregado con éxito!";
            } else {
                echo "Error al agregar amigo: " . mysqli_error($conn);
            }
        } else {
            // Los usuarios ya son amigos
            echo "Los usuarios ya son amigos.";
        }
    } else {
        echo "Error al consultar la base de datos: " . mysqli_error($conn);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>