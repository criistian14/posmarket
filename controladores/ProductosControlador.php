<?php

session_start();
require_once '../modelos/Producto.php';


class ProductosControlador
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


            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/productos/index.php';

        } else {

            // Redirigir a
            header('Location: UsuariosControlador.php?action=login');
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

            // Guardar un mensaje de que se elimino correctamente en una cookie
            setcookie('mensaje', 'Se elimino correctamente el producto ' . $producto->nombre, time() + 10 );

            // Eliminar el usuario
            $producto->eliminar();

            // Redirigir a la tabla con todos los usuarios
            header('Location: ProductosControlador.php');

        } else {

            // Redirigir al perfil
            header('Location: UsuariosControlador.php?action=perfil');
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
                   $codigoValido = ( empty($comprobarUsuario) ? true : false );
                }



                if ($codigoValido) {


                    // Pasarle los datos a la instancia
                    $usuario->apellido   = $_POST['apellido'];
                    $usuario->cedula     = $_POST['cedula'];
                    $usuario->celular    = $_POST['celular'];
                    $usuario->ciudad     = $_POST['ciudad'];
                    $usuario->correo     = $_POST['correo'];
                    $usuario->direccion  = $_POST['direccion'];
                    $usuario->nombre     = $_POST['nombre'];
                    $usuario->rol_id     = $_POST['rol_id'];

                    // Actualizar el usuario
                    $res = $usuario->guardar();


                    // Comprobar si se actualizo correctamente el usuario en la db
                    if ($res == 1) {
                        $msg = "Usuario se actualizo exitosamente";
                    } else {
                        $msg = "Error al actualizar el usuario";
                    }

                    // Guardar mensaje con el resultado de la operacion de actualizar al usuario en una cookie
                    setcookie('mensaje', $msg, time() + 5 );

                    // Redirigir a la lista con todos los usuarios
                    header('Location: UsuariosControlador.php?action=todos');



                } else {

                    // Guardar un mensaje de error en una cookie (Si la cedula ya existe)
                    setcookie('mensaje', 'La codigo ya se encuentra registrada', time() + 10 );

                    // Redirigir al formulario
                    header("Location: UsuariosControlador.php?action=actualizar&id=$id");
                }



            } else {

                // Requerir la vista que muestra el formulario para actualizar un usuario
                include '../vistas/productos/actualizar.php';
            }

        } else {

            // Redirigir al perfil
            header('Location: UsuariosControlador.php?action=perfil');
        }
    }




    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: ProductosControlador.php');
        }
    }


}


new ProductosControlador;
