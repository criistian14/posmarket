<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Productos</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body class="animated">

    <?php include_once '../vistas/includes/nav.php'; ?>


<div class="container">
        <div class="row">

            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Carrito de compras</h1>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Tabla con sus productos</p>
            </div>


        </div>


        <div class="row" style="margin-top: 4rem;">

            <div class="col s12 card">

                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text hidden">
                        <th></th>
                        <th class="hidden sm:block">Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th></th>

                    </thead>


                    <tbody id="tablaCarrito">

                    </tbody>
                </table>


            </div>
        </div>


        <div class="animated col s12 mb-16 mt-8 ocultar" id="medioPagoCarrito">
            <div class="input-field col s12">

                <h5 class="deep-orange-text">Medios De Pago</h5>
 
                <select name="medio" required>
                    <option value="" disabled selected>Escoge un medio de pago</option>

                    <?php foreach ($medios_pago as $key => $medio_pago): ?>
                        <option value="<?php echo $medio_pago->id ?>"><?php echo $medio_pago->medio ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
        </div>


        <div class="row" id="filaCompra">

            <div class="col s10">
                    <span style="font-size: 20px; font-weight: 700;">Total de compra :</span>
                    <span id="total_precio" style="font-size: 2.125rem; color: red; font-weight: 600"></span>
            </div>

            <div class="col s2">

                <a href="/posmarket" class="waves-effect waves-light">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

                <a class="waves-effect waves-light">
                    <i class="material-icons Small" style="color: #ff5722;">send</i>
                </a>

            </div>
        </div>



    </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts de carrito -->
    <?php include_once '../vistas/includes/carrito.php'; ?>

    <!-- Llamando el php que contiene los scripts de productos -->
    <?php include_once '../vistas/includes/productos.php'; ?>




</body>
</html>
