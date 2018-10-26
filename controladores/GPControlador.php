<?php
   
#########################################################
#   __      _   _     _____   ______   __    _______    #
#  /__\    ( ) ( )   / ___ \ / ___  \ /  \  (  __   )   #                  
# ( \/ )  _| |_| |_ ( (___) )\/   )  )\/) ) | (  )  |   #                 
#  \  /  (_   _   _) \     /     /  /   | | | | /   | _ #           This controller 
#  /  \/\ _| (_) |_  / ___ \    /  /    | | | (/ /) |(_)#             is made by 
# / /\  /(_   _   _)( (   ) )  /  /     | | |   / | |   #              &#8710;
#(  \/  \  | | | |  ( (___) ) /  /    __) (_|  (__) | _ #
# \___/\/  (_) (_)   \_____/  \_/     \____/(_______)( )#
#                                                    |/ #
#########################################################

# Controlador Gestion de productos.
# Editar producto

$codigo = $_POST["codigo"];
$nombre_producto = $_POST["nombre_producto"];
$precio = $_POST["precio"];
$cantidad = $_POST["cantidad"];
$oferta = $_POST["oferta"];
$tamano = $_POST["tamano"];
$tipo_producto = $_POST["tipo_producto"];




include('../modelos/GestionProductos.php');


$carpeta_destinofinal = "../public/img/";
$imagen = $carpeta_destinofinal . $_FILES['imagen_producto']['name'];

move_uploaded_file($_FILES['imagen_producto']['tmp_name'], $imagen);

if(isset($_POST["activo"])){
    $activo = $_POST["activo"];

}else {
    $activo = 0;
}


if ($_GET['op'] == 1){
    # Crear Producto
    $obj = new GestionProductos;

    $result = $obj->Crear($codigo, $nombre_producto, $tamano, $precio, $oferta, $tipo_producto, $activo, $imagen, $cantidad);

    if($result == 1){

       echo $result;

    }

    
}else if($_GET["op"] == 2){

    
    
}





	
?>