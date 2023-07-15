<?php
include("../includes/header.php");
?>
<div class="configuracion">
<?php
// Verificar si el usuario tiene rol de administrador
if ($_SESSION['rol'] == 1) {
    // Comprobar si se proporcionó un nombre de usuario válido
    if (isset($_GET['user'])) {
        $username = $_GET['user'];


        $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        // Consultar y mostrar los datos del usuario seleccionado
        $sql = "SELECT * FROM users WHERE user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Conexión a la base de datos
        $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

        // Verificar si la conexión tuvo éxito
        if ($conn->connect_errno) {
            echo 'Error al conectar a la base de datos: ' . $conn->connect_error;
            exit();
        }

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta SQL para obtener los nombres de tipo de actividad junto con los identificadores
        $sql = "SELECT Identificador, Nombre FROM tipoactividad";
        $resultoptions = $conn->query($sql);

        $options = '';
        if ($result->num_rows > 0) {
            // Recorrer los resultados y generar las opciones
            while ($row = $resultoptions->fetch_assoc()) {
                $activity_id = $row["Identificador"];
                $activity_name = $row["Nombre"];
                $options .= "<option value=\"$activity_name\">$activity_name</option>";
            }
        }



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mostrar los datos del usuario en un formulario de modificación
            echo "<h2>Modificar usuario: " . $row['user'] . "</h2>";
            echo "<form action='guardar_usuario.php' method='POST'>";
            echo "Nombre: <input type='text' name='name' value='" . $row['name'] . "'><br>";
            echo "Apellido: <input type='text' name='surname' value='" . $row['surname'] . "'><br>";
            echo "Fecha de nacimiento: <input type='date' name='date_birth' value='" . $row['date_birth'] . "'><br>";
            echo "Tipo de actividad: <select  name='activity_type' value= ".$row['activity_type']. "required> echo $options;</select><br>";
            echo "<input type='hidden' name='rol' value='".$row['rol']."'></input>";
            echo "Ubicación: <input type='text' name='location' value='" . $row['location'] . "'><br>";
            echo "Provincia: <input type='text' name='province' value='" . $row['province'] . "'><br>";
            echo "País: <input type='text' name='country' value='" . $row['country'] . "'><br>";
            echo "<br>";
            echo "Fecha de terminación: <input type='date' name='termination_date' value='" . $row['termination_date'] . "'><br>";
            echo "<input type='hidden' name='user' value='" . $row['user'] . "'>";
            echo "<input type='submit' value='Guardar'>";
            echo "</form>";


            // Mostrar los datos del usuario en un formulario de modificación
            echo "<h2>Modificar rol: </h2>";
            echo "<form action='guardar_usuario.php' method='POST'>";
            echo "<input type='hidden' name='name' value='" . $row['name'] . "'>";
            echo "<input type='hidden' name='surname' value='" . $row['surname'] . "'>";
            echo "<input type='hidden' name='date_birth' value='" . $row['date_birth'] . "'>";
            echo "<input  type='hidden' value= " . $row['activity_type'] . "required></input>";
            echo "<input type='hidden' name='location' value='" . $row['location'] . "'>";
            echo "<input type='hidden' name='province' value='" . $row['province'] . "'>";
            echo "<input type='hidden' name='country' value='" . $row['country'] . "'>";
            echo "<input type='hidden' name='termination_date' value='" . $row['termination_date'] . "'>";
            echo "<input type='hidden' name='user' value='" . $row['user'] . "'>";
            if ($row['rol'] == 0) {
                echo "Rol: ";
                echo "<input type='submit' name='rol' value='1'>Hacer admin</input>";
            } else if ($row['rol'] == 1) {
                echo "Rol: ";
                echo "<input type='submit'  name='rol'  value='0'>Quitar privilegios admin</input>";
            }
            echo "</form>";

            // Consultar y mostrar los datos de la tabla posts relacionados con el usuario seleccionado
            $sql = "SELECT * FROM posts WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

           

    } else {
        echo "No se proporcionó un nombre de usuario válido.";
    }
} else {
    echo "<h2>No tienes permisos de administrador.</h2>";
}
}
?>


<?php
$user = $_SESSION['user'];
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Aquí deberías obtener el estado del usuario desde la base de datos y almacenarlo en una variable
$sql = "SELECT termination_date FROM users WHERE user = '$username'";
$result = $conn->query($sql);

// Verificar si se obtuvo algún resultado
// Obtener el valor de termination_date
$row = $result->fetch_assoc();
$terminationDate = $row['termination_date'];

// Comprobar si termination_date es NULL o no
if ($terminationDate === NULL) {
    // termination_date es NULL

    echo "<form action='dar_alta_baja_user.php' method='post'>
                <input type='hidden' name='username' value='$username'>
              <input type='submit' name='dar_de_baja' value='Dar de baja' class= 'warning'>
          </form>";
} else {

    // termination_date no es NULL
    echo "<form action='dar_alta_baja_user.php' method='post'>
               <input type='hidden' name='username' value='$username'>
              <input type='submit' name='dar_de_alta' value='Dar de alta'></input>
          </form>";


}
$conn->close();


?>



</div>