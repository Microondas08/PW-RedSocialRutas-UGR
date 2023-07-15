$(document).ready(function () {
  $("#enviar").click(function () {
    var pais = $("#pais").val();
    var provincia = $("#provincia").val();
    var ciudad = $("#ciudad").val();

    $.ajax({
      url: "../includes/form_handlers/register_handler.php",
      type: "POST",
      data: {
        pais: pais,
        provincia: provincia,
        ciudad: ciudad,
      },
      success: function (response) {
        $("#resultado").html(response);
      },
      error: function (xhr, status, error) {
        console.log(error);
      },
    });
  });
});
