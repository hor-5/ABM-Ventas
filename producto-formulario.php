<?php

session_start();

include_once("config.php");
include_once("entidades/producto.php");
include_once("entidades/tipodeproducto.php");

if (!isset($_SESSION["nombre"])) {
    header("location:login.php");
}

$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

if ($_POST) {
    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            //Actualizo un cliente existente
            $producto->actualizar();
        } else {
            //Es nuevo
            $producto->insertar();
        }
    } else if (isset($_POST["btnBorrar"])) {
        $producto->eliminar();
    } else if (isset($_POST["btnCerrarSesion"])) {
        session_destroy();
        header("location:login.php");
    }
    header("location:productos.php");
}
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $producto->obtenerPorId();
}

$tipoProducto = new Tipodeproducto();
$aTipoProducto = $tipoProducto->obtenerTodos();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Productos - Formulario</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <?php include_once("header.php"); ?>

    <section class="Registro">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex text-center">
                    <h1>Registro de Productos</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto->nombre ?>">
                </div>
                <div class="col-md-6 form-group">
                <label for="lstTipoProducto">Tipo de Producto:</label>
                    <select name="lstTipoProducto" id="lstTipoProducto" class="form-control">
                        <option disabled selected value="0">Seleccionar</option>
                        <?php foreach ($aTipoProducto as $tipo) : ?>
                            <?php if ($tipo->idtipodeproducto == $producto->fk_idTipoDeProducto) : ?>
                                <option selected value="<?php echo $tipo->idtipodeproducto; ?>"><?php echo $tipo->nombre; ?></option>
                            <?php else : ?>
                                <option value="<?php echo $tipo->idtipodeproducto; ?>"><?php echo $tipo->nombre; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="row">
            <div class="col-md-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="text" required class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $producto->cantidad ?>" maxlength="11">
                </div>
                <div class="col-md-6 form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $producto->precio ?>">
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="txtDescripcion">Descripcion:</label>
                    <input type="text" class="form-control" name="txtDescripcion" id="txtDescripcion" value="<?php echo $producto->descripcion ?>">
                </div>
            </div>                    
 
            <div class="row">
                <div class="col-12">                    
                    <button type="submit" name="btnGuardar" class="btn btn-success">Guardar <i class="fas fa-folder-plus"></i></button>
                    <button type="submit" name="btnBorrar" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></button>
                    <a href="productos.php" class="btn btn-primary" name="btnNuevo">Volver al listado</a>
                </div>
            </div>

        
    </section>

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <?php include_once("footer.php"); ?>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desea salir del sistema?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Hacer clic en "Cerrar sesión" si deseas finalizar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a href="login.php" class="btn btn-primary" name="btnCerrarSesion">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    </form>

</body>

</html>