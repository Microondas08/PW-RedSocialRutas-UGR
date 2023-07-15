function toggleForm() {
  // obtenemos los elementos del DOM
  var loginForm = document.getElementById("form-container");
  var registerForm = document.getElementById("form-container-register");

  // comprobamos si el formulario de login está visible
  var isLoginFormVisible =
    window.getComputedStyle(loginForm).getPropertyValue("display") === "block";

  // si el formulario de login está visible, lo ocultamos y mostramos el formulario de registro
  if (isLoginFormVisible) {
    // reducimos la opacidad del formulario de login gradualmente
    loginForm.style.opacity = "0";
    loginForm.style.transition = "opacity 0.5s ease-in-out";

    // una vez se ha reducido la opacidad, lo ocultamos y mostramos el formulario de registro
    setTimeout(function () {
      loginForm.style.display = "none";
      registerForm.style.display = "block";
      // aumentamos la opacidad del formulario de registro gradualmente
      registerForm.style.opacity = "1";
      registerForm.style.transition = "opacity 0.5s ease-in-out";
    }, 200);

  // si el formulario de login no está visible, lo mostramos y ocultamos el formulario de registro
  } else {
   
    // reducimos la opacidad del formulario de registro gradualmente
    registerForm.style.opacity = "0";
    registerForm.style.transition = "opacity 0.5s ease-in-out";

    // una vez se ha reducido la opacidad, lo ocultamos y mostramos el formulario de login
    setTimeout(function () {
      registerForm.style.display = "none";
      loginForm.style.display = "block";

      // aumentamos la opacidad del formulario de login gradualmente
      loginForm.style.opacity = "1";
      loginForm.style.transition = "opacity 0.5s ease-in-out";
    }, 200);
  }
}

function register(event) {
  console.log("La función validate() ha sido llamada");

  //event.preventDefault es un método de la Eventinterfaz
  //le dice al agente de usuario que si el evento no se maneja explícitamente, su acción predeterminada no debe tomarse como lo haría normalmente.
  //En este caso, este método lo hemos usado para que el mensaje que responda esta función no desaparezca al instante del ser mostrado,
  //y que permanezca en pantalla hasta que se realice otra acción.

  event.preventDefault();

  var newUsername = document.getElementById("new-username").value;
  var newPassword = document.getElementById("new-password").value;
  var confirmPassword = document.getElementById("confirm-password").value;

  // Agregar código para validar el registro
  // ...

  alert("Registro exitoso: " + newUsername);
}
