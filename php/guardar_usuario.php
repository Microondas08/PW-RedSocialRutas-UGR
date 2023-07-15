

<?php
require '../config/config.php';

// Verificar si el usuario tiene rol de administrador
if ($_SESSION['rol'] == 1) {
    // Comprobar si se enviaron los datos del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $date_birth = $_POST['date_birth'];
        $activity_type = $_POST['activity_type'];
        $location = $_POST['location'];
        $province = $_POST['province'];
        $country = $_POST['country'];
        $rol = $_POST['rol'];
        $termination_date = NULL;
        $user = $_POST['user'];

    

        $conn = mysqli_connect("localhost", "root", "", "redsocialrutas");
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        // Actualizar los datos del usuario en la base de datos
        $sql = "UPDATE users SET name=?, surname=?, date_birth=?, activity_type=?, location=?, province=?, country=?, rol=?, termination_date=? WHERE user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $name, $surname, $date_birth, $activity_type, $location, $province, $country, $rol, $termination_date, $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Los datos del usuario se actualizaron correctamente.";
        } else {
            echo "No se pudo actualizar los datos del usuario.";
        }

        $conn->close();
    } else {
        echo "No se enviaron los datos del formulario.";
    }
} else {
    echo "<h2>No tienes permisos de administrador.</h2>";
}

header('Location: configuracion.php');

?>