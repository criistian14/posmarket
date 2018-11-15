<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Contacto</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
  <body>

    <?php include_once('../vistas/includes/nav.php'); ?>

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



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

  </body>
</html>
