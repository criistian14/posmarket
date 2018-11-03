<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Inicio</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>
    
<div class="containedor"  style="padding-left: 300px">

    <?php include_once('../vistas/includes/nav.php'); ?>



  <div class="slider">
      <ul class="slides">
        <li>
          <img src="https://picsum.photos/600/600?image=0"> <!-- random image -->
          <div class="caption center-align">
            <h3>This is our big Tagline!</h3>
            <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
          </div>
        </li>
        <li>
          <img src="https://picsum.photos/600/600?image=1"> <!-- random image -->
          <div class="caption left-align">
            <h3>Left Aligned Caption</h3>
            <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
          </div>
        </li>
        <li>
          <img src="https://picsum.photos/600/600?image=2"> <!-- random image -->
          <div class="caption right-align">
            <h3>Right Aligned Caption</h3>
            <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
          </div>
        </li>
        <li>
          <img src="https://picsum.photos/600/600?image=3"> <!-- random image -->
          <div class="caption center-align">
            <h3>This is our big Tagline!</h3>
            <h5 class="light grey-text text-lighten-3">Here's our small slogan.</h5>
          </div>
        </li>
      </ul>
  </div>


  <div class="container">

      <!-- Todos los productos -->
    <div class="row">

        <div class='col s12 m4'>
            <div class='card'>
                <div class='card-image'>
                <img src='https://picsum.photos/300/300/?random'>
                <span class='card-title'>
                sdsfsd
                </span>

                </div>
                <div class='card-content'>
                <p>
                asda
                </p>
                </div>
                <div class='card-action'>
                <button class='btn-floating btn-large waves-effect waves-light red'>
                <i class='material-icons'>add</i>
                </button>
                </div>
            </div>
        </div>
    </div>

      <?php print_r($productos) ?>

  </div>

</div>
<!-- Gitter Chat Link -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red" href="vistas/contacto.php"><i class="large material-icons">chat</i></a>
</div>





<!-- JQUery viejo -->
<script type="text/javascript" src="public/js/jquery.js"></script>

<script type="text/javascript">

	 $(document).ready(function(){
        $('.slider').slider({full_width: true});
    });
</script>

<!-- Llamando el php que contiene los scripts -->
<?php include_once '../vistas/includes/scripts.php'; ?>

<script src="public/js/nav.js" charset="utf-8"></script>



</body>
</html>
