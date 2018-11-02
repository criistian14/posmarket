<?php

session_start();
require_once '../modelos/Usuario.php';
require_once '../modelos/Rol.php';

class ConfiguracionControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {
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


    // Funcion que muestra todos los usuarios en una tabla
    public function todos()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/configuracion/index.php';

        } else {

            // Redirigir al login
            header('Location: UsuariosControlador.php?action=login');
        }
    }




    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: UsuariosControlador.php');
        }
    }

}

new ConfiguracionControlador;
