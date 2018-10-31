<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar Reporte</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <div class="container">

        <div class="row">
            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Actualizar Reporte</h1>
                <!-- <hr> -->
            </div>
        </div>

        <div class="row" style="margin-top: 4rem;">

            <?php if ($msg != null): ?>
                <span class=" red-text " style="margin-bottom: 1.5rem; display: block; font-size: 18px;"><?php echo $msg ?></span>
            <?php endif; ?>

            <?php if ($msgSuccess != null): ?>
                <span class="alerta-teal-darken-3 alerta " style="margin-bottom: 1.5rem; display: block; font-size: 18px;"><?php echo $msgSuccess ?></span>
            <?php endif; ?>


            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" id="crearReporte">

                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Tipo de reporte</h5>

                    <select name="tipoReporte" required >
                        <!-- <option value="" disabled selected>Escoge un tipo de reporte</option> -->

                        <?php foreach ($tiposReporte as $key => $tipoReporte): ?>

                            <?php if ($tipoReporte->id == $reporte->tipo_reporte_id): ?>
                                <option value="<?php echo $tipoReporte->id ?>" selected><?php echo $tipoReporte->reporte ?></option>
                            <?php else: ?>
                                <option value="<?php echo $tipoReporte->id ?>"><?php echo $tipoReporte->reporte ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <option value="crearNuevoTipo">Crear un tipo de reporte</option>

                    </select>
                </div>



                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Fecha</h5>

                    <input type="text" class="datepicker" name="fecha" value="<?php echo $reporte->fecha ?>">
                </div>



                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Descripcion</h5>

                    <textarea name="descripcion" id="textareaDescripcionReporte" class="materialize-textarea" required><?php echo $reporte->descripcion ?></textarea>
                </div>


                <?php if ($reporte->producto_id == null): ?>

                    <div class="input-field col s12" style="margin-bottom: 2.7rem;">
                        <label>
                            <input type="checkbox" class="filled-in" id="mostrarListaProductos" name="productoConfirmar" />
                            <span>¿Es un producto?</span>
                        </label>
                    </div>


                    <div class="animated ocultar" id="listaProductos" >
                        <div class="input-field col s12">

                            <h5 class="deep-orange-text">Lista De Productos</h5>

                            <select name="producto" >

                                <?php foreach ($productos as $key => $producto): ?>
                                    <option value="<?php echo $producto->id ?>"><?php echo "$producto->codigo: $producto->nombre" ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>

                <?php else: ?>

                    <div class="input-field col s12" style="margin-bottom: 2.7rem;">
                        <label>
                            <input type="checkbox" class="filled-in" checked id="mostrarListaProductos"  />
                            <span>¿Es un producto?</span>
                        </label>
                    </div>


                    <div class="animated" id="listaProductos" >
                        <div class="input-field col s12">

                            <h5 class="deep-orange-text">Lista De Productos</h5>

                            <select name="producto" >

                                <?php foreach ($productos as $key => $producto): ?>
                                    <?php if ($producto->id == $reporte->producto_id): ?>
                                        <option value="<?php echo $producto->id ?>" selected><?php echo "$producto->codigo: $producto->nombre" ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $producto->id ?>"><?php echo "$producto->codigo: $producto->nombre" ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>


                <?php endif; ?>




                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Usuario</h5>

                    <select name="usuario" required >

                        <?php foreach ($usuarios as $key => $usuario): ?>

                            <?php if ($usuario->id == $reporte->usuario_id): ?>
                                <option value="<?php echo $usuario->id ?>" selected><?php echo $usuario->nombre ?></option>
                            <?php else: ?>
                                <option value="<?php echo $usuario->id ?>"><?php echo $usuario->nombre ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>
                </div>




                <input type="hidden" name="flag" value="1">

                <div style="margin-top: 5rem; display: inline-block; width: 100%;">
                    <div style="display: flex; justify-content: space-around;">
                        <button type="submit" class="waves-effect waves-light btn deep-orange" >Guardar</button>

                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="waves-effect waves-light btn teal darken-3">Cancelar</a>
                    </div>
                </div>


            </form>
        </div>

    </div>


    <div id="modalCrearTipoReporte" class="modal">
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Crear Tipo De Reporte</h4>

                <input type="hidden" name="flagNuevoTipoReporte" value="1">

                <div class="input-field" style="margin-top: 4rem;">
                    <input type="text" class="validate" id="txtTipoReporte" name="nuevoTipoReporte" required >
                    <label for="txtTipoReporte">Tipo Reporte</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" type="submit">Crear</button>
            </div>
        </form>
      </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios del grupo 3 -->
    <?php include_once '../vistas/includes/grupo3.php'; ?>


</body>
</html>
