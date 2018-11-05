<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Productos</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body>

    <!-- Llamando el php que contiene la navegacion -->
    <nav>
  <div class="nav-wrapper  orange accent-4">

      <?php if ($_SERVER['REQUEST_URI'] != '/posmarket/'): ?>
          <ul>
              <li><a href="./">Inicio</a></li>
          </ul>
      <?php endif; ?>


    <ul class="right">

      <li><a href="login">Mi Cuenta</a></li>
      <li><a href="carrito">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>


    </ul>

  </div>

</nav>

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

            <div class="col s12">

                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text">
                        <th></th>
                        <th class="hidden sm:block">Nombre</th>
                        <th class="hidden sm:block">Precio</th>
                        <th class="hidden sm:block">Cantidad</th>
                        <th></th>

                    </thead>


                    <tbody id="tablaCarrito">

                    </tbody>
                </table>


            </div>
        </div>

        <div class="row">

            <div class="col s10">
                    <span style="font-size: 20px; font-weight: 700;">Total de compra :</span>
                    <span id="total_precio" style="font-size: 2.125rem; color: red; font-weight: 600"></span>
            </div>

            <div class="col s2">

                <a href="productos/crear" class="waves-effect waves-light">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

                <a href="#" class="waves-effect waves-light">
                    <i class="material-icons Small" style="color: #ff5722;">search</i>
                </a>

            </div>
        </div>



    </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios del grupo 3 -->
    <?php include_once '../vistas/includes/productos.php'; ?>




</body>
</html>
