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


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container" style="margin-top: 60px">

        
        <div class="row" style="display: flex; justify-content: space-between; flex-wrap: wrap">
            
                <div class="col s12 m5" style="margin-left: 0">
                
                    <div class="card">

                        <div class="card-image">
                            <img src="img/product.jpg" alt="">
                            
                        </div>

                        <div class="card-content">
                            <span class="card-title">Nombre del producto</span>
                            <p>

                                Descripcion del producto

                            </p>

                        </div>
                    
                    </div>
            
                </div>

                <form action="../CONTROLADOR/GPControlador.php?op=2" method="POST">
                    <div class="col s12" >

                        <div class="row">
                        
                            <!-- FECHA DEL PRODUCTO -->
                            <div class="col m8 input-field">

                                <label for="fecha">Fecha de producto</label>
                                <input id="fecha" type="text" class="datepicker validate">
                            
                            </div>
                            
                            <div class="col m2"></div>
                            <!-- BOTON DE AGREGAR -->
                            <div class="col s2">

                                <a class="waves-effect waves-light btn">Agregar</a>
                            
                            </div>

                        </div>

                        <!-- CLAVE -->
                        <div class="input-field">

                            <input id="clave" type="text" class="validate" name="clave">
                            <label for="clave">Clave</label>

                        </div>

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

                            <input id="precio" type="text" class="validate" name="precio">
                            <label for="precio">Precio</label>

                        </div>

                        <!-- CANTIDAD -->
                        <div class="input-field">

                            <input id="cantidad" type="text" class="validate" name="cantidad">
                            <label for="cantidad">Cantidad</label>

                        </div>

                        <!-- PROVEDOR -->
                        <div class="input-field">
                            <select name="proveedor">

                                <option value="" disabled selected>Seleccione Provedor</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                        
                            </select>

                            <label>Provedores</label>
                        </div>
                        

                    </div>

                    <div class="col s12" style="display: flex; justify-content: space-between; padding: 20px">

                        
                        <button class="btn waves-effect waves-light" type="submit" name="action">Editar
                            <i class="material-icons right">send</i>
                        </button>


                    </div>

               </form>

                

        </div> 
        

            

        

        
        
    </div>

    <!-- Script Materialice -->
    <script src="js/materialize.min.js"></script>
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


