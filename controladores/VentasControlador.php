<?php

session_start();
require_once '../modelos/Venta.php';


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
        $ventas = Venta::seleccionar('*, usuarios.nombre AS nombreUsuario, productos.nombre as nombreProducto, productos.codigo, medios_pago.medio')
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
                // Crear una instancia (Objeto) de Usuario
                    $venta = new Venta;
                    

                    

                    

                    // Pasarle los datos a la instancia
                    $venta->id   = null;
                    $venta->fecha     = null;
                    $venta->medio_pago_id    = 1;
                    $venta->producto_id     = $_POST['id'];
                    // $venta->usuario_id     = $_POST['usuario_id'];
                    // $venta->valor_total  = $_POST['valor_total'];


                    // // Guardar el usuario
                    // $res = $venta->guardar();


                    // // Comprobar si se guardo correctamente el usuario en la db
                    // if ($res == 1) {
                    //     $msg = "Usuario creado exitosamente";
                    // } else {
                    //     $msg = "Error al crear el usuario";
                    // }

                    // // Guardar mensaje con el resultado de la operacion de guardar al usuario en una cookie
                    // setcookie('mensaje', $msg, time() + 5 );

                    // // Redirigir a la lista de usuarios
                    // header('Location: usuarios');


               

    }








    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: ReportesControlador.php');
        }
    }




}

new VentasControlador;
