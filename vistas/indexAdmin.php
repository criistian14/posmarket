<?php
    session_start();
    if(!isset($_SESSION['admin'])){

        header('location: /proyecto/vistas/login.php');
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="public/js/jquery.js"></script>
    <script type="text/javascript" src="/proyecto/public/js/materialize.min.js"></script>
    <link rel="stylesheet" href="../public/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('includes/nav.php');
    ?>
    
</body>
</html>