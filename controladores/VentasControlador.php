<?php

session_start();
require_once '../modelos/Venta.php';
require_once '../modelos/Usuario.php';
require_once '../modelos/Producto.php';
require_once '../modelos/MedioPago.php';


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
        if (isset($_SESSION['admin'])) {

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
            $ventas = Venta::seleccionar('ventas.*, usuarios.nombre AS nombreUsuario, medios_pago.medio')
                            ->unir('ventas', 'usuarios', 'usuario_id', 'id')
                            ->unir('ventas', 'medios_pago', 'medio_pago_id', 'id')
                            ->limite($inicioConsulta, $numeroVentas)
                            ->resultado();



            // Mensaje

            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);



            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/ventas/index.php';


        } else {

            // Redirigir al perfil
            header('Location: perfil');

        }

    }



    public function crear()
    {
        if (isset($_SESSION['usuario']) || isset($_SESSION['admin'])) {

            $datos = [];

            foreach ($_POST as $key => $value) {

                if ($key !== 'medio_pago') {

                    $dato = explode(',', $value);

                    array_push($datos, [
                        'id' => $dato[0],
                        'valor' => $dato[1],
                        'cantidad' => $dato[2]
                    ]);
                }
            }


            $valorTotal = 0;

            foreach ($datos as $value) {
                $valorTotal += $value['valor'] * $value['cantidad'];
            }


            $venta = new Venta;

            $venta->fecha = date('Y-m-d');
            $venta->medio_pago_id = $_POST['medio_pago'];
            $venta->usuario_id = isset($_SESSION['usuario']) ? unserialize($_SESSION['usuario'])->id : unserialize($_SESSION['admin'])->id ;
            $venta->valor_total = $valorTotal;


            $venta->datos = serialize($datos);


            if ($venta->guardar() == 1) {

                foreach ($datos as $value) {
                    $producto = Producto::encontrarPorID($value['id']);

                    $producto->cantidad = ($producto->cantidad - $value['cantidad']);

                    $producto->guardar();
                }


                echo json_encode(['isLogged' => true, 'error' => false]);

            } else {

                echo json_encode(['isLogged' => true, 'error' => true, 'message' => 'Error al registrar la compra']);
            }


        } else {

            echo json_encode(['isLogged' => false]);
        }


    }



    public function historial(){

        if(isset($_SESSION["usuario"]) || isset($_SESSION["admin"])){

            /// La cantidad de reportes que va a mostrar
            $numeroVentas = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroVentas * $pagina) - $numeroVentas) );

            // Contar la cantidad de reportes
            $totalVentas = count(Venta::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalVentas == 0) ? 1 : ceil($totalVentas / $numeroVentas) );


            $usuarioActual = isset($_SESSION['usuario']) ? unserialize($_SESSION['usuario']) : unserialize($_SESSION['admin']);

            // Peticion al modelo para recuperar todos los reportes de la bd y guardarlos en una variable
            $ventas = Venta::seleccionar('ventas.*, usuarios.nombre AS nombreUsuario, medios_pago.medio')
                            ->unir('ventas', 'usuarios', 'usuario_id', 'id')
                            ->unir('ventas', 'medios_pago', 'medio_pago_id', 'id')
                            ->limite($inicioConsulta, $numeroVentas)
                            ->donde('usuario_id', $usuarioActual->id)
                            ->resultado();



            // Mensaje

            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);



            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/ventas/historial.php';

        } else {

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


            // Encontra el medio de pago por el id y guardarlo
            $venta = Venta::encontrarPorID($id);

            // Eliminar medio de pago
            $venta->eliminar();

            // Guardar un mensaje de que se elimino correctamente en una cookie
            setcookie('mensaje', "Se elimino correctamente la venta con id ($venta->id)", time() + 10, '/');

            header('Location: ' . ruta . '/ventas');



        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }
    }




    // Funcion para actualizar una venta de la base de datos
    public function actualizar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) || isset($_SESSION['usuario']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el usuario por el id capturado y guardarlo en una variable
            $venta = Venta::encontrarPorID($id);

            // Consultar usuario
            $usuarios = Usuario::todos();

            // Consultar productos
            $productos = Producto::todos();

            // Consultar medios de pago
            $medios_pago = MedioPago::todos();


            $datos = unserialize($venta->datos);


            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Cargar mensaje de correcto si es que existe
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);



            // Si se envio el formulario para crear Reporte
            if (isset($_POST["flag"])) {



                $datos = [];

                foreach ($_POST['datos'] as $key => $value) {

                    array_push($datos, [
                        'id' => $value['id'],
                        'valor' => $value['valor'],
                        'cantidad' => $value['cantidad']
                    ]);
                }



                // Pasarle los datos a la instancia
                $venta->fecha           = $_POST['fecha'];
                $venta->medio_pago_id   = $_POST['medio_pago'];
                $venta->usuario_id      = $_POST['usuario'];
                $venta->valor_total     = $_POST['valor_total'];
                $venta->datos           = serialize($datos);


                // Comprobar si se actualizo correctamente la venta en la db
                if ($venta->guardar() == 1) {

                    setcookie('mensaje', 'Se actualizo la venta', time() + 5, '/' );

                } else {

                    setcookie('mensaje_error', "Error al actualizar la venta", time() + 10, '/' );
                }

                // Redirigir a la lista con todos los reportes
                header('Location: ' . ruta . '/ventas');


            } else {

                // Requerir la vista que muestra el formulario para actualizar un reporte
                include '../vistas/ventas/actualizar.php';
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

new VentasControlador;
