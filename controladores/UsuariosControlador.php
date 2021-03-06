<?php

session_start();
require_once '../modelos/Usuario.php';
require_once '../modelos/Reporte.php';
require_once '../modelos/Venta.php';
require_once '../modelos/Compra.php';
require_once '../modelos/Rol.php';

class UsuariosControlador
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


    // Funcion que muestra todos los usuarios en una tabla
    public function todos()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // La cantidad de usuarios que va a mostrar
            $numeroUsuarios = 5;

            // Obtener que numero de pagina es
            $pagina = ( isset($_GET['pagina']) ? $_GET['pagina'] : 1 );

            // Conocer el inicio de la consulta
            $inicioConsulta = ( ($pagina == 1) ? 0 : (($numeroUsuarios * $pagina) - $numeroUsuarios) );

            // Contar la cantidad de usuarios
            $totalUsuarios = count(Usuario::todos());

            // El numero de paginas que salen en total
            $cantidadDePaginas = ( ($totalUsuarios == 0) ? 1 : ceil($totalUsuarios / $numeroUsuarios) );


            // Peticion al modelo para recuperar todos los usuarios de la bd y guardarlos en una variable
            $usuarios = Usuario::seleccionar('usuarios.*, roles.rol')
                                ->unir('roles', 'rol_id', 'id')
                                ->limite($inicioConsulta, $numeroUsuarios)
                                ->resultado();



            // Mensaje
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Mensaje Error
            $msgError = ( isset($_COOKIE['mensaje_error']) ? $_COOKIE['mensaje_error'] : null);


            // Requerir la vista que muestra todos los usuarios registrados
            include '../vistas/usuarios/index.php';

        } else {

            // Redirigir al login
            header('Location: login');
        }
    }


    // Funcion para mostrar el formulario de registro de usuarios
    public function registro()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) || !isset($_SESSION['usuario']) ) {

            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Cargar datos del usuario si tuvo un error
            $datosUsuario = ( isset($_COOKIE['datos_usuario_registro']) ? unserialize($_COOKIE['datos_usuario_registro']) : null);

            // Consultar todos los roles
            $roles = Rol::todos();

            // Requerir la vista que muestra el formulario para registrar un usuario
            include '../vistas/usuarios/registro.php';

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
            $comprobarUsuario = Usuario::donde('cedula', $_POST['cedula'])
                                       ->resultado();

           // Comprobar si la cedula no se encuentra registrada
            $cedulaValida = ( empty($comprobarUsuario) ? true : false );


            if ($cedulaValida) {

                // Hacer consulta si existe un usuario con el correo digitada en el formulario
                $comprobarUsuario = Usuario::donde('correo', $_POST['correo'])
                                           ->resultado();

               // Comprobar si el correo no se encuentra registrado
                $correoValido = ( empty($comprobarUsuario) ? true : false );


                if ($correoValido) {

                    // Crear una instancia (Objeto) de Usuario
                    $usuario = new Usuario;

                    // Pasarle los datos a la instancia
                    $usuario->apellido   = $_POST['apellido'];
                    $usuario->cedula     = $_POST['cedula'];
                    $usuario->celular    = $_POST['celular'];
                    $usuario->ciudad     = $_POST['ciudad'];
                    $usuario->contrasena = md5($_POST['contrasena']);
                    $usuario->correo     = $_POST['correo'];
                    $usuario->direccion  = $_POST['direccion'];
                    $usuario->nombre     = $_POST['nombre'];
                    $usuario->rol_id     = isset($_POST['rol_id']) ? $_POST['rol_id'] : 2;

                    // Guardar el usuario
                    $res = $usuario->guardar();


                    // Comprobar si se guardo correctamente el usuario en la db
                    if ($res == 1) {
                        $msg = "Usuario creado exitosamente";
                    } else {
                        $msg = "Error al crear el usuario";
                    }

                    // Guardar mensaje con el resultado de la operacion de guardar al usuario en una cookie
                    setcookie('mensaje', $msg, time() + 5 , '/');

                    // Redirigir a la lista de usuarios
                    header('Location: usuarios');


                } else {

                    // Guardar mensaje con los datos del usuario enviados por POST en una cookie
                    setcookie('datos_usuario_registro', serialize($_POST), time() + 20, '/');

                    // Guardar un mensaje de error en una cookie (Si el correo ya existe)
                    setcookie('mensaje', 'El correo ya se encuentra registrado', time() + 10 , '/');

                    // Redirigir al formulario
                    header('Location: registro');
                }


            } else {

                // Guardar mensaje con los datos del usuario enviados por POST en una cookie
                setcookie('datos_usuario_registro', serialize($_POST), time() + 20, '/');

                // Guardar un mensaje de error en una cookie (Si la cedula ya existe)
                setcookie('mensaje', 'La cedula ya se encuentra registrada', time() + 10 , '/');

                // Redirigir al formulario
                header('Location: registro');
            }



        } else {

            // Si aun no ha completado el formulario se va a redirigir al formulario
            header('Location: registro');
        }

    }


    // Funcion para iniciar session
    public function login()
    {
        // Recibir la cookie del usuario si es que existe
        $usuarioCookie = ( isset($_COOKIE['usuario_session']) ? unserialize($_COOKIE['usuario_session']) : null);

        // Comprobar si ya no existe un usuario en la cookie
        if($usuarioCookie != null) {

            // Comprobar si el usuario es admin
            if( $usuario[0]->rol_id == 1 ) {

                // Guardar los datos en una session admin
                $_SESSION['admin'] = serialize($usuario[0]);

                // Redirigir a usuarios controlador
                header('Location: admin');

            } else {

                // Guardar los datos en una session usuario
                $_SESSION['usuario'] = serialize($usuario[0]);

                // Redirigir a perfil
                header('Location: perfil');
            }

        } else {


            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Cargar datos del usuario si tuvo un error
            $datosUsuario = ( isset($_COOKIE['datos_usuario_login']) ? unserialize($_COOKIE['datos_usuario_login']) : null);

            // Comprobar si se envio por el formulario
            if ( isset($_POST['flag']) ) {



                // Recibir los datos y encriptar la contraseña
                $correo = $_POST["correo"];
                $contra = md5($_POST["contra"]);

                // Encontrar al usuario
                $usuario = Usuario::donde('correo', $correo)
                ->donde('contrasena', $contra)
                ->resultado();

                // Comprobar si el usuario existe
                if ( !empty($usuario) ) {

                    // Comprobar si desea guardar sus datos por mayor tiempo
                    if( isset($_POST['recordarDatos']) ) {

                        // Guardar el usuario en una cookie
                        setcookie('usuario_session', serialize($usuario), time() + (360 * 60 * 60) , '/');
                    }


                    // Comprobar si el usuario es admin
                    if( $usuario[0]->rol_id == 1 ) {

                        // Guardar los datos en una session admin
                        $_SESSION['admin'] = serialize($usuario[0]);

                        // Redirigir a usuarios controlador
                        header('Location: admin');

                    } else {

                        // Guardar los datos en una session usuario
                        $_SESSION['usuario'] = serialize($usuario[0]);

                        // Redirigir a perfil
                        header('Location: perfil');
                    }



                } else {
                    // Guardar mensaje con los datos del usuario enviados por POST en una cookie
                    setcookie('datos_usuario_login', serialize($_POST), time() + 20, '/');

                    // Guardar un mensaje de error en una cookie (Si no encuentra ningun usuario)
                    setcookie('mensaje', 'No coincide con ningun usuario', time() + 10 , '/');

                    // Redirigir al formulario login
                    header('Location: login');
                }


            } else {

                // Comprobar si ya no existe otra session
                if( isset($_SESSION['usuario']) || isset($_SESSION['admin']) ) {

                    // Ruta a la que va a ser redirigido el usuario
                    $ruta = ( isset($_SESSION['admin']) ? 'usuarios' : 'perfil' );

                    // Redirigir al usuario
                    header("Location: $ruta");

                } else {

                    // Requerir la vista que muestra el formulario para actualizar un usuario
                    include '../vistas/usuarios/login.php';
                }

            }
        }

    }


    // Funcion para eliminar un usuario de la base de datos
    public function eliminar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el usuario por el id capturado y guardarlo en una variable
            $usuario = Usuario::encontrarPorID($id);

            $comprobarReportes = Reporte::donde('usuario_id', $id)
                                        ->resultado();

            if (empty($comprobarReportes)) {


                $comprobarVenta = Venta::donde('usuario_id', $id)
                                            ->resultado();

                if (empty($comprobarVenta)) {


                    $comprobarCompra = Compra::donde('usuario_id', $id)
                                                ->resultado();

                    if (empty($comprobarCompra)) {

                        // Guardar un mensaje de que se elimino correctamente en una cookie
                        setcookie('mensaje', 'Se elimino correctamente al usuario ' . $usuario->nombre, time() + 10 , '/');

                        // Eliminar el usuario
                        $usuario->eliminar();


                    } else {

                        // Guardar un mensaje de que se elimino correctamente en una cookie
                        setcookie('mensaje_error', 'No se puede eliminar el usuario ' . $usuario->nombre . ' porque tiene una compra', time() + 10 , '/');
                    }

                } else {

                    // Guardar un mensaje de que se elimino correctamente en una cookie
                    setcookie('mensaje_error', 'No se puede eliminar el usuario ' . $usuario->nombre . ' porque tiene una venta', time() + 10 , '/');
                }


            } else {

                // Guardar un mensaje de que se elimino correctamente en una cookie
                setcookie('mensaje_error', 'No se puede eliminar el usuario ' . $usuario->nombre . ' porque tiene un reporte', time() + 10 , '/');
            }


            // Redirigir a la tabla con todos los usuarios
            header('Location: ../usuarios');

        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }
    }


    // Funcion para actualizar un usuario de la base de datos
    public function actualizar()
    {
        // Comprobar si esta logeado como admin
        if( isset($_SESSION['admin']) ){

            // Capturar el id enviado por GET
            $id = $_GET['id'];

            // Encontra el usuario por el id capturado y guardarlo en una variable
            $usuario = Usuario::encontrarPorID($id);

            // Consultar todos los roles
            $roles = Rol::todos();


            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje']) ? $_COOKIE['mensaje'] : null);

            // Comprobar si se envio por el formulario
            if (isset($_POST["flag"])) {

                // Comprobar si la cedula es la misma que tiene registrada
                if ($_POST['cedula'] == $usuario->cedula) {

                    $cedulaValida = true;
                } else {

                    // Hacer consulta si existe un usuario con la cedula digitada en el formulario
                    $comprobarUsuario = Usuario::donde('cedula', $_POST['cedula'])
                                               ->resultado();


                   // Comprobar si la cedula no se encuentra registrada
                   $cedulaValida = ( empty($comprobarUsuario) ? true : false );
                }



                if ($cedulaValida) {

                    // Comprobar si el correo es el mismo que tiene registrado
                    if ($_POST['correo'] == $usuario->correo) {

                        $correoValido = true;
                    } else {

                        // Hacer consulta si existe un usuario con el correo digitada en el formulario
                        $comprobarUsuario = Usuario::donde('correo', $_POST['correo'])
                                                   ->resultado();

                       // Comprobar si el correo no se encuentra registrado
                       $correoValido = ( empty($comprobarUsuario) ? true : false );
                    }

                    // Comprobar si es un correo valido
                    if ($correoValido) {

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
                        setcookie('mensaje', $msg, time() + 5 , '/');

                        // Redirigir a la lista con todos los usuarios
                        header('Location: ' . ruta . '/usuarios');

                    } else {

                        // Guardar un mensaje de error en una cookie (Si el correo ya existe)
                        setcookie('mensaje', 'El correo ya se encuentra registrado', time() + 10 , '/');

                        // Redirigir al formulario
                        header('Location: '. ruta . "/usuarios/actualizar/$id");
                    }

                } else {

                    // Guardar un mensaje de error en una cookie (Si la cedula ya existe)
                    setcookie('mensaje', 'La cedula ya se encuentra registrada', time() + 10 , '/');

                    // Redirigir al formulario
                    header('Location: '. ruta . "/usuarios/actualizar/$id");
                }



            } else {

                // Requerir la vista que muestra el formulario para actualizar un usuario
                include '../vistas/usuarios/actualizar.php';
            }

        } else {

            // Redirigir al perfil
            header('Location: perfil');
        }
    }


    // Funcion para ver el perfil del usuario logeado
    public function perfil()
    {
        // Comprobar si existe una session
        if( isset($_SESSION['usuario']) || isset($_SESSION['admin']) ) {

            $usuario = (isset($_SESSION['admin']) ? unserialize($_SESSION['admin']) : unserialize($_SESSION['usuario']) );


            // Cargar mensaje de error si es que existe
            $msg = ( isset($_COOKIE['mensaje_perfil']) ? $_COOKIE['mensaje_perfil'] : null);


            // Cargar mensaje de correcto si es que existe
            $msgSuccess = ( isset($_COOKIE['mensaje_perfil_success']) ? $_COOKIE['mensaje_perfil_success'] : null);




            if( isset($_POST['flag']) ) {


                // Comprobar si el correo es el mismo que tiene registrado
                if ($_POST['correo'] == $usuario->correo) {

                    $correoValido = true;
                } else {

                    // Hacer consulta si existe un usuario con el correo digitada en el formulario
                    $comprobarUsuario = Usuario::donde('correo', $_POST['correo'])
                                               ->resultado();

                   // Comprobar si el correo no se encuentra registrado
                   $correoValido = ( empty($comprobarUsuario) ? true : false );
                }

                // Si el correo es valido
                if($correoValido) {

                    // Encontrar el usuario
                    $usuarioEditado = Usuario::encontrarPorID($usuario->id);

                    // Variable para comprobar si cambio la contraseña
                    $cambioContrasena = false;

                    // Comprobar si cambio la contraseña
                    if ( isset($_POST['cambioContrasena']) ) {
                        $cambioContrasena = true;
                    }


                    // Si desea cambiar la contraseña
                    if ($cambioContrasena) {

                        // Comprobar si la antigua contraseña coincide
                        $comprobarAntiguaContrasena = Usuario::donde('contrasena', md5($_POST['antiguaContrasena']))
                                                                ->resultado();

                        if( !empty($comprobarAntiguaContrasena) ) {

                            // Cambiar la contraseña por la nueva
                            $usuarioEditado->contrasena = md5($_POST['nuevaContrasena']);

                        } else {

                            // Guardar un mensaje de error en una cookie (Si la contraseña del usuario no coincide)
                            setcookie('mensaje_perfil', 'No coincide tu antigua contraseña', time() + 10 , '/');

                            // Redirigir al formulario login
                            header('Location: UsuariosControlador.php?action=perfil');

                            return;
                        }

                    } // <-- Fin del cambio de contraseña


                    $usuarioEditado->nombre     = $_POST['nombre'];
                    $usuarioEditado->apellido   = $_POST['apellido'];
                    $usuarioEditado->celular    = $_POST['celular'];
                    $usuarioEditado->ciudad     = $_POST['ciudad'];
                    $usuarioEditado->direccion  = $_POST['direccion'];
                    $usuarioEditado->correo     = $_POST['correo'];



                    // Guardar el usuario editado
                    $usuarioEditado->guardar();


                    if( $usuario->rol_id == 1 ) {

                        // Guardar los datos en una session admin
                        $_SESSION['admin'] = serialize($usuarioEditado);

                    } else {

                        // Guardar los datos en una session usuario
                        $_SESSION['usuario'] = serialize($usuarioEditado);
                    }


                    // Guardar un mensaje de error en una cookie (Si la contraseña del usuario no coincide)
                    setcookie('mensaje_perfil_success', 'Pefil modificado satisfactoriamente', time() + 10 , '/');

                    // Redirigir al formulario login
                    header('Location: perfil');

                } else {

                    // Si el correo no es valido

                    // Guardar un mensaje de error en una cookie (Si la contraseña del usuario no coincide)
                    setcookie('mensaje_perfil', 'El correo '. $_POST['correo'] .' ya esta en uso', time() + 10 , '/');

                    // Redirigir al formulario login
                    header('Location: perfil');

                }



            } else {

                // Requerir la vista que muestra el perfil
                include '../vistas/usuarios/perfil.php';
            }


        } else {

            // Redirigir al login
            header('Location: login');
        }
    }


    public function cerrar()
    {
        session_destroy();

        setcookie('usuario_session', '', time() - 3600, '/');

        header('Location: ./');
    }


    public function error($action)
    {
        if ( empty($action) ) {
            header('Location: usuarios');
        }
    }

}

new UsuariosControlador;
