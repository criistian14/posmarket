<?php

session_start();
require_once '../modelos/TipoReporte.php';
require_once '../modelos/Reporte.php';


class TiposReporteControlador
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



    // Funcion que muestra todos los Tipos de reportes en una tabla
    public function todos()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // La cantidad de tipos de reporte que va a mostrar
            $numeroTiposReporte = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroTiposReporte * $pagina) - $numeroTiposReporte) );

            // Contar la cantidad de tipos de reporte
            $totalTiposReporte = count(TipoReporte::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalTiposReporte == 0) ? 1 : ceil($totalTiposReporte / $numeroTiposReporte) );


            // Peticion al modelo para recuperar todos los tipos de reporte de la bd y guardarlos en una variable
            $tiposReporte = TipoReporte::limite($inicioConsulta, $numeroTiposReporte)
                                ->resultado();



            // Mensaje
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);


            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/tipos_reporte/index.php';

        } else {

            // Redirigir al login
            header('Location: ../login');
        }
    }


    // Funcion para crear un reporte y guardarlo en la base de datos
    public function crear()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            $tipoReporte = new TipoReporte;

            $tipoReporte->reporte = $_POST['nuevoTipoReporte'];

            $tipoReporte->guardar();

            header('Location: ../reportes/tipos_reporte');

        } else {

           // Redirigir al perfil
           header('Location: ../perfil');
       }

    }




    // Funcion para eliminar un usuario de la base de datos
    public function eliminar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Comprobar si no esta siendo utilizado en un reporte
            $comprobarForanea = Reporte::donde('tipo_reporte_id', $id)
                                        ->resultado();

            // Encontra el tipo de reporte por el id y capturarlo
            $tipoReporte = TipoReporte::encontrarPorID($id);


            if ( empty($comprobarForanea) ) {

                // Eliminar el tipo de reporte
                $tipoReporte->eliminar();


                // Guardar un mensaje de que se elimino correctamente en una cookie
                setcookie('mensaje', "Se elimino correctamente el tipo de reporte ($tipoReporte->reporte)", time() + 10, '/' );

            } else {

                // Guardar un mensaje de que se no se pudo eliminar
                setcookie('mensaje_error', "El tipo de reporte ($tipoReporte->reporte) esta siendo utilizado en un reporte", time() + 10, '/' );
            }


            // Redirigir a la tabla con todos los tipos de reporte
            header('Location: ../reportes/tipos_reporte');

        } else {

            // Redirigir al perfil
            header('Location: ../perfil');
        }
    }





    // Funcion para actualizar un tipo de reporte de la base de datos
    public function actualizar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_POST['idTipoReporte'];

            // Encontra el usuario por el id capturado y guardarlo en una variable
            $tipoReporte = TipoReporte::encontrarPorID($id);


            // Pasarle los datos a la instancia
            $tipoReporte->reporte = $_POST['tipoReporte'];


            // Guardar el Reporte
            $res = $tipoReporte->guardar();


            // Comprobar si se actualizo correctamente el tipo de reporte en la db
            if ($res == 1) {
                $msg = "El tipo de reporte se actualizo exitosamente";
            } else {
                $msg = "Error al actualizar el reporte";
            }

            // Guardar mensaje con el resultado de la operacion de actualizar al usuario en una cookie
            setcookie('mensaje', $msg, time() + 5, '/');

            // Redirigir a la tabla con todos los tipos de reporte
            header('Location: ../reportes/tipos_reporte');


        } else {
            // Redirigir al perfil
            header('Location: ../perfil');
        }

    }









    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: ../reportes/tipos_reporte');
        }
    }


}

new TiposReporteControlador;
