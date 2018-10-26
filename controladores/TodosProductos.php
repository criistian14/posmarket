<?php

    include('../modelos/GestionProductos.php');

    $obj = new GestionProductos;
    
   $op = $_POST["op"];

   $resultado = $obj->Leer(null);

   echo json_encode($resultado);
    
?>