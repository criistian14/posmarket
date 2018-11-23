<?php

session_start();
require_once '../modelos/Venta.php';
require_once '../modelos/Usuario.php';


class VentasControlador
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
        // La cantidad de reportes que va a mostrar
        $numeroVentas = 5;

        // Obtener que numero de pagina es
        $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

        // Conocer el inicio de la consulta
        $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroVentas * $pagina) - $numeroVentas) );

        // Contar la cantidad de reportes
        $totalVentas = count(Venta::todos());

        // El numero de paginas que salen en total
        $cantidadDePaginas = ( ($totalVentas == 0) ? 1 : ceil($totalVentas / $numeroVentas) );


        // Peticion al modelo para recuperar todos los reportes de la bd y guardarlos en una variable
        $ventas = Venta::seleccionar('*, usuarios.nombre AS nombreUsuario, productos.nombre as nombreProducto, productos.codigo, medios_pago.medio, ventas.id')
                            ->unir('ventas', 'usuarios', 'usuario_id', 'id')
                            ->unir('ventas', 'productos', 'producto_id', 'id')
                            ->unir('ventas', 'medios_pago', 'medio_pago_id', 'id')
                            ->limite($inicioConsulta, $numeroVentas)
                            ->resultado();





        // Mensaje

        $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

        // Mensaje Error
        $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);



        // Requerir la vista que muestra todos los usuarios registrados
        include '../vistas/ventas/index.php';

    }


        public function registrar()
    {


            if(isset($_SESSION["usuario"]) || isset($_SESSION["admin"])){


                // Crear una instancia (Objeto) de Usuario
                    $venta = new Venta;


                    $usuario = unserialize( isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : $_SESSION["admin"] );


                    // Pasarle los datos a la instancia
                    $venta->medio_pago_id    = 1;
                    $venta->producto_id     = $_POST['id'];
                    $venta->usuario_id     = $usuario->id;
                    $venta->valor_total  = $_POST['total_producto'];



                    // Guardar el usuario
                    $res = $venta->guardar();


                    // Comprobar si se guardo correctamente el usuario en la db
                    if ($res == 1) {
                        $msg = 1;

                        echo $msg;
                    }
            }else{

                echo 0;

            }

                    // // Guardar mensaje con el resultado de la operacion de guardar al usuario en una cookie
                    // setcookie('mensaje', $msg, time() + 5 );

                    // // Redirigir a la lista de usuarios
                    // header('Location: usuarios');




    }

    public function historial(){

        if(isset($_SESSION["usuario"]) || isset($_SESSION["admin"])){

        // La cantidad de reportes que va a mostrar
        $numeroVentas = 5;

        // Unserializar usuario
        $usuario = unserialize( isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : $_SESSION["admin"] );

        // Obtener que numero de pagina es
        $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

        // Conocer el inicio de la consulta
        $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroVentas * $pagina) - $numeroVentas) );

        // Contar la cantidad de reportes
        $totalVentas = count(Venta::seleccionar('*, usuarios.nombre AS nombreUsuario, productos.nombre as nombreProducto, productos.codigo, medios_pago.medio')
                            ->unir('ventas', 'usuarios', 'usuario_id', 'id')
                            ->unir('ventas', 'productos', 'producto_id', 'id')
                            ->unir('ventas', 'medios_pago', 'medio_pago_id', 'id')
                            ->donde('ventas.usuario_id', $usuario->id)
                            ->resultado());



        // El numero de paginas que salen en total
        $cantidadDePaginas = ( ($totalVentas == 0) ? 1 : ceil($totalVentas / $numeroVentas) );


        // Peticion al modelo para recuperar todos los reportes de la bd y guardarlos en una variable
        $ventas = Venta::seleccionar('*, usuarios.nombre AS nombreUsuario, productos.nombre as nombreProducto, productos.codigo, medios_pago.medio')
                            ->unir('ventas', 'usuarios', 'usuario_id', 'id')
                            ->unir('ventas', 'productos', 'producto_id', 'id')
                            ->unir('ventas', 'medios_pago', 'medio_pago_id', 'id')
                            ->donde('ventas.usuario_id', $usuario->id)
                            ->limite($inicioConsulta, $numeroVentas)
                            ->resultado();

        // Mensaje
        $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

        // Mensaje Error
        $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);



        include '../vistas/usuarios/historial.php';

        }else{

            header('Location: login');

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



            // Encontra el medio de pago por el id y guardarlo
            $venta = Venta::encontrarPorID($id);



                // Eliminar medio de pago
                $venta->eliminar();

                // Guardar un mensaje de que se elimino correctamente en una cookie
                setcookie('mensaje', "Se elimino correctamente la venta ($venta->id)", time() + 10, '/');

                header('Location: ../ventas');



        } else {

            // Redirigir al perfil
            header('Location: ../perfil');
        }
    }







    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: ReportesControlador.php');
        }
    }




}

new VentasControlador;
