<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Tipos Reporte</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>



    <main class="container">
        <div class="row">

            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Tipos De Roles</h1>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Tabla con todos los tipos de roles del sistema</p>
            </div>

        </div>


        <div class="row" style="margin-top: 4rem;">

            <div class="col s12">

                <?php if($roles != null) : ?>


                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text">
                        <th>Rol</th>
                        <th></th>
                        <th></th>
                    </thead>


                    <tbody id="tablaRoles">
                        <?php foreach ($roles as $key => $rol) : ?>
                            <tr>
                                <input type="hidden" value="<?php echo $rol->id ?>">

                                <td data-nombre-rol="<?php echo $rol->rol ?>"> <?php echo $rol->rol ?> </td>
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

                    <div class="alerta alerta-teal-darken-3" >No existen roles</div>

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

                <a class="waves-effect waves-light " id="agregarRol">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

            </div>


            <div class="col s12 l7 mt-6 sm:mt-0" >
                <ul class="pagination">

                    <?php if ($pagina != 1): ?>
                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/usuarios/roles/pagina/' . ($pagina-1) ) ?>">
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
                                <a href="<?php echo htmlspecialchars(ruta . "/usuarios/roles/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php else: ?>
                            <li class="waves-effect">
                                <a href="<?php echo htmlspecialchars(ruta . "/usuarios/roles/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php endif; ?>

                    <?php endfor; ?>


                    <?php if ($cantidadDePaginas == $pagina): ?>
                        <li class="disabled"><a>
                            <i class="material-icons">chevron_right</i></a>
                        </li>
                    <?php else: ?>

                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/usuarios/roles/pagina/' . ($pagina+1) ) ?>">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>



    </main>



    <div id="modalCrearRol" class="modal">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?action=crear' ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Crear Rol</h4>

                <input type="hidden" name="flagNuevoRol" value="1">

                <div class="input-field mt-16">
                    <input type="text" class="validate" id="txtNuevoRol" name="nuevoRol" required >
                    <label for="txtNuevoRol">Rol</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" type="submit">Crear</button>
            </div>
        </form>
      </div>



    <div id="modalActualizarRol" class="modal">
        <form action="<?php echo ruta . '/roles/actualizar' ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Actualizar Rol</h4>

                <input type="hidden" name="idRol" id="idActualizarRol" value="0">

                <div class="input-field" style="margin-top: 4rem;">
                    <input type="text" class="validate" id="txtRol" autofocus name="rol" required >
                    <label for="txtRol">Tipo Reporte</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" id="btnActualizarTipoReporte">Actualizar</button>
            </div>
        </form>
    </div>




    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de roles -->
    <?php include_once '../vistas/includes/roles.php'; ?>

</body>
</html>
