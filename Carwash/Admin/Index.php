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
                <div class="col-lg-12">
                    <h1 class="page-header"> Vista Principal <small></small> </h1>
                </div>
            </div>
            <!-- /.row -->

            <?php
                if(isset($_POST["elemento0"])){
                    echo "<div id='dismisThis' class='alert alert-success alert-dismissible text-center ' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'> 
                                    <span aria-hidden='true'>&times;</span></button>
                                </button>
                                 <strong>Exito en la mision</strong>
                          </div>";
                }

            ?>

            </div>
            <div class="row">
                <!-- AQUI VA EL PANEL PARA ALMACENAR LOS SERVICIOS -->
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            PAQUETE
                        </div>
                        <div id="paquete-container" class="panel-body" style="min-height: 300px">

                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text"  id="nombrecliente" class="form-control" placeholder="Nombre Cliente" required="required">
                                </div>
                                <div class="col-md-9">
                                    <input type="button" id="botonPaquete" value="ENVIAR" class="btn btn-info btn-group-justified">
                                    <!-- shadowform HS  ;)-->
                                    <form id="formChingon" action="Index.php" method="POST">

                                    </form>
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
                                $resultado=$Mysqli->query("SELECT * FROM servicio WHERE estado=1");

                                if($rows=$resultado->num_rows){
                                    for ($i=0; $i<$rows; $i++){
                                        $resultado->data_seek($i);
                                        $array=$resultado->fetch_array(MYSQLI_ASSOC);
                                        $nombre=$array["Nombre"];
                                        $precio=$array["preciobase"];
                                        echo <<<_end
                                                <li class="list-group-item">
                                                    <img src="" alt="$nombre - $precio" width="96" height="72">
                                                    <a href="#" class="glyphicon glyphicon-plus">Agregar</a>
                                                    <input id="none" value="$nombre" type="hidden">
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

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>Servicios</div>
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
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-gift fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
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
                                    <div class="huge">124</div>
                                    <div>Clientes</div>
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
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Empleados</div>
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
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!-- jQuery & jQuery UI CDN -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!--Drag and drop script-->
<script src="js/DragandDrop.js"></script>

<!-- Elimina el comentario machin y siente el poder ;) -->
<style>
    .ui-state-highlight {background: darkseagreen}
    .custom-state-active {background: lightblue}
</style>


<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>

</body>
</html>