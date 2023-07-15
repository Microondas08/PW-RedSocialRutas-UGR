<?php

// Conectar a la base de datos
$mysqli = mysqli_connect("localhost", "root", "", "redsocialrutas");

session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Recuperar los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $query = "SELECT * FROM users WHERE user = '$username' AND password = '$password'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) == 1) {
        // El usuario y contraseña son correctos, guardar los datos en sesión
        $query = "SELECT * FROM users WHERE user = '$username'";
        $result = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($result) == 1) {
            // Si se encontró un único registro, guardar la información en la variable de sesión
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user'] = $row['user'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['date_birth'] = $row['date_birth'];
            $_SESSION['activity_type'] = $row['activity_type'];
            $_SESSION['location'] = $row['location'];
            $_SESSION['province'] = $row['province'];
            $_SESSION['country'] = $row['country'];
            $_SESSION['rol'] = $row['rol'];

            // Redireccionar según el valor de $_SESSION['rol']
            if ($_SESSION['rol'] == 0) {
                header("Location: index.php");
            } elseif ($_SESSION['rol'] == 1) {
                header("Location: index_admin.php");
            }
            exit();
        }
    } else {
        // El usuario y contraseña no son correctos, mostrar un mensaje de error
        echo '<script>
                alert("Usuario o contraseña incorrectos");
                setTimeout(function() {
                    window.location.href = "login.php";
                }, 100);
            </script>';
    }
} else {
    // Si los datos de inicio de sesión no fueron enviados, redirigir a la página de inicio de sesión
    header("Location: login.php");
    exit();
}
?>