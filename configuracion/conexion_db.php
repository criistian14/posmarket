<?php

# Requerir la configuracion del servidor
require_once('constantes.php');

 # Clase llamada conexion
class Conexion{
    # Variables globales
    public $conn;

    # Constructor de la clase
    function __construct(){

        # Crear la conexion
        $this->conn = new mysqli(servidor, servidor_nombre, servidor_contra, servidor_base_datos);

        # Validar si esta conectando la base de datos

        if($this->conn->connect_error){
            echo "Error en conexion";
        }

    }



}








?>
