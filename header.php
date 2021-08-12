<style>
    li{
    list-style: none !important;
      }     
</style>
<form action="" method="POST">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include_once("menu.php"); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
        <div class="row">
    <div class="col-12 text-right">
            
                <li class="nav-item dropdown no-arrow bg-white mt-1 mb-3">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 text-gray-600 small"><?php echo $_SESSION["nombre"]; ?></span>
                    <img class="img-profile rounded-circle" src="https://source.unsplash.com/user/erondu/60x60">
                    </a>                    
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">                    
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cerrar sesión
                    </a>
                    </div>
                </li>
                 
    </div>    

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Está seguro que quiere salir?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Presiona el boton para cerrar sesión.</div>
          <div class="modal-footer">
          <form action="" method="POST" class="text-right"> 
              
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
              <button class="btn btn-primary" name="btnCerrar" action="login.php" type="submit">Cerrar sesion</button>
         </form> 
          </div>
        </div>
      </div>
    </div>
 
            <!-- End of Topbar -->