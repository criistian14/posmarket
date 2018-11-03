<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Iniciar Session</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <div class="container" style="margin-top: 50px">
        <div class="col s12 m7">
            <div class="card #e8f5e9 green lighten-5">

                <div class="card-content">
                    <div class="row">

                        <form class="col s12" action="./login" method="post">

                            <input type="hidden" name="flag" value="1">

                            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap">
                                <img src="public/img/logo.png" alt="carrito" style="width:100px; height: 100px">
                            </div>

                            <div class="row">

                                <div class="input-field col s12">
                                    <i class="material-icons prefix">email</i>
                                    <input id="icon_prefix" type="email" class="validate" name="correo"
                                            value="<?php echo ( isset($datosUsuario['correo']) ? $datosUsuario['correo'] : '') ?>" required>
                                    <label for="icon_prefix">Correo electronico</label>
                                </div>

                                <div class="input-field col s12">
                                    <i class="material-icons prefix">lock</i>
                                    <input id="icon_telephone" type="password" name="contra" class="validate"
                                            value="<?php echo ( isset($datosUsuario['contra']) ? $datosUsuario['contra'] : '') ?>" required>
                                    <label for="icon_telephone">Contraseña</labe>
                                </div>


                                <?php if ($msg != null): ?>
                                    <span class=" red-text "><?php echo $msg ?></span>
                                <?php endif; ?>

                            </div>

                            <div class="col s12" style="display: flex; justify-content: space-between; flex-wrap: wrap; padding: 20px">

                                <label>
                                    <input type="checkbox" class="filled-in" name="recordarDatos" />
                                    <span>¿Recordar los datos?</span>
                                </label>

                                <button class="btn waves-effect deep-orange darken-1" style="width: 300px" type="submit" name="action">Iniciar Seccion</button>

                                <a href="./registro">Registrarse</a>
                            </div>

                        </form>

                    </div>
                </div>



            </div>
        </div>
    </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>


</body>
</html>
