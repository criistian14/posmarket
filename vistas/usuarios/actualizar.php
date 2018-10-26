<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar Usuario</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <div class="container">

        <div class="row" style="display: flex; justify-content: center; margin-top: 80px">

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" class="col s12 m7 card" style="margin-left: 0;" >

                <span class="card-title deep-orange-text titulo-cart-main">Actualizar</span>

                <?php if ($msg != null): ?>
                    <span class=" red-text "><?php echo $msg ?></span>
                <?php endif; ?>


                <div class="input-field">
                    <i class="material-icons prefix">fingerprint</i>
                    <input type="number" class="validate" id="txtCedula" name="cedula" required
                            value="<?php echo $usuario->cedula ?>">
                    <label for="txtCedula">Cedula</label>
                </div>


                <div class="input-field" style="margin-top: 2rem; margin-bottom: 3rem;">

                    <i class="material-icons prefix">assignment_ind</i>
                    <select name="rol_id" >
                        <option value="" disabled >Escoge un rol</option>

                        <?php foreach ($roles as $key => $rol): ?>

                            <?php if ($usuario->rol_id == $rol->id): ?>
                                <option selected value="<?php echo $rol->id ?>"><?php echo $rol->rol ?></option>
                            <?php else: ?>
                                <option value="<?php echo $rol->id ?>"><?php echo $rol->rol ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>
                    <label>Rol</label>
                </div>


                <div class="input-field">
                    <i class="material-icons prefix">perm_identity</i>
                    <input type="text" class="validate" id="txtNombre" name="nombre" required
                            value="<?php echo $usuario->nombre ?>">
                    <label for="txtNombre">Nombre</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">perm_identity</i>
                    <input type="text" class="validate" id="txtApellido" name="apellido" required
                            value="<?php echo $usuario->apellido ?>">
                    <label for="txtApellido">Apellido</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">email</i>
                    <input type="email" class="validate" id="txtCorreo" name="correo" required
                            value="<?php echo $usuario->correo ?>">
                    <label for="txtCorreo">Correo</label>
                    <span class="helper-text" data-error="Correo valido"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">location_city</i>
                    <input type="text" class="validate" id="txtCiudad" name="ciudad" required
                            value="<?php echo $usuario->ciudad ?>">
                    <label for="txtCiudad">Ciudad</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">location_on</i>
                    <input type="text" class="validate" id="txtDireccion" name="direccion" required
                            value="<?php echo $usuario->direccion ?>">
                    <label for="txtDireccion">Direccion</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">local_phone</i>
                    <input type="number" class="validate" id="txtCelular" name="celular" required
                            value="<?php echo $usuario->celular ?>">
                    <label for="txtCelular">Celular</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <input type="hidden" name="flag" value="1">


                <div style="margin: 50px 0; display: flex; justify-content: space-around;">
                    <!-- <button class="waves-effect waves-light btn deep-orange" id="limpiarFormularioRegistroUsuario">Limpiar</button> -->

                    <button type="submit" class="waves-effect waves-light btn teal darken-3" >Actualizar</button>
                </div>


            </form>


        </div>


    </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios del grupo 3 -->
    <?php include_once '../vistas/includes/grupo3.php'; ?>


</body>
</html>
