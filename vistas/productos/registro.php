<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear producto</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <div class="container">

        <div class="row" style="display: flex; justify-content: center; margin-top: 80px">

            <form enctype="multipart/form-data" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?action=registrar" class="col s12 m7 card" style="margin-left: 0;" >

                <span class="card-title deep-orange-text titulo-cart-main">Registrar producto</span>

                <?php if ($msg != null): ?>
                    <span class=" red-text "><?php echo $msg ?></span>
                <?php endif; ?>


                <div class="input-field">
                    <i class="material-icons prefix">fingerprint</i>
                    <input type="number" class="validate" id="txtCedula" name="codigo" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['codigo'] : '') ?>">
                    <label for="txtCedula">Codigo</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field">
                    <i class="material-icons prefix">perm_identity</i>
                    <input type="text" class="validate" id="txtNombre" name="nombre" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['nombre'] : '') ?>">
                    <label for="txtNombre">Nombre del producto</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">perm_identity</i>
                    <input type="text" class="validate" id="txtApellido" name="precio" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['precio'] : '') ?>">
                    <label for="txtApellido">Precio</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">email</i>
                    <input type="text" class="validate" id="txtCorreo" name="cantidad" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['cantidad'] : '') ?>">
                    <label for="txtCorreo">Cantidad</label>
                    <span class="helper-text" data-error="Correo valido"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">location_city</i>
                    <input type="text" class="validate" id="txtCiudad" name="oferta" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['oferta'] : '') ?>">
                    <label for="txtCiudad">Oferta</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">location_on</i>
                    <input type="text" class="validate" id="txtDireccion" name="tamano" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['tamano'] : '') ?>">
                    <label for="txtDireccion">Tamaño</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
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


                <div class="input-field" style="margin-top: 25px;">
                    <i class="material-icons prefix">local_phone</i>
                    <input type="number" class="validate" id="txtCelular" name="tipo_producto" required
                            value="<?php echo ( ($datosProducto != null) ? $datosProducto['tipo_producto'] : '') ?>">
                    <label for="txtCelular">Tipo del producto</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>
              
                <p>
                    <label>
                        <input id="indeterminate-checkbox" type="checkbox" value="1" name="activo" />
                        <span>Activo</span>
                    </label>
                </p>



                <input type="hidden" name="flag" value="1">


                <div style="margin: 50px 0; display: flex; justify-content: space-around;">
                    <button class="waves-effect waves-light btn deep-orange" id="limpiarFormularioRegistroUsuario">Limpiar</button>

                    <button type="submit" class="waves-effect waves-light btn teal darken-3" >Registrar</button>
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
