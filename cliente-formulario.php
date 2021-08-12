<?php

session_start();

include_once("config.php");
include_once("entidades/cliente.php");
include_once("entidades/provincia.php");
include_once("entidades/localidad.php");
include_once("entidades/domicilio.php");



if (!isset($_SESSION["nombre"])) {
    header("location:login.php");
}



$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);

if ($_GET) {
    if (isset($_GET["id"]) && $_GET["id"] > 0) {
        $id = $_GET["id"];
        $cliente->obtenerPorId($id);
    }

    if (isset($_GET["do"]) && $_GET["do"] == "buscarLocalidad") {
        $idProvincia = $_GET["id"];
        $localidad = new Localidad();
        $aLocalidad = $localidad->obtenerPorProvincia($idProvincia);
        echo json_encode($aLocalidad);
        exit;
    }

    if (isset($_GET["do"]) && $_GET["do"] == "cargarGrilla") {
        $idCliente = $_GET['idCliente'];
        $request = $_REQUEST;

        $entidad = new Domicilio();
        $aDomicilio = $entidad->obtenerFiltrado($idCliente);

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aDomicilio) > 0)
            $cont = 0;
        for ($i = $inicio; $i < count($aDomicilio) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = $aDomicilio[$i]->tipo;
            $row[] = $aDomicilio[$i]->provincia;
            $row[] = $aDomicilio[$i]->localidad;
            $row[] = $aDomicilio[$i]->domicilio;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aDomicilio), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aDomicilio), //cantidad total de registros en la paginacion
            "data" => $data
        );
        echo json_encode($json_data);
        exit;
    }

}

if ($_POST) {
    if (isset($_POST["btnInsertar"])) {
        $cliente->insertar();
        for ($i = 0; $i < count($_POST["txtTipo"]); $i++) {
            $domicilio = new Domicilio();
            $domicilio->fk_tipo = $_POST["txtTipo"][$i];
            $domicilio->fk_idcliente = $cliente->idcliente;
            $domicilio->fk_idlocalidad = $_POST["txtLocalidad"][$i];
            $domicilio->domicilio = $_POST["txtDomicilio"][$i];
            $domicilio->insertar();
        }
    }
    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            //Actualizo un cliente existente
            $cliente->actualizar();
        } else {
            //Es nuevo
            $cliente->insertar();
        }
    } else if (isset($_POST["btnBorrar"])) {
        $cliente->eliminar();
    } else if (isset($_POST["btnCerrarSesion"])) {
        session_destroy();
        header("location:login.php");
    }
    header("location:clientes.php");
}
if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $cliente->obtenerPorId();
}

$provincia = new Provincia();
$aProvincias = $provincia->obtenerTodos();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Clientes - Registro</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <?php include_once("header.php"); ?>

    <!-- Begin Page Content -->


    <section class="Registro">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <h1>Registro de Clientes</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $cliente->nombre ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCuit">CUIT:</label>
                    <input type="number" required class="form-control" name="txtCuit" id="txtCuit" value="<?php echo $cliente->cuit ?>" maxlength="11">
                </div>
                <div class="col-6 form-group">
                    <label for="txtFechaNac">Fecha de nacimiento:</label>
                    <input type="date" class="form-control" name="txtFechaNac" id="txtFechaNac" value="<?php echo $cliente->fecha_nac ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtTelefono">Teléfono:</label>
                    <input type="number" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo $cliente->telefono ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCorreo">Correo:</label>
                    <input type="" class="form-control" name="txtCorreo" id="txtCorreo" required value="<?php echo $cliente->correo ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12">                    
                    <button type="submit" name="btnGuardar" class="btn btn-success">Guardar <i class="fas fa-folder-plus"></i></button>
                    <button type="submit" name="btnBorrar" class="btn btn-danger">Borrar <i class="fas fa-trash-alt"></i></button>
                    <a href="clientes.php" class="btn btn-primary" name="btnNuevo">Volver al listado</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fa fa-table"></i> Domicilios
                            <div class="pull-right">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalDomicilio">Agregar</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="grilla" class="display" style="width:98%">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Provincia</th>
                                        <th>Localidad</th>
                                        <th>Dirección</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="modalDomicilio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Domicilio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="lstTipo">Tipo:</label>
                            <select name="lstTipo" id="lstTipo" class="form-control">
                                <option value="0" disabled selected>Seleccionar</option>
                                <option value="1">Personal</option>
                                <option value="2">Laboral</option>
                                <option value="3">Comercial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="lstProvincia">Provincia:</label>
                            <select name="lstProvincia" id="lstProvincia" onchange="fBuscarLocalidad();" class="form-control">
                                <option value="0" disabled selected>Seleccionar</option>
                                <?php foreach ($aProvincias as $prov) : ?>
                                    <option value="<?php echo $prov->idprovincia; ?>"><?php echo $prov->nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="lstLocalidad">Localidad:</label>
                            <select name="lstLocalidad" id="lstLocalidad" class="form-control">
                                <option value="0" disabled selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="txtDireccion">Dirección:</label>
                            <input type="text" name="" id="txtDireccion" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="fAgregarDomicilio()">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var idCliente = '<?php echo isset($cliente) && $cliente->idcliente > 0 ? $cliente->idcliente : 0 ?>';
            var dataTable = $('#').DataTable({
                "processing": false,
                "serverSide": true,
                "bFilter": true,
                "bInfo": true,
                "bSearchable": true,
                "pageLength": 25,
                "order": [
                    [0, "asc"]
                ],
                "ajax": "cliente-formulario.php?do=cargarGrilla&idCliente=" + idCliente
            });
        });


        function fBuscarLocalidad() {
            idProvincia = $("#lstProvincia option:selected").val();
            $.ajax({
                type: "GET",
                url: "cliente-formulario.php?do=buscarLocalidad",
                data: {
                    id: idProvincia
                },
                async: true,
                dataType: "json",
                success: function(respuesta) {
                    $("#lstLocalidad option").remove();
                    $("<option>", {
                        value: 0,
                        text: "Seleccionar",
                        disabled: true,
                        selected: true
                    }).appendTo("#lstLocalidad");

                    for (i = 0; i < respuesta.length; i++) {
                        $("<option>", {
                            value: respuesta[i]["idlocalidad"],
                            text: respuesta[i]["nombre"]
                        }).appendTo("#lstLocalidad");
                    }
                    $("#lstLocalidad").prop("selectedIndex", "0");
                }
            });
        }

        function fAgregarDomicilio() {
            var grilla = $('#grilla').DataTable();
            grilla.row.add([
                $("#lstTipo option:selected").text() + "<input type='hidden' name='txtTipo[]' value='" + $("#lstTipo option:selected").val() + "'>",
                $("#lstProvincia option:selected").text() + "<input type='hidden' name='txtProvincia[]' value='" + $("#lstProvincia option:selected").val() + "'>",
                $("#lstLocalidad option:selected").text() + "<input type='hidden' name='txtLocalidad[]' value='" + $("#lstLocalidad option:selected").val() + "'>",
                $("#txtDireccion").val() + "<input type='hidden' name='txtDomicilio[]' value='" + $("#txtDireccion").val() + "'>",
                ""
            ]).draw();
            $('#modalDomicilio').modal('toggle');
            limpiarFormulario();
        }

        function limpiarFormulario() {
            $("#lstTipo").val(0);
            $("#lstProvincia").val(0);
            $("#lstLocalidad").val(0);
            $("#txtDireccion").val("");
        }
    </script>

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
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a href="login.php" class="btn btn-primary" name="btnCerrarSesion">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
    </form>





</body>

</html>