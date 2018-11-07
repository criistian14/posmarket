<?php

require_once '../modelos/Producto.php';
require_once '../modelos/Usuario.php';
require_once '../modelos/Reporte.php';
require_once '../modelos/Venta.php';


session_start();

class IndexControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {
        // Establecer zona horaria Colombia
        date_default_timezone_set('America/Bogota');

        // Se comprueba si se paso por metodo get una accion en concreto o sino se le asigna "todos"
        $action = ( isset($_GET["action"]) ? $_GET["action"] : "index");

        // Comprueba si el metodo ingresado por el metodo get existe en la clase
        if (method_exists($this, $action)) {

            // Si existe el metodo procede a ejectutarlo
            $this->$action();
        } else {

            // Si no existe ejecutara la funcion error
            $this->error($action);
        }
    }



    public function index()
    {
        $productos = Producto::todos();

        // Requerir la vista que muestra todos los productos
        include '../vistas/core/index.php';
    }



    public function indexAdmin()
    {
        if ( isset($_SESSION['admin']) ) {

            // Contar todos los usuarios del sistema
            $numeroUsuarios = count(Usuario::todos());

            // Contar todos los reportes del sistema
            $numeroReportes = count(Reporte::todos());

            // Contar todos las ventas del sistema
            $numeroVentas = count(Venta::todos());

            // Contar todos los productos del sistema
            $numeroProductos = count(Producto::todos());

            // Requerir la vista que muestra datos basicos
            include '../vistas/admin/index.php';

        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }

    }





}


new IndexControlador;
