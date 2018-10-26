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


# Requerir la configuracion del servidor
require_once('config.php');

 # Clase llamada conexion
class Conexion{
    # Variables globales
    public $conn;

    # Constructor de la clase
    public function __construct(){

        # Crear la conexion
        $this->conn = new mysqli(servidor, servidor_nombre, servidor_contra, servidor_base_datos);

        # Validar si esta conectando la base de datos

        if($this->conn->connect_error){
            echo "Error en conexion";
        }

    }



}
    

   





?>