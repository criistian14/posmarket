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



    public function buscarProducto()
    {
        $busqueda = join(' ' ,explode('-' ,$_GET['busqueda']));

        $productos = Producto::donde('nombre', 'LIKE', "%$busqueda%")
                            ->resultado();

        include '../vistas/core/busqueda.php';
    }



    public function productoCategoria()
    {
        $categoria = $_GET['categoria'];

        $productos = Producto::donde('tipo_producto', 'LIKE', "%$categoria%")
                            ->resultado();

        include '../vistas/core/categoria.php';
    }



    public function contacto()
    {
        $usuario_id = (isset($_SESSION['usuario'])) ? unserialize($_SESSION['usuario'])->id : null;

        if ($usuario_id == null) {
            $usuario_id = (isset($_SESSION['admin'])) ? unserialize($_SESSION['admin'])->id : null;
        }

        // Mensaje
        $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

        // Mensaje Error
        $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);


        if (isset($_POST['flag'])) {


            $descripcion = 'Asunto: ' . $_POST['asunto'] . PHP_EOL . PHP_EOL;

            $descripcion .= $_POST['motivo'];


            if ($usuario_id == null) {

                $usuario = Usuario::donde('correo', $_POST['correo'])
                                    ->resultado();

                if (empty($usuario)) {

                    $usuario_id = 0;

                    $descripcion .= PHP_EOL . PHP_EOL . PHP_EOL . '----- Datos del usuario ----' . PHP_EOL . PHP_EOL . 'Correo: ' . $_POST['correo'] . PHP_EOL . 'Nombre: ' . $_POST['nombre'] . PHP_EOL . 'Apellido: ' . $_POST['apellido'];

                } else {
                    $usuario_id = $usuario[0]->id;
                }

            }



            $reporte = new Reporte;

            $reporte->tipo_reporte_id   = 1;
            $reporte->descripcion       = $descripcion;
            $reporte->producto_id       = null;
            $reporte->fecha             = date('Y-m-d');
            $reporte->usuario_id             = $usuario_id;


            if ($reporte->guardar() == 1) {

                setcookie('mensaje', 'Se envio correctamente', time() + 5, '/' );

                header('Location: contacto');

            } else {

                setcookie('mensaje_error', "Error al enviar", time() + 10, '/' );

                header('Location: contacto');
            }


        } else {

            include '../vistas/contacto.php';
        }
    }


}


new IndexControlador;
