<?php
include("../includes/header.php");
    

?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulario de inserción de provincia y pais</title>
</head>
<body>
  <h1>Formulario de inserción</h1>
  <div class="configuracion">
   <form action="insertar_provincia_pais.php" method="POST">
      <label for="Paises_Codigo">Código del país:</label>
      <input type="text" name="Paises_Codigo" maxlength="2" required><br>

      <label for="Ciudad">Nombre de la ciudad:</label>
      <input type="text" name="Ciudad" required><br>

      <label for="Pais">Nombre del país:</label>
      <input type="text" name="Pais" required><br>

      <input type="submit" value="Insertar">
    </form>
  </div>
  <h1>Formulario para eliminar provincia y pais</h1>

  <div class="configuracion">
    <form action="eliminar_provincia_pais.php" method="POST">
    <label for="eliminarPais">Eliminar un País:</label>
    <input type="checkbox" name="eliminarPais" value="1"><br><br>

    <label for="eliminarCiudad">Eliminar una Ciudad:</label>
    <input type="checkbox" name="eliminarCiudad" value="1"><br><br>

    <label for="Codigo">Código del País:</label>
    <input type="text" name="Codigo" maxlength="2"><br><br>

    <label for="Ciudad">Nombre de la Ciudad:</label>
    <input type="text" name="Ciudad"><br><br>

    <input type="submit" value="Eliminar">
  </form>
  </div>
</body>
</html>
