<?php
    require '../config/config.php';
    require '../includes/form_handlers/register_handler.php';

?>




<html>

<head>
    <meta charset="UTF-8">
    <title>Log-in</title>
    <script src="../js/validate.js"></script>
    <script src="../js/toggle.js"></script>
    <link rel="stylesheet" href="../css/style.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script>
		$(document).ready(function(){
			$("#pais").change(function(){
				var pais = $(this).val();
				$.ajax({
					url: "ciudad.php",
					type: "POST",
					data: {pais: pais},
					success: function(data){
						$("#ciudad").html(data);
					}
				});
			});
		});
	</script>
   

</head>

<body>
    <div class="container">
        <div class="form-container" id="form-container">
            <form id="login-form" action="auth.php" method="POST" >

                <h2>Iniciar sesión</h2>
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username"><br><br>
    
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password"><br><br>
    
                <input type="submit" value="Iniciar sesión"><br><br>
                <div id="error-message"></div>

                
            </form>
           
            <div class="toggle" onclick="toggleForm()">¿No tienes una cuenta? Regístrate aquí</div>
        </div>


        <div class="form-container" id="form-container-register" style="display:none">
            
            <form action="register.php" method="POST">
                
            <label for="username">Nombre usuario:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br>
            
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required><br>
            
            <label for="surname">Apellidos:</label>
            <input type="text" id="surname" name="surname" required><br>
            
            <label for="dob">Fecha de nacimiento:</label>
            <input type="date" id="dob" name="dob" required><br>
            
            <label for="activity_type">Tipo de actividad favorita:</label>
            <input type="text" id="activity_type" name="activity_type" required><br>
            
            <label for="pais">Seleccione un país:</label>
            <?php include 'pais.php'; ?>

            <label id="ciudad">Selecciona una ciudad: </label>
            <br>


            <label for="location">Localidad:</label>
            <input type="text" id="location" name="location" required><br>
            
            
            <input type="submit" value="Register">
            </form>

            
            <div class="toggle" onclick="toggleForm()">¿Ya tienes una cuenta? Inicia sesión aquí</div>
            
            

            
        </div>

       

    </div>
    


</body>    
</html>


