<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="../public/js/materialize.min.js"></script>
    <link rel="stylesheet" href="../public/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Contacto</title>
  </head>
  <body>
    <div class="container">
      <center>
      <h2>Contactanos</h2>
      </center>

      <div class="row">
      <form class="col s12">
    <div class="row">
      <div class="input-field col s6">
        <input id="first_name" type="text" class="validate">
        <label for="first_name">Nombre</label>
      </div>
      <div class="input-field col s6">
        <input id="last_name" type="text" class="validate">
        <label for="last_name">Apellidos</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input disabled value="posmarket@gmail.com" id="disabled" type="text" class="validate">
        <label for="disabled">Correo</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password" type="password" class="validate">
        <label for="password">Contraseña</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="email" type="email" class="validate">
        <label for="email">Correo</label>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input id="tipo" type="text" class="validate">
          <label for="tipo">Ingrese su reclamo</label>
        </div>
    </div>

      <center><a class="waves-effect waves-light btn">Enviar</a></center>
  </form>
  </div>
    </div>
  </body>
</html>
