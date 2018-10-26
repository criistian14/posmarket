<?php
    session_start();
    if(!isset($_SESSION['usuario'])){

        header('location: /proyecto/vistas/login.php');
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>    
    <script type="text/javascript" src="/proyecto/public/js/materialize.min.js"></script>
    <link rel="stylesheet" href="../public/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('includes/nav.php');
    ?>
    

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

    
    <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                    <img src="https://picsum.photos/300/300/?random">
                    <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                    I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                    <a href="#">This is a link</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                    <img src="https://picsum.photos/300/300/?random">
                    <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                    I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                    <a href="#">This is a link</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                    <img src="https://picsum.photos/300/300/?random">
                    <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                    I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                    <a href="#">This is a link</a>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                    <img src="https://picsum.photos/300/300/?random">
                    <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                    I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                    <a href="#">This is a link</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                    <img src="https://picsum.photos/300/300/?random">
                    <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                    I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                    <a href="#">This is a link</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                    <img src="https://picsum.photos/300/300/?random">
                    <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                    <p>I am a very simple card. I am good at containing small bits of information.
                    I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                    <a href="#">This is a link</a>
                    </div>
                </div>
            </div>
    </div>

</div>

<!-- Gitter Chat Link -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red" href="/proyecto/vistas/contacto.php"><i class="large material-icons">chat</i></a>
</div>

<script type="text/javascript">
	 $(document).ready(function(){
      $('.slider').slider({full_width: true});
    });
</script>
</body>
</html>