<?php
    require '../config/config.php';

?>  
<html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/style.css">
        <title>Mi Red Social de Senderismo</title>


    </head>
    <body>

        <header>
            
            <nav>
                <ul><?php
                    if ($_SESSION['rol'] == 1) {
                        echo "<li class='logo'><a href='../php/index_admin.php'><img src='../icons/home.png' alt='Inicio' style='width: 20%;'></a></li>";
                    }else{
                    echo "<li class='logo'><a href='../php/index.php'><img src='../icons/home.png' alt='Inicio' style='width: 20%;'></a></li>";

                }
                ?>
                <?php
                $conexion = mysqli_connect("localhost", "root", "", "redsocialrutas");

                // Suponiendo que tienes una conexión a la base de datos establecida previamente
                $user = $_SESSION['user'];
                // Obtener el valor de la columna "profile_picture" de la base de datos
                $query = "SELECT profile_picture FROM users WHERE user = '$user' "; 
                $result = mysqli_query($conexion, $query);
                $row = mysqli_fetch_assoc($result);
                $profilePicture = $row['profile_picture'];

                // Verificar si la columna "profile_picture" es nula
                if ($profilePicture === null) {
                    echo '<li><a href="../php/perfil.php"><img src="../icons/running.png" alt="Perfil" style="width: 20%;"></a></li>';
                } else {
                    // Mostrar la imagen devuelta por la base de datos
                    echo '<li><a href="../php/perfil.php"><img src="../images/' . $profilePicture . '" alt="Perfil" style="width: 25; height: 25; border-radius: 15px;margin-left: auto;margin-right: auto;"></a></li>';
                }

                // Cerrar la conexión a la base de datos si es necesario
                mysqli_close($conexion);
                ?>
                    <li><a href="../php/configuracion.php"><img src="../icons/settings.png" alt="Configuración" style="width: 20%;"></a></li>
                </ul>

                <form action="resultado_busqueda_submit.php" method="get">
                    <label for="search"></label>
                    <input type="text" id="search" name="searching_user" placeholder="Búsqueda de usuario">
                    <button type="submit">Buscar</button>
                </form>
                
                <div class="header_name_user">
                    
                    <strong><?php echo $_SESSION['name'] ;?><br><?php echo $_SESSION['surname'] ;?></strong>

                </div>
                
                <div class="header_name_user">
                    <strong>
                        <?php echo '(' . $_SESSION['user'] . ')'; ?>
                    </strong>

                </div>
                
                <div>
                <?php
                    if ($_SESSION['rol'] == 1) {
                        echo '<h2> you are admin</h2>';
                    }
                ?>
                </div>
            </nav>

            <div class="search-results" style="display: none;"></div>

            <script src="../js/busqueda.js"></script>


        </header>


        
