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
                    <i class="material-icons prefix">vpn_key</i>
                    <input type="text" class="validate" id="txtCedula" name="cedula" required
                            value="<?php echo $producto->codigo ?>">
                    <label for="txtCedula">Codigo</label>
                </div>



                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">perm_identity</i>
                    <input type="text" class="validate" id="txtNombre" name="nombre" required
                            value="<?php echo $producto->nombre ?>">
                    <label for="txtNombre">Nombre</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 15px;">
                    <i class="material-icons prefix">monetization_on</i>
                    <input type="text" class="validate" id="txtApellido" name="apellido" required
                            value="<?php echo $producto->precio ?>">
                    <label for="txtApellido">Precio</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 15px;">
                    <i class="material-icons prefix">grid_on</i>
                    <input type="email" class="validate" id="txtCorreo" name="correo" required
                            value="<?php echo $producto->cantidad ?>">
                    <label for="txtCorreo">Cantidad</label>
                    <span class="helper-text" data-error="Correo valido"></span>
                </div>


                <div class="input-field" style="margin-top: 15px;">
                    <i class="material-icons prefix">shopping_basket</i>
                    <input type="text" class="validate" id="txtCiudad" name="ciudad" required
                            value="<?php echo $producto->oferta ?>">
                    <label for="txtCiudad">Oferta</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

                <div class="input-field" style="margin-top: 15px;">
                    <i class="material-icons prefix">assignment</i>
                    <input type="text" class="validate" id="txtCiudad" name="ciudad" required
                            value="<?php echo $producto->tipo_producto ?>">
                    <label for="txtCiudad">Tipo del producto</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

                <div style="display: flex; justify-content: center; height: 350px" >
                    <img class="materialboxed" width="350" src="<?php echo $producto->imagen ?>" alt="">
                </div>


                <!-- IMAGEN -->
                <div class="file-field input-field">
                    <div class="btn deep-orange darken-1">
                        <i class="large material-icons">add_circle</i>
                        <input type="file" name="imagen_producto">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload one or more files" name="imagen">
                    </div>
                </div>

                <div class="input-field" >
                    <label>
                        <input type="checkbox" class="filled-in" />
                        <span>Activo</span>
                    </label>
                </div>





                <input type="hidden" name="flag" value="1">


                <div style="margin: 100px 0 30px 0; display: flex; justify-content: space-around;">
                    <!-- <button class="waves-effect waves-light btn deep-orange" id="limpiarFormularioRegistroUsuario">Limpiar</button> -->

                    <button type="submit" class="waves-effect waves-light btn teal darken-3" >Actualizar</button>
                </div>


            </form>


        </div>


    </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios del grupo 3 -->
    <?php include_once '../vistas/includes/productos.php'; ?>


</body>
</html>
