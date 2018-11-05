<?php

require_once '../modelos/Producto.php';
require_once '../modelos/Usuario.php';
session_start();

class IndexControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {

        $productos = Producto::todos();

        // Requerir la vista que muestra todos los usuarios registrados
        include '../vistas/core/index.php';
    }





}


new IndexControlador;
