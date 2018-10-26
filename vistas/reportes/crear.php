<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Reporte</title>


    <!-- Llamando el php que contiene la hoja de estilos -->
    <?php include_once '../vistas/includes/estilos.php'; ?>

</head>
<body>

    <!-- Llamando el php que contiene la navegacion -->
    <?php include_once '../vistas/includes/nav.php'; ?>


    <div class="container">

        <div class="row">
            <div class="col s12">
                <h1 style="margin-bottom: .8rem;" class="deep-orange-text">Crear Reporte</h1>
                <!-- <hr> -->
            </div>
        </div>

        <div class="row" style="margin-top: 4rem;">

            <form action="" id="crearReporte">


                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Tipo de reporte</h5>

                    <select name="tipoReporte" >
                        <option value="" disabled selected>Escoge un tipo de reporte</option>

                        <?php foreach ($tiposReporte as $key => $tipoReporte): ?>
                            <option value="<?php echo $tipoReporte->id ?>"><?php echo $tipoReporte->reporte ?></option>
                        <?php endforeach; ?>

                        <option value="crearNuevoTipo">Crear un tipo de reporte</option>

                    </select>
                </div>

                <div class="input-field col s12">

                    <h5 class="deep-orange-text">Descripcion</h5>

                    <textarea name="descripcion" id="textareaDescripcionReporte"  class="materialize-textarea"></textarea>
                </div>


                <div class="input-field col s12">
                    <label>
                        <input type="checkbox" class="filled-in" id="mostrarListaProductos" />
                        <span>¿Es un producto?</span>
                    </label>
                </div>


                <div class="input-field col s12" id="listaProductos" style="margin-top: 3rem;" >

                    <h5 class="deep-orange-text">Lista De Productos</h5>

                    <select name="tipoReporte" >
                        <option value="" disabled selected>Escoge que producto es</option>

                        <option value="crearNuevoTipo">Crear un producto</option>

                    </select>
                </div>


            </form>
        </div>

    </div>


    <div id="modalCrearTipoReporte" class="modal">
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
            <div class="modal-content">
                <h4 class="deep-orange-text">Crear Tipo De Reporte</h4>

                <input type="hidden" name="flagNuevoTipoReporte" value="1">

                <div class="input-field" style="margin-top: 4rem;">
                    <input type="text" class="validate" id="txtTipoReporte" name="nuevoTipoReporte" required >
                    <label for="txtTipoReporte">Tipo Reporte</label>
                    <span class="helper-text" data-error="Obligatorio"></span>
                </div>

            </div>

            <div class="modal-footer">
                <a class="modal-close waves-effect waves-red btn-flat">Cancelar</a>

                <button class="waves-effect waves-green btn-flat" type="submit">Crear</button>
            </div>
        </form>
      </div>



    <!-- Llamando el php que contiene los scripts -->
    <?php include_once '../vistas/includes/scripts.php'; ?>

    <!-- Llamando el php que contiene los scripts propios del grupo 3 -->
    <?php include_once '../vistas/includes/grupo3.php'; ?>


</body>
</html>
