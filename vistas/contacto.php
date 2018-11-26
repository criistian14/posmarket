<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contacto</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <main class="container">

        <div class="row">
            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Contacto</h1>
                <!-- <hr> -->
            </div>
        </div>

        <div class="row" style="margin-top: 4rem;">

            <?php if ( $msg != null ): ?>
                <div class="alerta alerta-teal-darken-3" > <?php echo $msg ?> </div>
            <?php endif ?>

            <?php if ( $msgError != null ): ?>
                <div class="alerta alerta-red-darken-3" > <?php echo $msgError ?> </div>
            <?php endif ?>


            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="post" id="crearReporte">

                <?php if ($usuario_id == null): ?>

                    <div class="col s12 m6">
                        <h5 class="deep-orange-text mb-0">Nombre</h5>

                        <div class="input-field mt-0">
                            <input type="text" class="validate" name="nombre" required>
                            <span class="helper-text" data-error="Obligatorio"></span>
                        </div>

                    </div>


                    <div class="col s12 m6">
                        <h5 class="deep-orange-text mb-0">Apellido</h5>

                        <div class="input-field mt-0">
                            <input type="text" class="validate" name="apellido" required>
                            <span class="helper-text" data-error="Obligatorio"></span>
                        </div>

                    </div>


                    <div class="col s12">
                        <h5 class="deep-orange-text mb-0">Correo</h5>

                        <div class="input-field mt-0">
                            <input type="email" class="validate" name="correo" required>
                            <span class="helper-text" data-error="Correo invalido"></span>
                        </div>

                    </div>

                <?php else: ?>

                    <input type="hidden" name="usuario_id" value="<?php echo $usuario_id ?>">
                <?php endif; ?>





                <div class="col s12">
                    <h5 class="deep-orange-text mb-0">Asunto</h5>

                    <div class="input-field mt-0">
                        <input type="text" class="validate" name="asunto" required>
                        <span class="helper-text" data-error="Obligatorio"></span>
                    </div>

                </div>


                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Motivo</h5>

                    <textarea name="motivo" class="materialize-textarea" required></textarea>
                </div>




                <input type="hidden" name="flag" value="1">

                <div style="margin-top: 5rem; display: inline-block; width: 100%;">
                    <div style="display: flex; justify-content: space-around;">
                        <button type="submit" class="waves-effect waves-light btn deep-orange" >Guardar</button>

                        <a href="<?php echo ruta ?>" class="waves-effect waves-light btn teal darken-3">Cancelar</a>
                    </div>
                </div>


            </form>
        </div>



    </main>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios de reportes -->
    <?php include_once '../vistas/includes/reportes.php'; ?>


</body>
</html>
