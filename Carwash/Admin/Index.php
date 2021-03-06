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
        require_once ("../FuncionesPHP.php");
        require_once ("Menu.php");
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-header"> <strong>Vista Principal</strong> </h4>
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
                            DETALLE: "<strong id="matr">.</strong> - <strong id="tip">.</strong>"
                            <br>
                            <strong id="numVeces"></strong>
                        </div>
                        <div id="DetallePaquete" class="panel-body" style="min-height: 300px">
                            <table id="tablitaDetalles" class="table">
                                <thead> Orden <em id="NumOrden"> <?php
                                                    $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM paquete WHERE paq_tipo=1");
                                                    $resuta->data_seek(0);
                                                    $resuta=$resuta->fetch_array(MYSQLI_NUM);
                                                    echo ($resuta[0]+1);
                                             ?></em>
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
                            PAQUETE
                        </div>
                        <div id="paquete-container" title="¡Ingresa servicios!" class="panel-body" style="min-height: 300px">

                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" maxlength="8" id="matricula" class="form-control" title="¡Ingresa la matricula!" placeholder="Matricula Vehicular" required>
                                </div>
                                <div class="col-md-6">
                                    <select title="¡Selecciona un tipo de vehiculo!" class="form-control" id="tipoVehiculo">
                                        <option selected value="0">Tipo Vehiculo</option>
                                        <?php
                                            $link=ConectarseaBD();
                                            $result=$link->query("SELECT * FROM tipovehiculo");

                                            for($i=0; $i<$result->num_rows; $i++){
                                                $result->data_seek($i);
                                                $array=$result->fetch_array(MYSQLI_ASSOC);
                                                $idTipo=$array["tv_idTipo"];
                                                $nombre=$array["tv_nombre"];
                                                echo "<option value='$idTipo'>$nombre</option>";
                                            }
                                            $link->close();
                                            $result->close()
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
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
                                                <li class="list-group-item Servicio">
                                                   <img class="img-rounded" src="GetImage.php?id=$id" alt="$nombre - $precio" width="96" height="72">
                                                   <a href="#" class="glyphicon glyphicon-plus">Agregar $nombre</a>
                                                   <input class="nombre" value="$nombre" type="hidden">
                                                   <input class="id" value="$id" type="hidden">
                                                   <input class="precio" value="$precio" type="hidden">
                                                </li>
_end;
                                    }
                                }
                                $resultado=$Mysqli->query("SELECT * 
                                FROM paquete P JOIN tipopaquete TP ON P.paq_tipo=TP.tp_idTipo WHERE (P.paq_tipo!=1 AND paq_Estado=1)");

                                if($rows=$resultado->num_rows){
                                    for ($i=0; $i<$rows; $i++) {
                                        $resultado->data_seek($i);
                                        $array = $resultado->fetch_array(MYSQLI_ASSOC);
                                        $nombrePromo = $array["tp_nombre"];
                                        $id = $array["paq_idPaquete"];
                                        $Importe = $array["paq_importe"];
                                        $Descuento = $array["paq_descuento"];
                                        $Total = $array["paq_Total"];

                                        $NomServ = $Mysqli->query("SELECT s.serv_nombre
                                        FROM paquete_servicio ps join servicio s on ps.PS_idServicio=s.serv_idServicio
                                        WHERE ps.PS_idPaquete='$id'");
                                        $Servicios="";
                                        if($rows2=$NomServ->num_rows){
                                            for ($j=0; $j<$rows2; $j++){
                                                $NomServ->data_seek($j);
                                                $arr=$NomServ->fetch_array(MYSQLI_ASSOC);
                                                $Servicios.=", ".$arr["serv_nombre"];
                                            }
                                        }
                                        $Servicios=substr($Servicios, 1);

                                        echo <<<_END
                                            <li class="list-group-item promo" title="$Servicios">
                                                   <img class="img-rounded" src="../GetPromotionImage.php?numProm=$id" alt="$nombrePromo &ac; $Servicios" width="96" height="72" style="background-color: cadetblue;font:13px Impact; color: black">
                                                   <a href="#" class="glyphicon glyphicon-plus">Agregar $nombrePromo</a>
                                                   <input class="nombre" value="$nombrePromo" type="hidden">
                                                   <input class="id" value="$id" type="hidden">
                                                   <input class="precio" value="$Total" type="hidden">
                                                   <input class="promo" value="1" type="hidden">
                                            </li>
_END;
                                    }
                                }
                                $Mysqli->close();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM servicio");
                                            $resuta->data_seek(0);
                                            $resuta=$resuta->fetch_array(MYSQLI_NUM);
                                            echo ($resuta[0]);
                                        ?>
                                    </div>
                                    <div>Servicios</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="ModificarServicio.php">
                                    <span class="pull-left">Ver detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </a>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-gift fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM paquete WHERE paq_tipo!=1");
                                        $resuta->data_seek(0);
                                        $resuta=$resuta->fetch_array(MYSQLI_NUM);
                                        echo ($resuta[0]);
                                        ?>
                                    </div>
                                    <div>Promociones</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php
                                            $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM usuario WHERE usu_idRol='2'");
                                            $resuta->data_seek(0);
                                            $resuta=$resuta->fetch_array(MYSQLI_NUM);
                                            echo ($resuta[0]);
                                        ?>
                                    </div>
                                    <div>Clientes</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="VerClientes.php">
                                    <span class="pull-left">Ver detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </a>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php
                                            $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM empleado ");
                                            $resuta->data_seek(0);
                                            $resuta=$resuta->fetch_array(MYSQLI_NUM);
                                            echo ($resuta[0]);
                                        ?>
                                    </div>
                                    <div>Empleados</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <a href="VerEmpleados.php">
                                    <span class="pull-left">Ver detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </a>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!------------------------- MODAL DE PROPOSITO GENERAL ------------------->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <div id="Panel" class="panel panel-info">
                    <div class="panel-heading" id="title">

                    </div>
                    <div id="PanelBody" class="panel-body">
                        <!-- Colgar datos aqui-->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="Cambios" type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & jQuery UI CDN -->
<script src="js/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="css/jquery-ui.css">
<style>
    input {display: block; padding: 0; margin: 0; border: 0; width: 100%}
    .ui-state-highlight {background: darkseagreen !important;}
    .custom-state-active {background: lightblue !important;}
</style>

<!--Drag and drop script-->
<script src="js/DragandDrop.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>

</body>
</html>