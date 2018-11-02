<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Tipos Reportes</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>



    <main class="container">
        <div class="row">

            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Tipos De Reportes</h1>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Tabla con todos los tipos de reportes del sistema</p>
            </div>

        </div>


        <div class="row" style="margin-top: 4rem;">

            <div class="col s12">

                <?php if($tiposReporte != null) : ?>


                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text">
                        <th>Tipo Reporte</th>
                        <th></th>
                        <th></th>
                    </thead>


                    <tbody id="tablaTiposReporte">
                        <?php foreach ($tiposReporte as $key => $tipoReporte) : ?>
                            <tr>
                                <input type="hidden" value="<?php echo $tipoReporte->id ?>">

                                <td data-nombre-tipo-reporte="<?php echo $tipoReporte->reporte ?>"> <?php echo $tipoReporte->reporte ?> </td>
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


        <div class="row" style="margin-top: 4rem;">

            <div class="col s12 l5" >

                <a class="waves-effect waves-light" id="agregarTiposReporte">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

                <a href="#" class="waves-effect waves-light" id="buscarTiposReporte">
                    <i class="material-icons Small" style="color: #ff5722;">search</i>
                </a>

            </div>


            <div class="col s12 l7" style="display: flex; justify-content: flex-end;">
                <ul class="pagination">

                    <?php if ($pagina != 1): ?>
                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?action=todos&pagina=' . ($pagina-1) ) ?>">
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
                                <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?action=todos&pagina=$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php else: ?>
                            <li class="waves-effect">
                                <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?action=todos&pagina=$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php endif; ?>

                    <?php endfor; ?>


                    <?php if ($cantidadDePaginas == $pagina): ?>
                        <li class="disabled"><a>
                            <i class="material-icons">chevron_right</i></a>
                        </li>
                    <?php else: ?>
                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?action=todos&pagina=' . ($pagina+1) ) ?>">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>



    </main>



    <div id="modalCrearTipoReporte" class="modal">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?action=crear' ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Crear Tipo De Reporte</h4>

                <input type="hidden" name="flagNuevoTipoReporte" value="1">

                <div class="input-field" style="margin-top: 4rem;">
                    <input type="text" class="validate" id="txtNuevoTipoReporte" name="nuevoTipoReporte" required >
                    <label for="txtNuevoTipoReporte">Tipo Reporte</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" type="submit">Crear</button>
            </div>
        </form>
      </div>



      <div id="modalActualizarTipoReporte" class="modal">
            <form >
                <div class="modal-content">
                    <h4 class="deep-orange-text">Actualizar Tipo De Reporte</h4>

                    <input type="hidden" name="idTipoReporte" id="idActualizarTipoReporte" value="0">

                    <div class="input-field" style="margin-top: 4rem;">
                        <input type="text" class="validate" id="txtTipoReporte" autofocus name="tipoReporte" required >
                        <label for="txtTipoReporte">Tipo Reporte</label>
                        <span class="helper-text" data-error="Obligatorio"></span>
                    </div>

                </div>

                <div class="modal-footer">
                    <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                    <button class="waves-effect waves-green btn-flat" id="btnActualizarTipoReporte">Crear</button>
                </div>
            </form>
        </div>




    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de tipo de reportes -->
    <?php include_once '../vistas/includes/tipo_reportes.php'; ?>

</body>
</html>
