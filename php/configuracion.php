<?php
    include("../includes/header.php");
    include("../php/column_profile.php")
    ?>
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

<div class="Configuracion">
  <form action="update_user.php" method="POST">
    <label for="user">Usuario:</label>
    <input type="text" id="user" name="user" value="<?php echo $_SESSION['user']; ?>" readonly><br>

    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>"><br>

    <label for="surname">Apellido:</label>
    <input type="text" id="surname" name="surname" value="<?php echo $_SESSION['surname']; ?>"><br>

    <label for="activity_type">Tipo de Actividad:</label>
    <input type="text" id="activity_type" name="activity_type" value="<?php echo $_SESSION['activity_type']; ?>"><br>

    <label for="date_birth">Fecha de Nacimiento:</label>
    <input type="text" id="date_birth" name="date_birth" value="<?php echo $_SESSION['date_birth']; ?>"><br>

    <label for="pais">Seleccione un país:</label>
    <?php include 'pais.php'; ?>
    <br>

    <?php echo "Selecciona una ciudad: "; ?><br>

    <label id="ciudad"></label>  
    <br>
    <input type="submit" value="Modificar">
  </form>
</div>


<div class="Configuracion">

  <form action="actualizar_profile_picture.php" method="POST" enctype="multipart/form-data">
      <label for="profile_picture">Selecciona una imagen para actualizar tu foto de perfil: </label>
      <input type="file" name="profile_picture" id="profile_picture">
      <br><br>
      <input type="submit" value="Subir Imagen">
  </form>

</div>



<?php

$user = $_SESSION['user'];
$conn = mysqli_connect("localhost", "root", "", "redsocialrutas");

// Aquí deberías obtener el estado del usuario desde la base de datos y almacenarlo en una variable
$sql = "SELECT termination_date, rol FROM users WHERE user = '$user'";
$result = $conn->query($sql);

// Verificar si se obtuvo algún resultado

// Obtener el valor de termination_date
$row = $result->fetch_assoc();
$terminationDate = $row['termination_date'];
if($row['rol']==1){

?>
<div class="Configuracion">


  <a href="editar_provincia_localidad.php"  enctype="multipart/form-data">Editar localidades y provincias</a>

</div>
<?php

}
// Comprobar si termination_date es NULL o no
if ($terminationDate === NULL) {
  // termination_date es NULL

  echo "<form action='dar_alta_baja_user.php' method='post'>
              <input type='submit' name='dar_de_baja' value='Dar de baja' class= 'warning'>
          </form>";
} else {

  // termination_date no es NULL
  echo '<form action="dar_alta_baja_user.php" method="post">
              <br><br><input type="submit" name="dar_de_alta" value="Dar de alta"></input>
          </form>';

}



$conn->close();

?>
</body>
</html>