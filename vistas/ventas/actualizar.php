<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar Venta</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <main class="container">

        <div class="row">
            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Actualizar Venta</h1>
                <!-- <hr> -->
            </div>
        </div>

        <div class="row" style="margin-top: 4rem;">

            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" id="crearCompra">


                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Usuario</h5>

                    <select name="proveedor" required >
                        <!-- <option value="" disabled selected>S</option> -->

                        <?php foreach ($usuarios as $key => $usuario): ?>

                            <?php if ($usuario->id == $venta->usuario_id): ?>

                                <option value="<?php echo $usuario->id ?>" selected><?php echo 'C.C. ' . $usuario->cedula . ' - ' . $usuario->nombre ?></option>

                            <?php else: ?>

                                <option value="<?php echo $usuario->id ?>"><?php echo 'C.C. ' . $usuario->cedula . ' - ' . $usuario->nombre ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                </div>



                <div class="animated">
                    <div class="input-field col s12">

                        <h5 class="deep-orange-text">Medio De Pago</h5>

                        <select name="medio" required>
                            <!-- <option value="" disabled selected>Escoge un medio de pago</option> -->

                            <?php foreach ($medios_pago as $key => $medio_pago): ?>

                                <?php if ($medio_pago->id == $venta->medio_pago_id): ?>

                                    <option value="<?php echo $medio_pago->id ?>" selected><?php echo $medio_pago->medio ?></option>

                                <?php else: ?>

                                    <option value="<?php echo $medio_pago->id ?>"><?php echo $medio_pago->medio ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>


                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Fecha</h5>

                    <input type="text" class="datepicker" name="fecha" value="<?php echo $venta->fecha ?>">
                </div>




                <div class="input-field col s12 mb-0">
                    <h5 class="deep-orange-text mt-8">Items</h5>
                </div>


                <?php foreach ($datos as $dato): ?>

                    <div class="animated">
                        <div class="input-field col s4">
                            <h6 class="deep-orange-text">Producto</h6>

                            <select name="medio" required>
                                <!-- <option value="" disabled selected>Escoge un medio de pago</option> -->

                                <?php foreach ($productos as $producto): ?>

                                    <?php if ($producto->id == $dato['id']): ?>

                                        <option value="<?php echo $producto->id ?>" selected><?php echo $producto->nombre ?></option>

                                    <?php else: ?>

                                        <option value="<?php echo $producto->id ?>"><?php echo $producto->nombre ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </select>

                        </div>
                    </div>


                    <div class="animated">
                        <div class="input-field col s4">
                            <h6 class="deep-orange-text">Cantidad</h6>

                            <input type="number" class="validate" name="valor" required value="<?php echo $dato['cantidad'] ?>">
                            <span class="helper-text" data-error="Obligatorio"></span>

                        </div>
                    </div>


                    <div class="animated">
                        <div class="input-field col s4">
                            <h6 class="deep-orange-text">Valor</h6>

                            <input type="number" class="validate" name="valor" required value="<?php echo $dato['valor'] ?>">
                            <span class="helper-text" data-error="Obligatorio"></span>

                        </div>
                    </div>




                <?php endforeach; ?>



                <div class="animated">
                    <div class="input-field col s12">
                        <h6 class="deep-orange-text">Valor Total</h6>

                        <input type="number" class="validate" name="valor" required value="<?php echo $venta->valor_total ?>">
                        <span class="helper-text" data-error="Obligatorio"></span>

                    </div>
                </div>



                <input type="hidden" name="flag" value="1">

                <div style="margin-top: 5rem; display: inline-block; width: 100%;">
                    <div style="display: flex; justify-content: space-around;">
                        <button type="submit" class="waves-effect waves-light btn deep-orange" >Guardar</button>

                        <a href="<?php echo ruta . '/compras' ?>" class="waves-effect waves-light btn teal darken-3">Cancelar</a>
                    </div>
                </div>


            </form>
        </div>


    </main>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de reportes -->
    <?php include_once '../vistas/includes/compras.php'; ?>


</body>
</html>
