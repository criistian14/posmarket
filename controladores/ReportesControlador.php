<?php

session_start();
require_once '../modelos/Reporte.php';
require_once '../modelos/TipoReporte.php';


class ReportesControlador
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
        // La cantidad de reportes que va a mostrar
        $numeroReportes = 1;

        // Obtener que numero de pagina es
        $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

        // Conocer el inicio de la consulta
        $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroReportes * $pagina) - $numeroReportes) );

        // Contar la cantidad de reportes
        $totalReportes = count(Reporte::todos());

        // El numero de paginas que salen en total
        $cantidadDePaginas = ( ($totalReportes == 0) ? 1 : ceil($totalReportes / $numeroReportes) );


        // Peticion al modelo para recuperar todos los reportes de la bd y guardarlos en una variable
        $reportes = Reporte::seleccionar('reportes.*, usuarios.*, tipo_reportes.reporte, roles.rol')
                            ->unir('reportes', 'usuarios', 'usuario_id', 'id')
                            ->unir('reportes', 'tipo_reportes', 'tipo_reporte_id', 'id')
                            ->unir('usuarios', 'roles', 'rol_id', 'id')
                            ->resultado();


        // Mensaje
        $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);


        // Requerir la vista que muestra todos los usuarios registrados
        include '../vistas/reportes/index.php';
    }


    public function crear()
    {
        $tiposReporte = TipoReporte::todos();

        if ( isset($_POST['flagNuevoTipoReporte']) ) {

            $tipoReporte = new TipoReporte;

            $tipoReporte->reporte = $_POST['nuevoTipoReporte'];

            $tipoReporte->guardar();

            header('Location: ReportesControlador.php?action=crear');


        } else {

            include '../vistas/reportes/crear.php';
        }

    }



    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: ReportesControlador.php');
        }
    }




}

new ReportesControlador;
