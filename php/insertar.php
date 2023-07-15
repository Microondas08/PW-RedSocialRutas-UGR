<?php
// Obtener los valores enviados desde el formulario
$actividad_id = $_POST['actividad_id'];
$titulo = $_POST['titulo'];
$user_id = $_POST['user_id'];
$usuariosSeleccionados = $_POST['usuarios'];

// Insertar la información de la imagen en la tabla imagenes
$conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");



// Directorio de almacenamiento para mapas e imágenes
$map_directory =  dirname(__DIR__).'\maps\\';
$imagenes_directory = dirname(__DIR__) . '\images\\';

// Obtener la ruta completa y nombre del archivo de mapa
$map_file_name = $_FILES['map_file']['name'];
$map_file_tmp = $_FILES['map_file']['tmp_name'];

$map_file_name = basename($map_file_name);

// Mover el archivo de mapa al directorio de almacenamiento
move_uploaded_file($map_file_tmp, $map_file_name);


// Construir la consulta de inserción
$sql = "INSERT INTO `posts` ( `actividad_id`, `titulo`, `map_path`,  `aplausos`, `user_id` )
VALUES ($actividad_id, '$titulo', '$map_file_name',  NULL, '$user_id')";

$conexion->query($sql);


// Consulta SQL para obtener el último ID generado en la tabla posts
$query = "SELECT LAST_INSERT_ID() AS ultimo_id FROM posts";
$result = $conexion->query($query);

// Obtener el resultado de la consulta
$row = $result->fetch_assoc();

// Almacenar el último ID generado en una variable entera
$ultimoIDposts = (int) $row['ultimo_id'];
//----------------------------------------------------------------------------------------

// Comprobar que los usuarios existen en la tabla users
$existingUsers = array();
foreach ($usuariosSeleccionados as $usuario) {
    $stmt = $conexion->prepare("SELECT user FROM users WHERE user = ?");
    $stmt->bind_param('s', $usuario); // Utiliza $usuario en lugar de $user
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $existingUsers[] = $usuario; // Utiliza $usuario en lugar de $user
    }
    $stmt->close();
}

// Insertar los usuarios relacionados en la tabla user_posts
$stmt = $conexion->prepare("INSERT INTO user_posts (user_id, post_id) VALUES (?, ?)");
$stmt->bind_param("ss", $user_id, $ultimoIDposts);
foreach ($usuariosSeleccionados as $usuario) {
    $user_id = $usuario; // Asigna el ID del usuario correspondiente
    $stmt->execute();
}
$stmt->close();


//----------------------------------------------------------------------------------------
// Obtener el path y nombre del archivo recibido del formulario
$imagen_paths = $_FILES['imagenes_files']['name'];


// Obtener el ID de la imagen recién insertada
$imagenes_id = $conexion->insert_id;



// Verificar si los compañeros existen en la tabla "users"

if ($conexion->connect_error) {
    echo '<script>alert("Error de conexión: ' . $conexion->connect_error . '");</script>';
} else {
        // Obtener el path y nombre del archivo recibido del formulario
        $imagen_files = $_FILES['imagenes_files'];

        // Recorrer los archivos de imagen recibidos
        for ($i = 0; $i < count($imagen_files['name']); $i++) {
                // Obtener el nombre del archivo
                $nombre_archivo = basename($imagen_files['name'][$i]);

                $ruta_destino = $imagenes_directory . $nombre_archivo;

                // Mover la imagen al directorio deseado en el proyecto
                move_uploaded_file($imagen_files['tmp_name'][$i], $ruta_destino);

                $nombre_imagen = $conexion->real_escape_string($nombre_archivo);

                // Obtener el tamaño del archivo en bytes
                $tamaño_bytes = $imagen_files['size'][$i];

                // Convertir el tamaño en bytes a KB
                $tamaño_kb = $tamaño_bytes / 1024; 

                // Convertir el tamaño en MB a un entero redondeado
                $tamaño_entero = round($tamaño_kb, 4);

                $imagen_info = getimagesize($ruta_destino);

                $alto_imagen = $conexion->real_escape_string($imagen_info[1]);
                $ancho_imagen = $conexion->real_escape_string($imagen_info[0]);


                
                // Crear la consulta de inserción
                $sql = "INSERT INTO imagenes ( nombre, tamaño, alto, ancho) VALUES ( '$nombre_archivo', $tamaño_entero, $alto_imagen, $ancho_imagen)";

                $conexion->query($sql);

                


                // Consulta SQL para obtener el último ID generado en la tabla posts
                $query = "SELECT LAST_INSERT_ID() AS ultimo_id FROM imagenes";
                $result = $conexion->query($query);

                // Obtener el resultado de la consulta
                $row = $result->fetch_assoc();

                // Almacenar el último ID generado en una variable entera
                $ultimoIDimagen = (int) $row['ultimo_id'];
                


            mysqli_query($conexion, "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");


            $query ="INSERT INTO posts_imagenes (imagen_id, post_id)
                VALUES ( '$ultimoIDimagen', '$ultimoIDposts')";
            
                $conexion->query($query);
            mysqli_query($conexion, "SET sql_mode = ''");


        }


        }


    // Ejecutar la consulta de inserción
    if ($conexion->query($sql) === TRUE) {
        echo '<script>alert("Los datos han sido insertados exitosamente.");</script>';
    } else {
        echo '<script>alert("Error al insertar los datos : ' . $conexion->error . '");</script>';
    }
    



$conexion->close();

echo '<script>window.location.href = "perfil.php";</script>';
?>

