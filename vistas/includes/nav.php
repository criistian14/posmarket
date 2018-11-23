<?php

 # Usuario que no esta logeado

  if(!isset($_SESSION['usuario']) && !isset($_SESSION['admin'])){

?>

<nav>
  <div class="nav-wrapper orange accent-4 flex justify-between">

       <?php if ($_SERVER['REQUEST_URI'] != ruta .'/'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'buscar'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'categoria'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'carrito'):?>

        <ul class="">
            <li id="abrirSidenavCategorias" class="cursor-pointer ml-4 lg:hidden"><i class="material-icons mr-4">menu</i></li>
            <li><a href="<?php echo ruta ?>">Inicio</a></li>
        </ul>



     <?php else: ?>

         <ul class="cursor-pointer ml-4 flex justify-between">
            <div>
                <li id="abrirSidenavCategorias"><i class="material-icons">menu</i></li>
                <li><a href="<?php echo ruta ?>">Posmarket</a></li>
            </div>
         </ul>

      <?php endif; ?>



    <ul>

      <li><a href="<?php echo ruta . '/login' ?>">Mi Cuenta</a></li>

      <li><a href="<?php echo ruta . '/carrito' ?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>

    </ul>

  </div>

</nav>

    <?php if ($_SERVER['REQUEST_URI'] == (ruta . '/')
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'buscar'
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'categoria'
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'carrito'
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'login'
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'registro'): ?>

        <!-- Categorias -->
        <ul id="sidenavCategorias" class="sidenav sidenav-english  hover-teal-darken-3 overflow-y-auto overflow-x-hidden">

            <li style="height: 140px;">
                <a href="<?php echo ruta ?>" class="center" style="display: flex; justify-content: center; align-items: center; height: 100%">
                    <img src="<?php echo ruta . '/public/img/logo.png' ?>" width="75" class="responsive-img">
                </a>
            </li>

            <?php if (explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'buscar'): ?>
                <div class="search-wrapper mt-8">
                    <input id="buscarProductoNav" value="<?php echo $busqueda ?>" placeholder="Buscar producto" style="padding: 7px">
                </div>
            <?php else: ?>
                <div class="search-wrapper mt-8">
                    <input id="buscarProductoNav" placeholder="Buscar producto" style="padding: 7px">
                </div>
            <?php endif; ?>

            <span class="ml-4 mt-8 mb-2 block text-grey-dark font-bold">Categorias</span>


            <li><a href="<?php echo ruta . '/categoria/aseo' ?>">Aseo</a></li>
            <li><a href="<?php echo ruta . '/categoria/cocina' ?>">Cocina</a></li>
            <li><a href="<?php echo ruta . '/categoria/niños' ?>">Niños</a></li>
            <li><a href="<?php echo ruta . '/categoria/tecnologia' ?>">Tecnologia</a></li>
            <li><a href="<?php echo ruta . '/categoria/hogar' ?>">Hogar</a></li>
            <li><a href="<?php echo ruta . '/categoria/ropa' ?>">Ropa</a></li>
            <li><a href="<?php echo ruta . '/categoria/accesorios' ?>">Accesorios</a></li>



        </ul>



    <?php endif; ?>



<?php

########## ADMINISTRADOR ###############
} else if(isset($_SESSION['admin'])){

?>



<nav class="sticky z-50 pin-t">
  <div class="nav-wrapper orange accent-4">

      <?php if ($_SERVER['REQUEST_URI'] != ruta . '/'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'buscar'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'categoria'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'carrito'):?>

        <div class="row flex justify-between">
            <div class="col s0 ">
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            </div>

            <div class="col s10 m10">
                <h5>Panel de administrador</h5>
            </div>

            <div class="col m2 hidden-s">
                <?php $admin = unserialize($_SESSION['admin']);?>
                <h5><?php echo $admin->nombre;?></h5>
            </div>

        </div>

     <?php else: ?>

         <ul class="cursor-pointer ml-4 flex justify-between">
            <div>
                <li id="abrirSidenavCategorias"><i class="material-icons">menu</i></li>
                <li><a href="<?php echo ruta ?>">Posmarket</a></li>
            </div>

            <div class="hidden sm:block">
                <li><a href="<?php echo ruta . '/perfil'?>">Perfil</a></li>
                <li><a href="<?php echo ruta . '/historial' ?>">Mi Historial</a></li>
                <li><a href="<?php echo ruta . '/carrito'?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>
                <li><a href="<?php echo ruta . '/cerrarSession' ?>">Cerrar Sesion</a></li>
            </div>
         </ul>

      <?php endif; ?>

  </div>

</nav>




    <?php if ($_SERVER['REQUEST_URI'] == (ruta . '/')
               || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'buscar'
               || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'categoria'
               || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'carrito'): ?>


       <!-- Categorias -->
       <ul id="sidenavCategorias" class="sidenav sidenav-english hover-teal-darken-3 overflow-y-auto overflow-x-hidden">

           <li style="height: 140px;">
               <a href="<?php echo ruta ?>" class="center" style="display: flex; justify-content: center; align-items: center; height: 100%">
                   <img src="<?php echo ruta . '/public/img/logo.png' ?>" width="75" class="responsive-img">
               </a>
           </li>

           <?php if (explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'buscar'): ?>
               <div class="search-wrapper mt-8">
                   <input id="buscarProductoNav" value="<?php echo $busqueda ?>" placeholder="Buscar producto" style="padding: 7px">
               </div>
           <?php else: ?>
               <div class="search-wrapper mt-8">
                   <input id="buscarProductoNav" placeholder="Buscar producto" style="padding: 7px">
               </div>
           <?php endif; ?>


           <div class="sm:hidden">
               <span class="ml-4 mt-8 mb-2 block text-grey-dark font-bold">Cuenta</span>

               <li><a href="<?php echo ruta . '/perfil'?>">Perfil</a></li>
               <li><a href="<?php echo ruta . '/historial' ?>">Mi Historial</a></li>
               <li><a href="<?php echo ruta . '/carrito'?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>
               <li><a href="<?php echo ruta . '/cerrarSession' ?>">Cerrar Sesion</a></li>
           </div>




           <span class="ml-4 mt-8 mb-2 block text-grey-dark font-bold">Categorias</span>


           <li><a href="<?php echo ruta . '/categoria/aseo' ?>">Aseo</a></li>
           <li><a href="<?php echo ruta . '/categoria/cocina' ?>">Cocina</a></li>
           <li><a href="<?php echo ruta . '/categoria/niños' ?>">Niños</a></li>
           <li><a href="<?php echo ruta . '/categoria/tecnologia' ?>">Tecnologia</a></li>
           <li><a href="<?php echo ruta . '/categoria/hogar' ?>">Hogar</a></li>
           <li><a href="<?php echo ruta . '/categoria/ropa' ?>">Ropa</a></li>
           <li><a href="<?php echo ruta . '/categoria/accesorios' ?>">Accesorios</a></li>



       </ul>

   <?php else: ?>


       <ul id="slide-out" class="sidenav sidenav-fixed hover-teal-darken-3 sidenav-admin">
           <li><a href="<?php echo ruta . '/admin' ?>">Inicio</a></li>
           <li><a href="<?php echo ruta . '/productos' ?>">Productos</a></li>
           <li><a href="<?php echo ruta . '/usuarios' ?>">Usuarios</a></li>
           <li><a href="<?php echo ruta . '/reportes' ?>">Reportes</a></li>
           <li><a href="<?php echo ruta . '/ventas' ?>">Ventas</a></li>
           <li><a href="<?php echo ruta . '/compras' ?>">Compras</a></li>
           <li><a href="<?php echo ruta . '/medios_pago' ?>">Medio De Pago</a></li>
           <li><a href="<?php echo ruta . '/perfil' ?>">Configuracion</a></li>
           <li><a href="<?php echo ruta . '/cerrarSession' ?>">Cerrar Sesion</a></li>

       </ul>



   <?php endif; ?>





<?php
  }else{

?>


<nav class="sticky z-50 pin-t">
  <div class="nav-wrapper orange accent-4">

      <?php if ($_SERVER['REQUEST_URI'] != ruta .'/'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'buscar'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'categoria'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'carrito'):?>

        <ul class="">
            <li id="abrirSidenavUsuario" class="cursor-pointer ml-4 lg:hidden"><i class="material-icons mr-4">menu</i></li>
            <li><a href="<?php echo ruta ?>">Inicio</a></li>
        </ul>



     <?php else: ?>

         <ul class="cursor-pointer ml-4 flex justify-between">
            <div>
                <li id="abrirSidenavCategorias" class="md:hidden"><i class="material-icons">menu</i></li>
                <li><a href="<?php echo ruta ?>">Posmarket</a></li>
            </div>

            <div class="hidden sm:block">
                <li><a href="<?php echo ruta . '/perfil'?>">Perfil</a></li>
                <li><a href="<?php echo ruta . '/historial' ?>">Mi Historial</a></li>
                <li><a href="<?php echo ruta . '/carrito'?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>
                <li><a href="<?php echo ruta . '/cerrarSession' ?>">Cerrar Sesion</a></li>
            </div>
         </ul>

      <?php endif; ?>

    <ul class="right hidden md:block">

      <li><a href="<?php echo ruta . '/perfil'?>">Perfil</a></li>
      <li><a href="<?php echo ruta . '/historial' ?>">Mi Historial</a></li>
      <li><a href="<?php echo ruta . '/carrito'?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>


    </ul>

  </div>

</nav>


    <?php if ($_SERVER['REQUEST_URI'] != ruta .'/'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'buscar'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'categoria'
                && explode('/' ,$_SERVER['REQUEST_URI'])[2] != 'carrito'):?>

        <ul  class="sidenav sidenav-fixed hover-teal-darken-3">

            <li><a href="<?php echo ruta . '/perfil'?>">Perfil</a></li>
            <li><a href="<?php echo ruta . '/historial' ?>">Mi Historial</a></li>
            <li><a href="<?php echo ruta . '/carrito'?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>
            <li><a href="<?php echo ruta . '/cerrarSession' ?>">Cerrar Sesion</a></li>

        </ul>
    <?php endif; ?>




     <?php if ($_SERVER['REQUEST_URI'] == (ruta . '/')
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'buscar'
                || explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'categoria'): ?>


        <!-- Categorias -->
        <ul id="sidenavCategorias" class="sidenav sidenav-english hover-teal-darken-3 overflow-y-auto overflow-x-hidden">

            <li style="height: 140px;">
                <a href="<?php echo ruta ?>" class="center" style="display: flex; justify-content: center; align-items: center; height: 100%">
                    <img src="<?php echo ruta . '/public/img/logo.png' ?>" width="75" class="responsive-img">
                </a>
            </li>

            <?php if (explode('/' ,$_SERVER['REQUEST_URI'])[2] == 'buscar'): ?>
                <div class="search-wrapper mt-8">
                    <input id="buscarProductoNav" value="<?php echo $busqueda ?>" placeholder="Buscar producto" style="padding: 7px">
                </div>
            <?php else: ?>
                <div class="search-wrapper mt-8">
                    <input id="buscarProductoNav" placeholder="Buscar producto" style="padding: 7px">
                </div>
            <?php endif; ?>


            <div class="sm:hidden">
                <span class="ml-4 mt-8 mb-2 block text-grey-dark font-bold">Cuenta</span>

                <li><a href="<?php echo ruta . '/perfil'?>">Perfil</a></li>
                <li><a href="<?php echo ruta . '/historial' ?>">Mi Historial</a></li>
                <li><a href="<?php echo ruta . '/carrito'?>">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>
                <li><a href="<?php echo ruta . '/cerrarSession' ?>">Cerrar Sesion</a></li>
            </div>




            <span class="ml-4 mt-8 mb-2 block text-grey-dark font-bold">Categorias</span>


            <li><a href="<?php echo ruta . '/categoria/aseo' ?>">Aseo</a></li>
            <li><a href="<?php echo ruta . '/categoria/cocina' ?>">Cocina</a></li>
            <li><a href="<?php echo ruta . '/categoria/niños' ?>">Niños</a></li>
            <li><a href="<?php echo ruta . '/categoria/tecnologia' ?>">Tecnologia</a></li>
            <li><a href="<?php echo ruta . '/categoria/hogar' ?>">Hogar</a></li>
            <li><a href="<?php echo ruta . '/categoria/ropa' ?>">Ropa</a></li>
            <li><a href="<?php echo ruta . '/categoria/accesorios' ?>">Accesorios</a></li>



        </ul>



    <?php endif; ?>


<?php
  }
?>
