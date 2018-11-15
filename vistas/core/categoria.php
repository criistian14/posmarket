<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Categoria <?php echo ucfirst($categoria) ?></title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

<div class="contenedor-div" >

    <?php include_once('../vistas/includes/nav.php'); ?>


<!-- Productos de Categoria  -->

<h3 class="grey lighten-3 p-3">Productos de la categoria <span class="deep-orange-text capitalize"><?php echo $categoria ?></span></h3>

  <div class="container relative">

      <!-- Todos los productos -->
    <div class="row" id="productos-oferta">

        <?php foreach ($productos as $key => $value): ?>

            <div class='col s12 m4'>
                <div class='card' id="<?php echo $value->id ?>">
                    <div class='card-image'>

                      <img src='<?php echo $value->imagen?>' style="width: 100%; height: 30vh">
                      <span class='card-title'>
                        <?php echo $value->nombre ?>
                      </span>

                    </div>

                    <?php if ($value->oferta > 0): ?>


                        <div class='card-content'>
                            <p class="old-price line-through font-bold text-grey-darker">
                                <span class="text-sm">Precio Normal</span>
                                <span>$<?php echo number_format($value->precio) ?></span>
                            </p>

                            <p class="new-price text-red font-bold">
                                <span class="text-xl">Hoy</span>
                                <span class="text-4xl ml-3">$<?php echo number_format($value->oferta) ?></span>
                            </p>
                        </div>


                    <?php else: ?>

                        <div class='card-content'>
                            <p class="new-price text-red font-bold">
                                <span class="text-xl">Precio</span>
                                <span class="text-4xl ml-3">$<?php echo number_format($value->precio) ?></span>
                            </p>
                        </div>


                    <?php endif; ?>


                    <div class='card-action'>
                      <button class='btn-floating btn-large waves-effect waves-light red'>
                      <i class='material-icons'>add</i>
                      </button>
                    </div>

                </div>
            </div>

        <?php endforeach;?>
    </div>



  </div>



</div>
<!-- Gitter Chat Link -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red" href="<?php echo ruta . '/contacto' ?>"><i class="large material-icons">chat</i></a>
</div>





<!-- Llamando el php que contiene los scripts de carrito -->
<?php include_once '../vistas/includes/carrito.php'; ?>


<!-- Llamando el php que contiene los scripts -->
<?php include_once '../vistas/includes/scripts.php'; ?>




</body>
</html>
