<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Usuarios</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>

<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>



    <main class="container">
        <div class="row">

            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Usuarios registrados</h1>
            </div>


            <div class="col s12">
                <p style="margin-top: 0;">Tabla con todos los usuarios del sistema con sus datos basicos</p>
            </div>

        </div>


        <div class="row">
            <a href="<?php echo ruta . '/usuarios/roles' ?>" class="waves-effect waves-light btn deep-orange">Tipos de Roles<i class="material-icons right" style="color: white;">settings</i></a>
        </div>



        <div class="row" style="margin-top: 4rem;">

            <div class="col s12">

                <?php if($usuarios != null) : ?>


                <table class="responsive-table centered">

                    <thead class="teal darken-3 white-text">
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th>Ciudad</th>
                        <th>Rol</th>
                        <th></th>
                        <th></th>
                    </thead>


                    <tbody id="tablaUsuarios">
                        <?php foreach ($usuarios as $key => $usuario) : ?>
                            <tr>
                                <input type="hidden" value="<?php echo $usuario->id ?>">

                                <td data-nombre-usuario="<?php echo $usuario->nombre ?>"> <?php echo $usuario->nombre ?> </td>
                                <td> <?php echo $usuario->apellido ?> </td>
                                <td> <?php echo $usuario->correo ?> </td>
                                <td> <?php echo $usuario->celular ?> </td>
                                <td> <?php echo $usuario->direccion ?> </td>
                                <td> <?php echo $usuario->ciudad ?> </td>
                                <td> <?php echo $usuario->rol ?> </td>

                                <td>
                                    <a href="<?php echo ruta . '/usuarios/actualizar/' . $usuario->id ?>" class="waves-effect waves-light btn-flat"><i class="material-icons" style="color: #ff5722;">create</i></a>
                                </td>
                                <td>
                                    <button class="waves-effect waves-light btn-flat"><i class="material-icons" style="color: #ff5722;">delete</i></button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?php else: ?>

                    <div class="alerta alerta-teal-darken-3" >No hay usuarios</div>

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

                <a href="<?php echo ruta . '/usuarios/crear' ?>" class="waves-effect waves-light">
                    <i class="material-icons Small" style="color: #ff5722;">add</i>
                </a>

            </div>


            <div class="col s12 l7 mt-6 sm:mt-0" >
                <ul class="pagination">

                    <?php if ($pagina != 1): ?>
                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/usuarios/pagina/' . ($pagina-1) ) ?>">
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
                                <a href="<?php echo htmlspecialchars(ruta . "/usuarios/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php else: ?>
                            <li class="waves-effect">
                                <a href="<?php echo htmlspecialchars(ruta . "/usuarios/pagina/$i") ?>"><?php echo $i ?></a>
                            </li>
                        <?php endif; ?>

                    <?php endfor; ?>


                    <?php if ($cantidadDePaginas == $pagina): ?>
                        <li class="disabled"><a>
                            <i class="material-icons">chevron_right</i></a>
                        </li>
                    <?php else: ?>

                        <li class="waves-effect">
                            <a href="<?php echo htmlspecialchars(ruta . '/usuarios/pagina/' . ($pagina+1) ) ?>">
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

    <!-- Llamando el php que contiene los scripts propios de usuarios -->
    <?php include_once '../vistas/includes/usuarios.php'; ?>

</body>
</html>
