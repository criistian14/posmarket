<?php

session_start();
require_once '../modelos/Reporte.php';
require_once '../modelos/Usuario.php';
require_once '../modelos/TipoReporte.php';
require_once '../modelos/Producto.php';


class ReportesControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {
        // Establecer zona horaria Colombia
        date_default_timezone_set('America/Bogota');

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

            // La cantidad de reportes que va a mostrar
            $numeroReportes = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroReportes * $pagina) - $numeroReportes) );

            // Contar la cantidad de reportes
            $totalReportes = count(Reporte::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalReportes == 0) ? 1 : ceil($totalReportes / $numeroReportes) );


            // Peticion al modelo para recuperar todos los reportes de la bd y guardarlos en una variable
            $reportes = Reporte::seleccionar('reportes.*, usuarios.nombre, usuarios.ciudad, usuarios.cedula, usuarios.rol_id, tipo_reportes.reporte, roles.rol')
                                ->unir('reportes', 'usuarios', 'usuario_id', 'id')
                                ->unir('reportes', 'tipo_reportes', 'tipo_reporte_id', 'id')
                                ->unir('usuarios', 'roles', 'rol_id', 'id')
                                ->limite($inicioConsulta, $numeroReportes)
                                ->resultado();

            // Mensaje
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);


            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/reportes/index.php';

        } else {

            // Redirigir al login
            header('Location: login');
        }
    }



    // Funcion para crear un reporte y guardarlo en la base de datos
    public function crear()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Si se envio el formulario para crear Reporte
            if( isset($_POST['flag']) ) {

                // Obtener la fecha actual
                $fecha_actual = date('Y-m-d');

                // Obtener el usuario actual
                $usuario = unserialize($_SESSION['admin']);

                // Crear una instancia (Objeto) de Reporte
                $reporte = new Reporte;

                // Pasarle los datos a la instancia
                $reporte->descripcion       = $_POST['descripcion'];
                $reporte->tipo_reporte_id   = $_POST['tipoReporte'];
                $reporte->fecha             = $fecha_actual;
                $reporte->usuario_id        = $usuario->id;


                // Si el reporte es de un Producto
                if( isset($_POST['producto']) ) {
                    $reporte->producto_id = $_POST['producto'];
                }



                // Guardar el Reporte
                $res = $reporte->guardar();



                // Comprobar si se guardo correctamente el reporte en la db
                if ($res == 1) {
                    $msg = "Reporte creado exitosamente";
                } else {
                    $msg = "Error al crear el reporte";
                }

                // Guardar mensaje con el resultado de la operacion de guardar el reporte en una cookie
                setcookie('mensaje', $msg, time() + 5 , '/');

                // Redirigir a la lista de reportes
                header('Location: ../reportes');




            // Si se envio el formulario para crear un Tipo de Reporte
            } elseif( isset($_POST['flagNuevoTipoReporte']) ) {

                $tipoReporte = new TipoReporte;

                $tipoReporte->reporte = $_POST['nuevoTipoReporte'];

                $tipoReporte->guardar();

                header('Location: ../reportes/crear');


            } else {

                // Consultar tipos de reporte
                $tiposReporte = TipoReporte::todos();

                // Consultar productos
                $productos = Producto::todos();

                // Requerir la vista que muestra el formulario para crear un reporte
                include '../vistas/reportes/crear.php';
            }
        } else {

            // Redirigir al login
            header('Location: login');
        }

    }



    // Funcion para eliminar un reporte de la base de datos
    public function eliminar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el reporte por el id capturado y eliminarlo
            Reporte::eliminarPorID($id);

            // Guardar un mensaje de que se elimino correctamente en una cookie
            setcookie('mensaje', 'Se elimino correctamente el reporte ', time() + 10 , '/');


            // Redirigir a la tabla con todos los usuarios
            header('Location: ../reportes');

        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }
    }



    // Funcion para actualizar un reporte de la base de datos
    public function actualizar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el usuario por el id capturado y guardarlo en una variable
            $reporte = Reporte::encontrarPorID($id);

            // Consultar tipos de reporte
            $tiposReporte = TipoReporte::todos();

            // Consultar productos
            $productos = Producto::todos();

            // Consultar usuarios
            $usuarios = Usuario::todos();


            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Cargar mensaje de correcto si es que existe
            $msgSuccess = ( isset($_COOKIE['mensaje_reporte_actualizar_success']) ? $_COOKIE['mensaje_reporte_actualizar_success'] : null);



            // Si se envio el formulario para crear Reporte
            if (isset($_POST["flag"])) {


                // Pasarle los datos a la instancia
                $reporte->descripcion       = $_POST['descripcion'];
                $reporte->tipo_reporte_id   = $_POST['tipoReporte'];
                $reporte->fecha             = $_POST['fecha'];
                $reporte->usuario_id        = $_POST['usuario'];


                // Si el reporte es de un Producto
                if( isset($_POST['productoConfirmar']) ) {
                    $reporte->producto_id = $_POST['producto'];
                } else {
                    $reporte->producto_id = null;
                }



                // Guardar el Reporte
                $res = $reporte->guardar();


                // Comprobar si se actualizo correctamente el usuario en la db
                if ($res == 1) {
                    $msg = "El reporte se actualizo exitosamente";
                } else {
                    $msg = "Error al actualizar el reporte";
                }

                // Guardar mensaje con el resultado de la operacion de actualizar al usuario en una cookie
                setcookie('mensaje', $msg, time() + 5 , '/');

                // Redirigir a la lista con todos los reportes
                header('Location: ../reportes');



            // Si se envio el formulario para crear un Tipo de Reporte
            } elseif( isset($_POST['flagNuevoTipoReporte']) ) {

                $tipoReporte = new TipoReporte;

                $tipoReporte->reporte = $_POST['nuevoTipoReporte'];

                $tipoReporte->guardar();

                header("Location: " . ruta . "/reportes/actualizar/$id");


            } else {

                // Requerir la vista que muestra el formulario para actualizar un reporte
                include '../vistas/reportes/actualizar.php';
            }

        } else {

            // Redirigir al perfil
            header('Location: perfil');
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
