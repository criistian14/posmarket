<?php

session_start();
require_once '../modelos/Compra.php';
require_once '../modelos/Usuario.php';
require_once '../modelos/MedioPago.php';
require_once '../modelos/Producto.php';


class ComprasControlador
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
            $numeroCompras = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroCompras * $pagina) - $numeroCompras) );

            // Contar la cantidad de reportes
            $totalCompras = count(Compra::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalCompras == 0) ? 1 : ceil($totalCompras / $numeroCompras) );


            // Peticion al modelo para recuperar todos los reportes de la bd y guardarlos en una variable
            $compras = Compra::seleccionar('compras.*, usuarios.nombre as nombreUsuario, productos.nombre as nombreProducto, medios_pago.medio')
                                ->unir('compras', 'usuarios', 'usuario_id', 'id')
                                ->unir('compras', 'medios_pago', 'medio_pago_id', 'id')
                                ->unir('compras', 'productos', 'producto_id', 'id')
                                ->limite($inicioConsulta, $numeroCompras)
                                ->resultado();

            // Mensaje
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);


            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/compras/index.php';

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


                // Crear una instancia (Objeto) de Compra
                $compra = new Compra;

                // Pasarle los datos a la instancia
                $compra->cantidad          = $_POST['cantidad'];
                $compra->fecha             = $fecha_actual;
                $compra->medio_pago_id     = $_POST['medio'];
                $compra->producto_id       = $_POST['producto'];
                $compra->usuario_id        = $_POST['proveedor'];
                $compra->valor_total       = ($_POST['cantidad'] * $_POST['valor']);


                if ($compra->guardar() == 1) {

                    $producto = Producto::encontrarPorID($_POST['producto']);

                    $producto->cantidad += $_POST['cantidad'];

                    $producto->guardar();


                    setcookie('mensaje', 'Se registro la compra', time() + 5, '/' );

                } else {

                    setcookie('mensaje_error', "Error al registrar la compra", time() + 10, '/' );
                }




                // Redirigir a la lista de compras
                header('Location: ../compras');


            } else {

                // Consultar proveedores
                $proveedores = Usuario::donde('rol_id', 3)
                                        ->resultado();

                // Consultar productos
                $productos = Producto::todos();

                // Consultar medios de pago
                $medios_pago = MedioPago::todos();


                // Requerir la vista que muestra el formulario para crear un reporte
                include '../vistas/compras/crear.php';
            }

        } else {

            // Redirigir al login
            header('Location: login');
        }

    }



    // Funcion para eliminar una compra de la base de datos
    public function eliminar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el reporte por el id capturado y eliminarlo
            Compra::eliminarPorID($id);

            // Guardar un mensaje de que se elimino correctamente en una cookie
            setcookie('mensaje', 'Se elimino correctamente la compra ', time() + 10 , '/');


            // Redirigir a la tabla con todos los usuarios
            header('Location: ../compras');

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

new ComprasControlador;
