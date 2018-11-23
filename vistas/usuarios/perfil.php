<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pefil</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>
     
    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>
   


    <main class="container">

        <div class="row" style="margin-top: 5rem;">
            <div class="col s12 card">
                <ul class="tabs">
                    <li class="tab"><a href="#datosPersonales">Datos Personales</a></li>
                    <li class="tab"><a href="#datosCuenta">Datos de Cuenta</a></li>
                </ul>

                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" style="margin-top: 3rem;">

                    <?php if ($msg != null): ?>
                        <span class=" red-text " style="margin-bottom: 1.5rem; display: block; font-size: 18px;"><?php echo $msg ?></span>
                    <?php endif; ?>

                    <?php if ($msgSuccess != null): ?>
                        <span class="alerta-teal-darken-3 alerta " style="margin-bottom: 1.5rem; display: block; font-size: 18px;"><?php echo $msgSuccess ?></span>
                    <?php endif; ?>



                    <div id="datosPersonales">


                        <div class="input-field col s12 m6">
                            <!-- <i class="material-icons prefix">fingerprint</i> -->
                            <input type="number" class="validate" id="txtCedula" disabled
                            value="<?php echo $usuario->cedula ?>">
                            <label for="txtCedula">Cedula</label>
                        </div>



                        <div class="input-field col s12 m6">
                            <!-- <i class="material-icons prefix">local_phone</i> -->
                            <input type="number" class="validate" id="txtCelular" name="celular" required
                            value="<?php echo $usuario->celular ?>">
                            <label for="txtCelular">Celular</label>
                        </div>


                        <div class="input-field col s12 m6">
                            <!-- <i class="material-icons prefix">perm_identity</i> -->
                            <input type="text" class="validate" id="txtNombre" name="nombre" required
                                    value="<?php echo $usuario->nombre ?>">
                            <label for="txtNombre">Nombre</label>
                            <span class="helper-text" data-error="Obligatorio"></span>
                        </div>


                        <div class="input-field col s12 m6">
                            <!-- <i class="material-icons prefix">perm_identity</i> -->
                            <input type="text" class="validate" id="txtApellido" name="apellido" required
                                    value="<?php echo $usuario->apellido ?>">
                            <label for="txtApellido">Apellido</label>
                            <span class="helper-text" data-error="Obligatorio"></span>
                        </div>



                        <div class="input-field col s12 m6">
                            <!-- <i class="material-icons prefix">location_city</i> -->
                            <input type="text" class="validate" id="txtCiudad" name="ciudad" required
                                    value="<?php echo $usuario->ciudad ?>">
                            <label for="txtCiudad">Ciudad</label>
                            <span class="helper-text" data-error="Obligatorio"></span>
                        </div>


                        <div class="input-field col s12 m6">
                            <!-- <i class="material-icons prefix">location_on</i> -->
                            <input type="text" class="validate" id="txtDireccion" name="direccion" required
                                    value="<?php echo $usuario->direccion ?>">
                            <label for="txtDireccion">Direccion</label>
                            <span class="helper-text" data-error="Obligatorio"></span>
                        </div>


                    </div>

                    <div id="datosCuenta">

                        <div class="input-field col s12">
                            <!-- <i class="material-icons prefix">email</i> -->
                            <input type="email" class="validate" id="txtCorreo" name="correo" required
                                    value="<?php echo $usuario->correo ?>">
                            <label for="txtCorreo">Correo</label>
                            <span class="helper-text" data-error="Correo valido"></span>
                        </div>


                        <div class="input-field col s12" style="margin-bottom: 5rem;">
                            <label>
                                <input type="checkbox" class="filled-in" name="cambioContrasena" id="cambiarContrasena" />
                                <span>¿Cambiar Contraseña?</span>
                            </label>
                        </div>


                        <div id="mostrarCambiarContrasena" class="animated ocultar">

                            <div class="input-field col s12 m6">
                                <!-- <i class="material-icons prefix">email</i> -->
                                <input type="password" class="validate" id="txtAntiguaContra" name="antiguaContrasena" >
                                <label for="txtAntiguaContra">Antigua Contraseña</label>
                                <span class="helper-text" data-error="Obligatorio"></span>
                            </div>

                            <div class="input-field col s12 m6">
                                <!-- <i class="material-icons prefix">email</i> -->
                                <input type="password" class="validate" id="txtNuevaContra" name="nuevaContrasena" >
                                <label for="txtNuevaContra">Nueva Contraseña</label>
                                <span class="helper-text" data-error="Obligatorio"></span>
                            </div>
                        </div>



                    </div>

                    <input type="hidden" name="flag" value="1">

                    <button type="submit" class="waves-effect waves-light btn deep-orange" >Guardar</button>

                </form>


            </div>
        </div>



    </main>

 


    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts de carrito -->
    <?php include_once '../vistas/includes/carrito.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de usuarios -->
    <?php include_once '../vistas/includes/usuarios.php'; ?>


</body>
</html>
