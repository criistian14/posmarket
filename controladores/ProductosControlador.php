<?php

session_start();
require_once '../modelos/Usuario.php';
require_once '../modelos/Producto.php';
require_once '../modelos/Reporte.php';
require_once '../modelos/Compra.php';


class ProductosControlador
{

    // Constructor de la clase que ejecutara las funciones segun se soliciten
    function __construct()
    {
        if (empty($_GET)) {
            header('Location: ProductosControlador.php?action=todos');
        }

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



    // Funcion que muestra todos los productos en una tabla
    public function todos()
    {

        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // La cantidad de usuarios que va a mostrar
            $numeroProductos = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroProductos * $pagina) - $numeroProductos) );

            // Contar la cantidad de usuarios
            $totalUsuarios = count(Producto::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalUsuarios == 0) ? 1 : ceil($totalUsuarios / $numeroProductos) );


            // Peticion al modelo para recuperar todos los usuarios de la bd y guardarlos en una variable
            $productos = Producto::todos();




            // Mensaje
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);



            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/productos/index.php';

        } else {

            // Redirigir a
            header('Location: login');
        }
    }


    // Funcion para mostrar el formulario de registro de usuarios
    public function registro()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ) {

            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Cargar datos del usuario si tuvo un error
            $datosProducto = ( isset($_COOKIE['datos_producto_registro']) ? unserialize($_COOKIE['datos_producto_registro']) : null);

            $categorias = categorias;


            // Requerir la vista que muestra el formulario para registrar un usuario
            include '../vistas/productos/registro.php';

        } else {
            header('Location: perfil');
        }
    }


    /*  Funcion para registrar al usuario en la base de datos o en caso de que no haya enviado datos
        lo va a redirigir al registro
    */
    public function registrar()
    {
        // Comprobar si se envio por el formulario
        if (isset($_POST["flag"])) {

            // Hacer consulta si existe un usuario con la cedula digitada en el formulario
            $comprobarProducto = Producto::donde('codigo', $_POST['codigo'])
                                       ->resultado();

           // Comprobar si la cedula no se encuentra registrada
            $codigoValido = ( empty($comprobarProducto) ? true : false );


            if ($codigoValido) {


                    // Crear una instancia (Objeto) de Usuario
                    $producto = new Producto;

                    // Pasarle los datos a la instancia
                    $producto->codigo     = $_POST['codigo'];
                    $producto->nombre     = $_POST['nombre'];
                    $producto->precio    = $_POST['precio'];
                    $producto->cantidad     = 0;
                    $producto->oferta     = $_POST['oferta'];
                    $producto->tamano  = $_POST['tamano'];
                    $producto->tipo_producto     = $_POST['tipo_producto'];
                    $producto->activo = isset($_POST["activo"]) ? $_POST["activo"] : 0;

                    if(!empty($_POST['imagen'])){
                        $carpeta_destinofinal = '/img/';
                        $imagen = rand(1, 10000) . $_POST['imagen'];
                        $producto->imagen = $carpeta_destinofinal . $imagen;

                     move_uploaded_file($_FILES['imagen_producto']['tmp_name'], "../public/img/" . $imagen);

                    }


                    // Guardar el usuario
                    $res = $producto->guardar();

                    // Comprobar si se guardo correctamente el usuario en la db
                    if ($res == 1) {
                        $msg = "Producto creado exitosamente";
                    } else {
                        $msg = "Error no se pudo crear";
                    }

                    // Guardar mensaje con el resultado de la operacion de guardar al usuario en una cookie
                    setcookie('mensaje', $msg , time() + 5, '/');

                    // Redirigir a la lista de usuarios
                    header('Location: ../productos');





            } else {

                // Guardar mensaje con los datos del usuario enviados por POST en una cookie
                setcookie('datos_producto_registro', serialize($_POST), time() + 20, '/');

                // Guardar un mensaje de error en una cookie (Si la cedula ya existe)
                setcookie('mensaje', 'El codigo ya se encuentra registrado', time() + 10, '/');

                // Redirigir al formulario
                header('Location: ../productos/crear');
            }



        } else {

            // Si aun no ha completado el formulario se va a redirigir al formulario
            header('Location: ../productos/crear');
        }

    }



    // Funcion para eliminar un producto de la base de datos
    public function eliminar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el producto por el id capturado y guardarlo en una variable
            $producto = Producto::encontrarPorID($id);

            $comprobarReportes = Reporte::donde('producto_id', $id)
                                        ->resultado();

            if (empty($comprobarReportes)) {


                $comprobarCompra = Compra::donde('producto_id', $id)
                                            ->resultado();

                if (empty($comprobarCompra)) {

                    // Guardar un mensaje de que se elimino correctamente en una cookie
                    setcookie('mensaje', 'Se elimino correctamente el producto (' . $producto->nombre . ')', time() + 10 , '/');

                    // Eliminar el usuario
                    $producto->eliminar();


                } else {

                    // Guardar un mensaje de que se elimino correctamente en una cookie
                    setcookie('mensaje_error', 'No se puede eliminar el producto (' . $producto->nombre . ') porque tiene una compra', time() + 10 , '/');
                }


            } else {

                // Guardar un mensaje de que se elimino correctamente en una cookie
                setcookie('mensaje_error', 'No se puede eliminar el producto (' . $producto->nombre . ') porque tiene un reporte', time() + 10 , '/');
            }


            header('Location: ' . ruta . '/productos');


        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }
    }



    // Funcion para actualizar un producto de la base de datos
    public function actualizar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el producto por el id capturado y guardarlo en una variable
            $producto = Producto::encontrarPorID($id);


            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Comprobar si se envio por el formulario
            if (isset($_POST["flag"])) {

                // Comprobar si la cedula es la misma que tiene registrada
                if ($_POST['codigo'] == $producto->codigo) {

                    $codigoValido = true;
                } else {

                    // Hacer consulta si existe un usuario con la cedula digitada en el formulario
                    $comprobarProducto = Producto::donde('codigo', $_POST['codigo'])
                                               ->resultado();


                   // Comprobar si la cedula no se encuentra registrada
                   $codigoValido = ( empty($comprobarProducto) ? true : false );
                }



                if ($codigoValido) {


                    // Pasarle los datos a la instancia
                    $producto->codigo     = $_POST['codigo'];
                    $producto->nombre     = $_POST['nombre'];
                    $producto->precio    = $_POST['precio'];
                    $producto->cantidad     = $_POST['cantidad'];
                    $producto->oferta     = $_POST['oferta'];
                    $producto->tamano  = $_POST['tamano'];
                    $producto->tipo_producto     = $_POST['tipo_producto'];

                    // Validar si hay algo en $_POST
                    if(!empty($_POST['imagen'])){


                        // Eliminar imagen de la carpeta
                        unlink('../public' . $producto->imagen);


                        $carpeta_destinofinal = "/img/";
                        $imagen = rand(1, 10000) . $_POST['imagen'];
                        $producto->imagen = $carpeta_destinofinal . $imagen;

                        move_uploaded_file($_FILES['imagen_producto']['tmp_name'], "../public/img/" . $imagen);
                    }



                    // Condicion
                    if(isset($_POST["activo"])){

                        $producto->activo = 1;

                    }else{
                        $producto->activo = 0;
                    }


                    // Actualizar el usuario
                    $res = $producto->guardar();


                    // Comprobar si se actualizo correctamente el usuario en la db
                    if ($res == 1) {
                        $msg = "Producto se actualizo exitosamente";
                    } else {
                        $msg = "Error al actualizar el producto";
                    }

                    // Guardar mensaje con el resultado de la operacion de actualizar al usuario en una cookie
                    setcookie('mensaje', $msg, time() + 5, "/");

                    // Redirigir a la lista con todos los usuarios
                    header('Location: ' . ruta . '/productos');



                } else {

                    // Guardar un mensaje de error en una cookie (Si la cedula ya existe)
                    setcookie('mensaje', 'el codigo ya se encuentra registrado', time() + 10 );

                    // Redirigir al formulario
                    header('Location: ' . ruta . "/productos/actualizar/$id");
                }



            } else {

                // Requerir la vista que muestra el formulario para actualizar un usuario
                include '../vistas/productos/actualizar.php';
            }

        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }
    }


    // Funcion para ver el carrito
    public function carrito(){
        
        // Consultar medios de pago
        $medios_pago = MedioPago::todos();

        include '../vistas/productos/carrito.php';

    }

    // Funcion de respuesta al ajax
    public function respuesta(){

        $producto = [];
        foreach ($_POST as $key => $value) {

            $producto[] = Producto::encontrarPorID($value);
        }

        echo json_encode($producto);


    }


    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: productos');
        }
    }




}


new ProductosControlador;
