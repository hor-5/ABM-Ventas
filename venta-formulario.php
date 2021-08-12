<?php

session_start();

include_once("config.php");
include_once("entidades/venta.php");
include_once("entidades/cliente.php");
include_once("entidades/producto.php");

if (!isset($_SESSION["nombre"])) {
    header("location:login.php");
}

$venta = new Venta();
$venta->cargarFormulario($_REQUEST);

if ($_POST) {
    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            $venta->actualizar();
        } else {
            $venta->insertar();
        }
    } else if (isset($_POST["btnBorrar"])) {
        $venta->eliminar();
    } else if (isset($_POST["btnCerrarSesion"])) {
        session_destroy();
        header("location:login.php");
    }
    header("location:ventas.php");
}
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $venta->obtenerPorId();
}
if (isset($_GET["do"]) && $_GET["do"] == "buscarProducto") {
    $idProducto = $_GET["id"];
    $producto = new Producto();
    $producto->idproducto = $idProducto;
    $producto->obtenerPorId();
    echo json_encode($producto->precio);
    exit;
}


$cliente = new Cliente();
$aClientes = $cliente->obtenerTodos();
$producto = new Producto();
$aProductos = $producto->obtenerTodos();



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Venta - Registro</title>

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
            <div class="col-sm-12 d-flex justify-content-center">
                <h1>Registro de Venta</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6 form-group">
                <label for="txtFecha">Fecha:</label>
                <input type="date" class="form-control" name="txtFecha" id="txtFecha" value="<?php echo date_format(date_create($venta->fecha), "Y-m-d"); ?>">
            </div>
            <div class="col-6 form-group">
                <label for="txtHora">Hora:</label>
                <input type="time" class="form-control" name="txtHora" id="txtHora" value="<?php echo date_format(date_create($venta->fecha), "H:i"); ?>">
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="lstCliente">Cliente:</label>
                    <select required class="form-control" name="lstCliente" id="lstCliente">
                        <option disabled selected value="0">Seleccionar</option>
                        <?php foreach ($aClientes as $cliente) { ?>
                            <?php if ($cliente->idcliente == $venta->fk_idcliente) { ?>
                                <option selected value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $cliente->idcliente ?>"><?php echo $cliente->nombre; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="txtNombre">Producto:</label>
                    <select onchange="fBuscarPrecio()" required class="form-control" name="lstProducto" id="lstProducto">
                        <option disabled selected value="0">Seleccionar</option>
                        <?php foreach ($aProductos as $producto) {  ?>
                            <?php if ($producto->idproducto == $venta->fk_idproducto) { ?>
                                <option selected value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="from-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input onchange="fCalcularTotal()" class="form-control" type="text" name="txtCantidad" id="txtCantidad" value="<?php echo $venta->cantidad; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input class="form-control" type="text" name="txtPrecio" id="txtPrecio" value="<?php echo $venta->precio; ?>">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="txtTotal">Total:</label>
                    <input class="form-control" type="text" name="txtTotal" id="txtTotal" value="<?php echo $venta->total; ?>">
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">                
                    <button type="submit" name="btnGuardar" class="btn btn-success">Guardar <i class="fas fa-folder-plus"></i></button>
                    <button type="submit" name="btnBorrar" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></button>
                    <a href="ventas.php" class="btn btn-primary">Volver al listado</a>
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

    <script>
        function fCalcularTotal() {
            var precio = $('#txtPrecio').val();
            var cantidad = $('#txtCantidad').val();
            var total = precio * cantidad;
            $("#txtTotal").val(total);
        }

        function fBuscarPrecio() {
            idProducto = $("#lstProducto option:selected").val();
            $.ajax({
                type: "GET",
                url: "venta-formulario.php?do=buscarProducto",
                data: {
                    id: idProducto
                },
                async: true,
                dataType: "json",
                success: function(respuesta) {
                    $("#txtPrecio").val(respuesta);
                }
            });

        }
    </script>

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