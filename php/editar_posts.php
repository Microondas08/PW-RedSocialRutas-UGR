<?php
include("../includes/header.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }


    // Consulta SQL para obtener los datos del post con el ID especificado
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Mostrar los datos
        while ($row = $result->fetch_assoc()) {
            $connoption = mysqli_connect("localhost", "root", "", "redsocialrutas");

            // Consulta SQL para obtener los nombres de tipo de actividad junto con los identificadores
            $sqloption = "SELECT Identificador, Nombre FROM tipoactividad";
            $resultoptions = $connoption->query($sqloption);

            $options = '';
            if ($result->num_rows > 0) {
                // Recorrer los resultados y generar las opciones
                while ($rowoption = $resultoptions->fetch_assoc()) {
                    $activity_id = $rowoption["Identificador"];
                    $activity_name = $rowoption["Nombre"];
                    $options .= "<option value=\"$activity_id   \">$activity_name</option>";
                }
            }

            ?>
            <div class="div_publicar">
                    <form method="POST" action="update_user_admin.php">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <label for="actividad_id">Actividad ID:</label>
                    <select id="actividad_id" name="actividad_id" value="<?php echo $activity_name ?>"required>
                        <?php echo $options; ?>
                    </select> <br>                   
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" value="<?php echo $row['titulo'] ?>"><br>
                    <label for="map_path">Map Path:</label>
                    <input type="text" name="map_path" value="<?php echo $row['map_path'] ?>"><br>
                    <label for="aplausos">Aplausos:</label>
                    <input type="text" name="aplausos" value="<?php echo $row['aplausos'] ?>"><br>
                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" value="<?php echo $row['user_id'] ?>"readonly required><br>
                    
                    <input type="submit" value="Actualizar">
                </form>
            </div>

            <div style="background-color: rgb(245, 234, 191);border-radius: 15px;">
            <?php
           
                // Consultar y mostrar los nombres de las imágenes relacionadas con el ID proporcionado
                $sql = "SELECT i.id, i.nombre FROM imagenes i INNER JOIN posts_imagenes pi ON i.id = pi.imagen_id WHERE pi.post_id = '$id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<h2>Nombres de las imágenes relacionadas con el ID: " . $id . "</h2>";
                    while ($row = $result->fetch_assoc()) {
                        echo $row['nombre'] . " ";
                        $imagen_url = '../images/';
                        $imagen_completa = $imagen_url . basename($row['nombre']);

                        echo "<form method='post' action='eliminar_imagen.php'>
                                <img src=' $imagen_completa' alt='Imagen'>
                                <input type='hidden' name='id_post' value='$id'>
                                <input type='hidden' name='eliminar_imagen' value='".$row['id']."'>
                                <input type='submit' value='Eliminar' class='warning'>
                            </form><br>";
                    }
                } 
                ?>
                <?php
        }
    } else {
        echo "No se encontraron resultados.";
    }
} else {
    echo "No se ha proporcionado un ID válido.";
}
?>
</div>