<?php
   
#########################################################
#   __      _   _     _____   ______   __    _______    #
#  /__\    ( ) ( )   / ___ \ / ___  \ /  \  (  __   )   #                  
# ( \/ )  _| |_| |_ ( (___) )\/   )  )\/) ) | (  )  |   #                 
#  \  /  (_   _   _) \     /     /  /   | | | | /   | _ #           This controller 
#  /  \/\ _| (_) |_  / ___ \    /  /    | | | (/ /) |(_)#             is made by 
# / /\  /(_   _   _)( (   ) )  /  /     | | |   / | |   #              &#8710;
#(  \/  \  | | | |  ( (___) ) /  /    __) (_|  (__) | _ #
# \___/\/  (_) (_)   \_____/  \_/     \____/(_______)( )#
#                                                    |/ #
#########################################################
session_start();

if(!isset($_SESSION['admin'])){

    header("location: /proyecto/index.php");

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php
        include('includes/nav.php');
    ?>

    <div class="container" style="margin-top: 60px">

        
        <div class="row" >
            


                <form enctype="multipart/form-data" action="/proyecto/controladores/GPControlador.php?op=1" method="POST" class="col s12">
                    

                        <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap">
                            
                            <div class="col s12 m10">
                               

                                <!-- CODIGO -->                    
                                <div class="input-field">

                                    <input id="codigo" type="number" class="validate" name="codigo">
                                    <label for="codigo">Codigo</label>

                                </div>

                                <!-- NOMBRE DEL PRODUCTO -->                    
                                <div class="input-field">

                                    <input id="nombre_producto" type="text" class="validate" name="nombre_producto">
                                    <label for="nombre_producto">Nombre del producto</label>

                                </div>


                                <!-- PRECIO -->
                                <div class="input-field">

                                    <input id="precio" type="number" class="validate" name="precio">
                                    <label for="precio">Precio</label>

                                </div>

                                <!-- CANTIDAD -->
                                <div class="input-field">

                                    <input id="cantidad" type="number" class="validate" name="cantidad">
                                    <label for="cantidad">Cantidad</label>

                                </div>
                                <!-- IMAGEN -->
                                <div class="file-field input-field">
                                    <div class="btn deep-orange darken-1">
                                        <i class="large material-icons">add_circle</i>
                                        <input type="file" name="imagen_producto">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Upload one or more files" name="imagen">
                                    </div>
                                </div>

                                <!-- OFERTA -->
                                <div class="input-field">
                                    <input id="oferta" type="number" class="validate" name="oferta">
                                    <label for="oferta">Oferta</label>
                                </div>
                                
                                <!-- TAMAÑO -->
                                <div class="input-field">
                                    <input id="tamano" type="text" class="validate" name="tamano">
                                    <label for="tamano">Tamaño</label>
                                </div>
                                <!-- TIPO DE PRODUCTO -->
                                <div class="input-field">
                                    <input id="tipo_producto" type="text" class="validate" name="tipo_producto">
                                    <label for="tipo_producto">Tipo del producto</label>
                                </div>

                                <p>
                                    <label>
                                        <input id="indeterminate-checkbox" type="checkbox" value="1" name="activo" />
                                        <span>Activo</span>
                                    </label>
                                </p>

                                <button class="btn waves-effect deep-orange darken-1" type="submit" name="action">Crear
                                    
                                </button>
                            
                            </div>

                        </div>

                    
                    

               </form>

                

        </div> 
        

            

        

        
        
    </div>

    <!-- Script Materialice -->
    <script src="/proyecto/public/js/materialize.min.js"></script>
    <!-- Script Propios-->

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.datepicker');
            var instances = M.Datepicker.init(elems);

            var selectprueba = document.querySelectorAll('select');
            var iniciar = M.FormSelect.init(selectprueba);
        });

    
    </script>
   
</body>
</html>

