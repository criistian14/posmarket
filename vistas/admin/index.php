<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>



    <main class="container">

        <div class="row">

            <div class="col s12">
                <h2 style="margin-bottom: .8rem;" class="deep-orange-text">Administrador</h2>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Datos basicos del sistema</p>
            </div>

        </div>




        <div class="row">

            <div class="col s12 l7 xl6">
                <div class="card horizontal cursor-pointer">

                    <div class="col s4 flex items-center justify-center teal darken-3 white-text">
                        <i class="material-icons" style="font-size: 8.5rem;">person</i>
                    </div>

                    <div class="col s8 p-0">
                        <div class="card-content">

                            <h4 class="mt-0 uppercase text-grey-darker text-center">Usuarios</h4>
                            <p class="font-bold text-4xl deep-orange-text text-center"><?php echo $numeroUsuarios ?></p>

                        </div>
                    </div>
                </div>
            </div>



            <div class="col s12 l7 xl6">
                <div class="card horizontal cursor-pointer">

                    <div class="col s4 flex items-center justify-center teal darken-3 white-text">
                        <i class="material-icons" style="font-size: 8.5rem;">assignment</i>
                    </div>

                    <div class="col s8 p-0">
                        <div class="card-content">

                            <h4 class="mt-0 uppercase text-grey-darker text-center">Reportes</h4>
                            <p class="font-bold text-4xl deep-orange-text text-center"><?php echo $numeroReportes ?></p>

                        </div>
                    </div>
                </div>
            </div>



            <div class="col s12 l7 xl6">
                <div class="card horizontal cursor-pointer">

                    <div class="col s4 flex items-center justify-center teal darken-3 white-text">
                        <i class="material-icons" style="font-size: 8.5rem;">local_grocery_store</i>
                    </div>

                    <div class="col s8 p-0">
                        <div class="card-content">

                            <h4 class="mt-0 uppercase text-grey-darker text-center">Ventas</h4>
                            <p class="font-bold text-4xl deep-orange-text text-center"><?php echo $numeroVentas ?></p>

                        </div>
                    </div>
                </div>
            </div>



            <div class="col s12 l7 xl6">
                <div class="card horizontal cursor-pointer">

                    <div class="col s4 flex items-center justify-center teal darken-3 white-text">
                        <i class="material-icons" style="font-size: 8.5rem;">card_giftcard</i>
                    </div>

                    <div class="col s8 p-0">
                        <div class="card-content pl-0">

                            <h4 class="mt-0 uppercase text-grey-darker text-center">Productos</h4>
                            <p class="font-bold text-4xl deep-orange-text text-center"><?php echo $numeroProductos ?></p>

                        </div>
                    </div>
                </div>
            </div>









        </div>




        <div class="row mt-24">


            <div class="col s12">
                <h3 class="deep-orange-text">Ultima Venta</h3>
                <hr>


            </div>

        </div>



    </main>




    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de roles -->
    <?php include_once '../vistas/includes/roles.php'; ?>

</body>
</html>
