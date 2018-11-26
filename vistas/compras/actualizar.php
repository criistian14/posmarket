<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar Compra</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <main class="container">

        <div class="row">
            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Actualizar Compra</h1>
                <!-- <hr> -->
            </div>
        </div>

        <div class="row" style="margin-top: 4rem;">

            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" id="crearCompra">


                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Lista De Proveedores</h5>

                    <select name="proveedor" required >
                        <option value="" disabled selected>Escoge un proveedor</option>

                        <?php foreach ($proveedores as $key => $proveedor): ?>

                            <?php if ($proveedor->id == $compra->usuario_id): ?>

                                <option value="<?php echo $proveedor->id ?>" selected><?php echo 'C.C. ' . $proveedor->cedula . ' - ' . $proveedor->nombre ?></option>

                            <?php else: ?>

                                <option value="<?php echo $proveedor->id ?>"><?php echo 'C.C. ' . $proveedor->cedula . ' - ' . $proveedor->nombre ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="animated">
                    <div class="input-field col s12">

                        <h5 class="deep-orange-text">Lista De Productos</h5>

                        <select name="producto" required>
                            <option value="" disabled selected>Escoge un producto</option>

                            <?php foreach ($productos as $key => $producto): ?>

                                <?php if ($producto->id == $compra->producto_id): ?>

                                    <option value="<?php echo $producto->id ?>" selected><?php echo "$producto->codigo: $producto->nombre" ?></option>

                                <?php else: ?>

                                    <option value="<?php echo $producto->id ?>"><?php echo "$producto->codigo: $producto->nombre" ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>



                <div class="animated">
                    <div class="input-field col s12">

                        <h5 class="deep-orange-text">Medios De Pago</h5>

                        <select name="medio" required>
                            <option value="" disabled selected>Escoge un medio de pago</option>

                            <?php foreach ($medios_pago as $key => $medio_pago): ?>

                                <?php if ($medio_pago->id == $compra->medio_pago_id): ?>

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

                    <input type="text" class="datepicker" name="fecha" value="<?php echo $compra->fecha ?>">
                </div>



                <div class="animated">
                    <div class="input-field col s12 m6">
                        <h5 class="deep-orange-text">Cantidad</h5>

                        <input type="number" class="validate" name="cantidad" required value="<?php echo $compra->cantidad ?>">
                        <span class="helper-text" data-error="Obligatorio"></span>

                    </div>
                </div>


                <div class="animated">
                    <div class="input-field col s12 m6">
                        <h5 class="deep-orange-text">Valor Unidad</h5>

                        <input type="number" class="validate" name="valor" required value="<?php echo ($compra->valor_total / $compra->cantidad) ?>">
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
