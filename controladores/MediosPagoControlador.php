<?php

session_start();
require_once '../modelos/MedioPago.php';
require_once '../modelos/Venta.php';


class MediosPagoControlador
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

            // La cantidad de medios de pago que va a mostrar
            $numeroMediosPago = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroMediosPago * $pagina) - $numeroMediosPago) );

            // Contar la cantidad de medios de pago
            $totalMediosPago = count(MedioPago::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalMediosPago == 0) ? 1 : ceil($totalMediosPago / $numeroMediosPago) );


            // Peticion al modelo para recuperar todos los tipos de reporte de la bd y guardarlos en una variable
            $mediosPago = MedioPago::limite($inicioConsulta, $numeroMediosPago)
                                    ->resultado();



            // Mensaje
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);


            // Requerir la vista que muestra todos los medios de pago registrados
            include '../vistas/medios_pago/index.php';

        } else {

            // Redirigir al login
            header('Location: ../login');
        }
    }


    // Funcion para crear un medio de pago y guardarlo en la base de datos
    public function crear()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            $medioPago = new MedioPago;

            $medioPago->medio = $_POST['nuevoMedioPago'];

            $medioPago->guardar();

            header('Location: ../medios_pago');

        } else {

           // Redirigir al perfil
           header('Location: ../perfil');
       }

    }




    // Funcion para eliminar un medio de pago de la base de datos
    public function eliminar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Comprobar si no esta siendo utilizado en una venta
            $comprobarForanea = Venta::donde('medio_pago_id', $id)
                                        ->resultado();


            // Encontra el medio de pago por el id y guardarlo
            $medioPago = MedioPago::encontrarPorID($id);

            if ( empty($comprobarForanea) ) {

                // Eliminar medio de pago
                $medioPago->eliminar();

                // Guardar un mensaje de que se elimino correctamente en una cookie
                setcookie('mensaje', "Se elimino correctamente el medio de pago ($medioPago->medio)", time() + 10, '/');

            } else {

                // Guardar un mensaje de que se no se pudo eliminar
                setcookie('mensaje_error', "El medio de pago ($medioPago->medio) esta siendo utilizado en una venta", time() + 10, '/');
            }


            // Redirigir a la tabla con todos los medios de pago
            header('Location: ../medios_pago');

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

            // Capturar el id enviado por POST
            $id = $_POST['idMedioPago'];

            // Encontra el medio de pago por el id capturado y guardarlo en una variable
            $medioPago = MedioPago::encontrarPorID($id);


            // Pasarle los datos a la instancia
            $medioPago->medio = $_POST['medioPago'];


            // Guardar el medio de pago
            $res = $medioPago->guardar();


            // Comprobar si se actualizo correctamente el medio de pago en la db
            if ($res == 1) {

                // Guardar mensaje con el resultado de la operacion de actualizar al medio de pago en una cookie
                setcookie('mensaje', 'El medio de pago se actualizo exitosamente', time() + 5, '/');
            } else {

                // Guardar mensaje con el resultado de la operacion de actualizar al medio de pago en una cookie
                setcookie('mensaje_error', 'Error al actualizar el medio de pago', time() + 5, '/');
            }


            // Redirigir a la tabla con todos los medios de pago
            header('Location: ../medios_pago');


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

new MediosPagoControlador;
