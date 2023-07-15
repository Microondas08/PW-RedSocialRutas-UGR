//Función en JS que sirve para validar el Login, la cual recibe un evento

function validate(event) {

  console.log("La función validate() ha sido llamada");


  //event.preventDefault es un método de la Eventinterfaz 
  //le dice al agente de usuario que si el evento no se maneja explícitamente, su acción predeterminada no debe tomarse como lo haría normalmente.
  //En este caso, este método lo hemos usado para que el mensaje que responda esta función no desaparezca al instante del ser mostrado,
  //y que permanezca en pantalla hasta que se realice otra acción.
  event.preventDefault();

  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  if (username == "" || password == "") {
    document.getElementById("error-message").innerHTML = "Por favor, rellena todos los campos";
    return false;
  }

  document.getElementById("error-message").innerHTML = "¡La validación fue exitosa!";

  // Aquí se podrían agregar más validaciones, como verificar que el usuario y contraseña sean correctos.
}
