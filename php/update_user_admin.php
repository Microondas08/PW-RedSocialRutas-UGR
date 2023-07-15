<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $actividad_id = $_POST['actividad_id'];
    $titulo = $_POST['titulo'];
    $map_path = $_POST['map_path'];
    $aplausos = $_POST['aplausos'];
    $user_id = $_POST['user_id'];
    $usuarios_aplaudieron = $_POST['usuarios_aplaudieron'];

    $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");


    // Construir la consulta SQL
    $sql = "UPDATE posts SET ";

    // Verificar cada columna y agregarla a la consulta SQL solo si se proporciona un valor
    if (!empty($actividad_id)) {
        $actividad_id = $conn->real_escape_string($actividad_id);
        $sql .= "actividad_id='$actividad_id', ";
    }

    if (!empty($titulo)) {
        $titulo = $conn->real_escape_string($titulo);
        $sql .= "titulo='$titulo', ";
    }

    if (!empty($map_path)) {
        $map_path = $conn->real_escape_string($map_path);
        $sql .= "map_path='$map_path', ";
    }

    if (!empty($aplausos)) {
        $aplausos = $conn->real_escape_string($aplausos);
        $sql .= "aplausos='$aplausos', ";
    }

    if (!empty($user_id)) {
        $user_id = $conn->real_escape_string($user_id);
        $sql .= "user_id='$user_id', ";
    }

    if (!empty($usuarios_aplaudieron)) {
        $usuarios_aplaudieron = $conn->real_escape_string($usuarios_aplaudieron);
        $sql .= "usuarios_aplaudieron='$usuarios_aplaudieron', ";
    }

    // Eliminar la coma y el espacio extra al final de la consulta SQL
    $sql = rtrim($sql, ", ");

    // Agregar la cláusula WHERE para actualizar solo el registro especificado
    $sql .= " WHERE id='$id'";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Los datos se actualizaron correctamente.');</script>";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    header("Location: configuracion.php");

}
?>