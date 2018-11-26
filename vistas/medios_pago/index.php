<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Medios De Pago</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>



    <main class="container">
        <div class="row">

            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Medios De Pago</h1>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Tabla con todos los medios de pago del sistema</p>
            </div>

        </div>


        <div class="row" style="margin-top: 4rem;">

            <div class="col s12">

                <?php if($mediosPago != null) : ?>


                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text">
                        <th>Medio Pago</th>
                        <th></th>
                        <th></th>
                    </thead>


                    <tbody id="tablaMediosPago">
                        <?php foreach ($mediosPago as $key => $medioPago) : ?>
                            <tr>
                                <input type="hidden" value="<?php echo $medioPago->id ?>">

                                <td data-nombre-medio-pago="<?php echo $medioPago->medio ?>"> <?php echo $medioPago->medio ?> </td>
                                <td>
                                    <button class="waves-effect waves-light btn-flat"><i class="material-icons" style="color: #ff5722;">create</i></button>
                                </td>
                                <td>
                                    <button class="waves-effect waves-light btn-flat"><i class="material-icons" style="color: #ff5722;">delete</i></button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php else: ?>

                    <div class="alerta alerta-teal-darken-3" >No hay tipos de reportes</div>

                <?php endif ?>



                <?php if ( $msg != null ): ?>
                    <div class="alerta alerta-teal-darken-3" > <?php echo $msg ?> </div>
                <?php endif ?>

                <?php if ( $msgError != null ): ?>
                    <div class="alerta alerta-red-darken-3" > <?php echo $msgError ?> </div>
                <?php endif ?>



            </div>
        </div>


        <div class="mt-16 flex justify-between flex-wrap" >

            <div class="col s12 l5 flex items-center" >

                <a class="waves-effect waves-light " id="agregarMedioPago">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

            </div>


            <div class="col s12 l7 mt-6 sm:mt-0" >
                <ul class="pagination">

                    <?php if ($pagina != 1): ?>
                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/medios_pago/pagina/' . ($pagina-1) ) ?>">
                                <i class="material-icons">chevron_left</i>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="disabled"><a>
                            <i class="material-icons">chevron_left</i></a>
                        </li>
                    <?php endif; ?>


                    <?php for ($i = 1; $i <= $cantidadDePaginas; $i++): ?>

                        <?php if ($pagina == $i): ?>
                            <li class="active">
                                <a href="<?php echo htmlspecialchars(ruta . "/medios_pago/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php else: ?>
                            <li class="waves-effect">
                                <a href="<?php echo htmlspecialchars(ruta . "/medios_pago/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php endif; ?>

                    <?php endfor; ?>


                    <?php if ($cantidadDePaginas == $pagina): ?>
                        <li class="disabled"><a>
                            <i class="material-icons">chevron_right</i></a>
                        </li>
                    <?php else: ?>

                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/medios_pago/pagina/' . ($pagina+1) ) ?>">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>



    </main>



    <div id="modalCrearMedioPago" class="modal">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?action=crear' ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Crear Medio De Pago</h4>

                <div class="input-field" style="margin-top: 4rem;">
                    <input type="text" class="validate" id="txtNuevoMedioPago" name="nuevoMedioPago" required >
                    <label for="txtNuevoMedioPago">Medio de pago</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" type="submit">Crear</button>
            </div>
        </form>
      </div>



    <div id="modalActualizarMedioPago" class="modal">
        <form action="<?php echo ruta . '/medios_pago/actualizar' ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Actualizar Medio De Pago</h4>

                <input type="hidden" name="idMedioPago" id="idActualizarMedioPago" value="0">

                <div class="input-field" style="margin-top: 4rem;">
                    <input type="text" class="validate" id="txtMedioPago" autofocus name="medioPago" required >
                    <label for="txtMedioPago">Medio De Pago</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" id="btnActualizarMedioPago">Actualizar</button>
            </div>
        </form>
    </div>




    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de medios de pago -->
    <?php include_once '../vistas/includes/medios_pago.php'; ?>

</body>
</html>
