<?php

session_start();

include_once("entidades/venta.php");
include_once("entidades/cliente.php");
include_once("entidades/producto.php");
include_once("config.php");

if (!isset($_SESSION["nombre"])) {
    header("location:login.php");
}

if ($_POST) {
    if (isset($_POST["btnCerrarSesion"])) {
        session_destroy();
        header("location:login.php");
    }
}

$venta = new Venta();
$aVentas = $venta->cargarGrilla();


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <?php include_once("header.php"); ?>

    <!-- Begin Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Listado de Ventas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <a href="venta-formulario.php" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover border">
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($aVentas as $venta) { ?>
                        <tr>
                            <td><?php echo date_format(date_create($venta->fecha), "d/m/Y H:i"); ?></td>
                            <td><?php echo $venta->nombre_cliente; ?></td>
                            <td><?php echo $venta->nombre_producto; ?></td>
                            <td><?php echo $venta->precio; ?></td>
                            <td><?php echo $venta->cantidad; ?></td>
                            <td><?php echo $venta->total; ?></td>
                            <td><a href="venta-formulario.php?id=<?php echo $venta->idventa; ?>"><i class="far fa-edit"></i></a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

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