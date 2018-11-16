<?php

session_start();
require_once '../modelos/Usuario.php';
require_once '../modelos/Producto.php';


class ComprasControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {
        if (empty($_GET)) {
            header('Location: ComprasControlador.php?action=todos');
        }

        // Se comprueba si se paso por metodo get una accion en concreto o sino se le asigna "todos"
        $action = ( isset($_GET["action"]) ? $_GET["action"] : "todos");

        // Comprueba si el metodo ingresado por el metodo get existe en la clase
        if (method_exists($this, $action)) {

            // Si existe el metodo procede a ejectutarlo
            $this->$action();
        } else {

            // Si no existe ejecutara la funcion error
            $this->error($action);
        }
    }


       public function error($action)
    {
        if ( empty($action) ) {
            header('Location: compras');
        }
    }



}


new ComprasControlador;