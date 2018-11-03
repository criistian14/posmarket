<?php

require_once '../modelos/Producto.php';

class IndexControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {

        $productos = Producto::todos();

        // Requerir la vista que muestra todos los usuarios registrados
        include '../vistas/index.php';
    }



}


new IndexControlador;
