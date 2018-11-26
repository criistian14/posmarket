<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reportes</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <main class="container">

        <div class="row">

            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Reportes</h1>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Selecciona que deseas hacer con todos los reportes</p>
            </div>

        </div>



        <div class="flex flex-wrap justify-between">

            <!-- <div >
                <a href="#" class="waves-effect waves-light btn deep-orange">Excel <i class="material-icons right" style="color: white;">file_download</i></a>
                <a href="#" class="waves-effect waves-light btn deep-orange">PDF <i class="material-icons right" style="color: white;">insert_drive_file</i></a>
                <a href="#" class="waves-effect waves-light btn deep-orange mt-2 sm:mt-0">Imprimir <i class="material-icons right" style="color: white;">local_printshop</i></a>
            </div> -->

            <div class="mt-6 sm:mt-0">
                <a href="<?php echo ruta . '/reportes/tipos_reporte' ?>" class="waves-effect waves-light btn deep-orange">Tipos de Reporte<i class="material-icons right" style="color: white;">settings</i></a>
            </div>

        </div>



        <div class="row" style="margin-top: 4rem;">

            <div class="col s12">

                <?php if($reportes != null) : ?>


                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text">
                        <tr>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Ciudad</th>
                            <th>Documento</th>
                            <th>Fecha</th>
                            <th>Tipo Reporte</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody id="tablaReportes">
                        <?php foreach ($reportes as $key => $reporte) : ?>
                            <tr>
                                <input type="hidden" value="<?php echo $reporte->id ?>">


                                <td> <?php echo $reporte->usuario->nombre ?> </td>
                                <td> <?php echo $reporte->usuario->rol ?> </td>
                                <td> <?php echo $reporte->usuario->ciudad ?> </td>
                                <td> <?php echo $reporte->usuario->cedula ?> </td>
                                <td> <?php echo $reporte->fecha ?> </td>
                                <td> <?php echo $reporte->tipo_reporte->reporte ?> </td>

                                <td>
                                    <a href="<?php echo ruta . '/reportes/actualizar/' . $reporte->id ?>" class="waves-effect waves-light btn-flat"><i class="material-icons" style="color: #ff5722;">remove_red_eye</i></a>
                                </td>
                                <td>
                                    <button class="waves-effect waves-light btn-flat"><i class="material-icons" style="color: #ff5722;">delete</i></button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php else: ?>

                    <div class="alerta alerta-teal-darken-3" >No hay reportes</div>

                <?php endif ?>


                <?php if ( $msg != null ): ?>
                    <div class="alerta alerta-teal-darken-3" > <?php echo $msg ?> </div>
                <?php endif ?>


            </div>

        </div>


        <div class="mt-16 flex justify-between flex-wrap" >

            <div class="col s12 l5 flex items-center" >

                <a href="<?php echo ruta . '/reportes/crear' ?>" class="waves-effect waves-light">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

            </div>


            <div class="col s12 l7 mt-6 sm:mt-0" >
                <ul class="pagination">

                    <?php if ($pagina != 1): ?>
                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/reportes/pagina/' . ($pagina-1) ) ?>">
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
                                <a href="<?php echo htmlspecialchars(ruta . "/reportes/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php else: ?>
                            <li class="waves-effect">
                                <a href="<?php echo htmlspecialchars(ruta . "/reportes/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php endif; ?>

                    <?php endfor; ?>


                    <?php if ($cantidadDePaginas == $pagina): ?>
                        <li class="disabled"><a>
                            <i class="material-icons">chevron_right</i></a>
                        </li>
                    <?php else: ?>

                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/reportes/pagina/' . ($pagina+1) ) ?>">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>



    </main>




    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de reportes -->
    <?php include_once '../vistas/includes/reportes.php'; ?>


</body>
</html>
