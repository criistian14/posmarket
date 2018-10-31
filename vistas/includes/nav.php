<?php



  if(!isset($_SESSION['usuario']) && !isset($_SESSION['admin'])){

?>

<nav class="orange accent-4">
  <div class="row" style="margin: 0px">
      <div class="col s3">
        <a href="../" class="brand-logo"><img src="./public/img/logo.png" width="65" class="responsive-img"></a>
      </div>
      <div class="col s6">

          <form style="margin-top: 10px">

            <div class="input-field">

              <input id="search" type="search" class="white" style="padding-left: 8px; border-radius: 25px">

            </div>

          </form>
      </div>
      <div class="col s3">

          <div>
            <ul id="nav-mobile" class="right hide-on-med-and-down">


            <li><a href="./controladores/UsuariosControlador.php?action=login">Cuenta</a></li>

              <li><a href="#">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>

            </ul>
          </div>

      </div>
  </div>
</nav>

<?php
  } else if(isset($_SESSION['admin'])){

?>
<nav class="orange accent-4">
  <div class="row" style="margin: 0px">
      <div class="col s3">
        <a href="../vistas/indexAdmin.php" class="brand-logo"><img src="../public/img/logo.png" width="65" class="responsive-img"></a>
      </div>
      <div class="col s9">

          <div>
            <ul id="nav-mobile" class="right hide-on-med-and-down">


              <li><a href="./ProductosControlador.php">Gestionar Productos</a></li>
              <li><a href="#">Ventas</a></li>
              <li><a href="./UsuariosControlador.php">Usuarios</a></li>
              <li><a href="./ReportesControlador.php">Reportes</a></li>
              <li><a href="./UsuariosControlador.php?action=perfil">Cuenta</a></li>
              <li><a href="#">Configuracion</a></li>
              <li><a href="./UsuariosControlador.php?action=cerrar">Cerrar Seccion</a></li>
            </ul>
          </div>

      </div>
  </div>
</nav>

<?php
  }else{

?>

<nav class="orange accent-4">
  <div class="row" style="margin: 0px">
      <div class="col s3">
        <a href="/proyecto/index.php" class="brand-logo"><img src="/posmarket/public/img/logo.png" width="65" class="responsive-img"></a>
      </div>
      <div class="col s5">

          <form style="margin-top: 10px">

            <div class="input-field">

              <input id="search" type="search" class="white" style="padding-left: 8px; border-radius: 25px">

            </div>

          </form>
      </div>
      <div class="col s4">

          <div>
            <ul id="nav-mobile" class="right hide-on-med-and-down">

              <li><a href="./controladores/UsuariosControlador.php?action=login">Mi Cuenta</a></li>

              <li><a href="#">Mi Carrito <span class="red" style="padding: 6px; border-radius: 15px" id="contador_productos">0</span></a></li>
              <li><a href="./controladores/UsuariosControlador.php?action=cerrar">Cerrar Seccion</a></li>

            </ul>
          </div>

      </div>
  </div>
</nav>

<?php
  }
?>
