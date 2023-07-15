<tr>

    <div class="columna_izq_index">
        <?php
        $conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");

        // Suponiendo que tienes una conexión a la base de datos establecida previamente
        $user = $_SESSION['user'];
        // Obtener el valor de la columna "profile_picture" de la base de datos
        $query = "SELECT profile_picture, name, surname, activity_type FROM users WHERE user = '$user' ";
        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);
        $profilePicture = $row['profile_picture'];
        $name = $row['name'];
        $surname = $row['surname'];
        $activity_type = $row['activity_type'];
        // Verificar si la columna "profile_picture" es nula
        if ($profilePicture === null) {
            echo '<li><a href="../php/perfil.php"><img src="../icons/running.png" alt="Perfil" style="width: 20%;"></a></li>';
        } else {
            // Mostrar la imagen devuelta por la base de datos
            echo '<li><a href="../php/perfil.php"><img src="../images/' . $profilePicture . '" alt="Perfil" style="height: 150px; margin-left: auto;margin-right: auto; border-radius: 10px;"></a></li>';
        }

        // Cerrar la conexión a la base de datos si es necesario
        mysqli_close($conexion);
        ?>        <h2><?php echo $name ;?><br><?php echo $surname ;?></h2>
        <h2><?php echo '('. $user .')'; ?></h2>

        <?php 
        
        if ($_SESSION['rol'] == 1){
            echo '<h2> your are admin</h2>';
        }
        ?>
        
        <table class="actividad_preferida">
            <tr>
            <td><strong>Actividad preferida:</strong> <?php echo $_SESSION['activity_type']?></td>
            </tr>
        </table>
        <?php
        // Conexión a la base de datos
        $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

        $user = $_SESSION['user'];

        $sql = "SELECT usuario1, usuario2 FROM friendship WHERE usuario1 = '$user' OR usuario2 = '$user'";
        $resultado = mysqli_query($conn, $sql);
        echo '<table class="actividad_preferida">';
        echo '<tr>';
        // Comprobar si se encontraron amigos
        if (mysqli_num_rows($resultado) > 0) {
            echo '<td><strong>Amigos:</strong></td>';
            echo '</tr><br>';

            // Mostrar cada amigo en una fila de la tabla
            while ($row = mysqli_fetch_assoc($resultado)) {
                $amigo1 = $row['usuario1'];
                $amigo2 = $row['usuario2'];
                $amigo = ($amigo1 === $user) ? $amigo2 : $amigo1;
                echo '<tr>';
                echo '<td><a href="../php/resultado_busqueda.php?user='.$amigo.'"><img src="../images/running.png" alt="Avatar del usuario" style="width: 10%;"> ' . $amigo . '</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<br><br><br><tr><td>No tienes amigos.</td></tr>';
        }

        echo '</table>';


        // Cerrar la conexión a la base de datos
            mysqli_close($conn);

            ?>
    </div>
</tr>