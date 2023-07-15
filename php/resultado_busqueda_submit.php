<?php
include("../includes/header.php");
include("../php/column_profile.php");
include("busqueda.php");
?>

<head>
    <!-- Incluir la librería jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Otras etiquetas del encabezado -->
</head>

<tr>
    <div class="columna_dcha_index">

        <ul>

            <?php

            // Conexión a la base de datos
            $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

            // IDs de los usuarios a comprobar
            $usuario1 = mysqli_real_escape_string($conn, $_SESSION['user']);

            if (isset($users) && is_array($users)) {

                foreach ($users as $user) {
                    echo "<div class='columna_dcha_index'>";

                    /*
                    TENER QUE EDITAR RESULTADO_BUSQUEDA PARA ACCEDER AL USUARIO Y SUS PUBLICACIONES SI SON AMIGOS
                    */
                    echo "<a href='resultado_busqueda.php?user=" . urlencode($user['user']) . "'><li><img src='../images/running.png' alt='Avatar del usuario' style='width: 50px;'><strong>" . htmlspecialchars($user['user']) . "</strong></li></a><br><br>";
                    echo "</div>";

                    $usuario2 = mysqli_real_escape_string($conn, $user['user']);

                    // Consulta SQL para comprobar si los usuarios son amigos
                    $sql = "SELECT * FROM friendship WHERE (usuario1 = '$usuario1' AND usuario2 = '$usuario2') OR (usuario1 = '$usuario2' AND usuario2 = '$usuario1')";

                    // Ejecutar la consulta
                    $resultado = mysqli_query($conn, $sql);

                    // Comprobar si existe una fila en la consulta
                    if (mysqli_num_rows($resultado) > 0) {
                        // Si los usuarios son amigos, mostrar botón "Eliminar amigo"
                        echo '<button onclick="eliminarAmigo(\'' . $usuario2 . '\')">Eliminar amigo</button>';
                    } else {
                        // Si los usuarios no son amigos, mostrar botón "Agregar amigo"
                        echo '<button onclick="agregarAmigo(\'' . $usuario2 . '\')">Agregar amigo</button>';
                    }
                }

                // Función para agregar amigo
                echo '<script>
                function agregarAmigo(usuario) {
                    $.ajax({
                        type: "POST",
                        url: "agregar_amigo.php",
                        data: { usuario1: "' . $usuario1 . '", usuario2: usuario },
                        success: function(response){
                            // Mostrar mensaje de éxito
                            alert(response);
                            // Recargar la página
                            location.reload();
                        }
                    });
                }
                </script>';

                // Función para eliminar amigo
                echo '<script>
                function eliminarAmigo(usuario) {
                    $.ajax({
                        type: "POST",
                        url: "eliminar_amigo.php",
                        data: { usuario1: "' . $usuario1 . '", usuario2: usuario },
                        success: function(response){
                            // Mostrar mensaje de éxito
                            alert(response);
                            // Recargar la página
                            location.reload();
                        }
                    });
                }
                </script>';

                // Cerrar la conexión a la base de datos
                mysqli_close($conn);
            } else {
                echo "No se encontraron resultados de búsqueda.";
            }
            ?>

        </ul>
    </div>
</tr>