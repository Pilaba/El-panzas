<html>
<head>
    <title> Panel de administración </title>
</head>
<body>
<?php
@session_start();
if(!isset($_SESSION["Nombre"]) || $_SESSION["rol"]==2) {
    header("location: ../Index.php");
}
?>

<div id="wrapper">
    <?php
    require_once ("Menu.php");
    require_once ("../FuncionesPHP.php");
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-header"> Promociones </h3>
                </div>
            </div>
            <!-- /.row -->

            <!-- Alerta de proposito general -->
            <div id='MensajeGeneral' class='alert alert-success text-center' role='alert' style="display: none">
                <strong>...</strong>
            </div>

        </div>
        <div class="row">
            <!-- AQUI SE DESPLEGARA INFORMACION DEL PEDIDO-->
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Promocion No: "<strong id="matr"> x </strong>"
                    </div>
                    <div id="DetallePaquete" class="panel-body" style="min-height: 300px">
                        <table id="tablitaDetalles" class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- COLGAR AQUI LOS DETALLES UTILIZANDO JQUERY ;) -->
                            </tbody>
                        </table>
                    </div>
                    <div id="footer" class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                descuento
                            </div>
                            <div class="col-md-12">
                                <div id="spiner">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AQUI VA EL PANEL PARA ALMACENAR LOS SERVICIOS -->
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        PROMOCIÓN
                    </div>
                    <div id="paquete-container" title="¡Ingresa servicios!" class="panel-body" style="min-height: 300px">

                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="button" id="botonPaquete" value="ENVIAR" class="btn btn-info btn-group-justified">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AQUI VA EL PANEL DE LOS SERVICIOS -->
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        SERVICIOS DISPONIBLES
                    </div>
                    <div id="panelBody" class="panel-body" style="min-height: 300px">
                        <ul id="gallery" class="list-group" >
                            <?php
                            $Mysqli=ConectarseaBD();
                            $resultado=$Mysqli->query("SELECT * FROM servicio WHERE serv_estado=1");

                            if($rows=$resultado->num_rows){
                                for ($i=0; $i<$rows; $i++){
                                    $resultado->data_seek($i);
                                    $array=$resultado->fetch_array(MYSQLI_ASSOC);
                                    $nombre=$array["serv_nombre"];
                                    $id=$array["serv_idServicio"];
                                    $precio=$array["serv_precioBase"];

                                    echo <<<_end
                                                <li class="list-group-item">
                                                    <img src="GetImage.php?id=$id" alt="$nombre - $precio" width="96" height="72">
                                                    <a href="#" class="glyphicon glyphicon-plus">Agregar $nombre</a>
                                                    <input class="nombre" value="$nombre" type="hidden">
                                                    <input class="id" value="$id" type="hidden">
                                                    <input class="precio" value="$precio" type="hidden">
                                                </li>
_end;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!-- jQuery & jQuery UI CDN -->
<script src="js/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<style>
    input {display: block; padding: 0; margin: 0; border: 0; width: 100%}
    .ui-state-highlight {background: darkseagreen !important;}
    .custom-state-active {background: lightblue !important;}
</style>

<!-- Custom script -->
<script src="js/AgregarPromociones.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>

</body>
</html>