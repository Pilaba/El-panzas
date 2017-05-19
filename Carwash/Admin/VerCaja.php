<body>
<div id="wrapper">
    <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");
    ?>


    <div id="page-wrapper">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Ver Caja </h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="label label-info">Mostrar por:</h1>
                        <select  class="form-control" id="mostrarCajapor">
                            <option selected value="0"> Ultimos 10 paquetes</option>
                            <option value="1"> Este dia </option>
                            <option value="2"> Ultimos 7 dias </option>
                            <option value="3"> Fecha especifica </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table id="TCaja"class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No. paquete</th>
                                    <th>Fecha</th>
                                    <th>Importe</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="body">
                                <?php
                                    $Link=ConectarseaBD();
                                    $Resultado= $Link->query("SELECT * FROM vehiculo_paquete ORDER BY VP_idPaquete DESC LIMIT 10 ");
                                    $Link->close();

                                    $sumaS=0;
                                    $sumaD=0;
                                    $sumaT=0;
                                    for($i=0; $i<$Resultado->num_rows; $i++){
                                        $Resultado->data_seek($i);
                                        $array=$Resultado->fetch_array(MYSQLI_ASSOC);
                                        $id=$array["VP_idPaquete"];
                                        $fecha=$array["VP_Date"];
                                        $subtotal=$array["VP_Subtotal"];
                                        $descuento=$array["VP_Descuento"];
                                        $Total=$array["VP_total"];

                                        $sumaS+=$subtotal;
                                        $sumaD+=$descuento;
                                        $sumaT+=$Total;

                                        echo <<<_Etiqueta
                                                <tr class="alert-success">
                                                    <td><button class="alert-info" value="$id"> $id</button> </td>
                                                    <td>$fecha</td>
                                                    <td>$subtotal</td>
                                                    <td>$descuento</td>
                                                    <td>$Total</td>
                                                </tr>
_Etiqueta;
                                    }
                                    echo "<tr class='alert-success'> 
                                            <td></td><td></td>
                                            <td>$sumaS</td>
                                            <td>$sumaD</td>
                                            <td>$sumaT</td>
                                          </tr>";
                                    ?>
                            </tbody>

                            <!-- modal de proposito general-->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header alert-success">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Paquete No <strong id="NumPaquete">X</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            Servicios en el paquete
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul id="ColeccionServicios">
                                                                <!-- Colgar los servicios aqui -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            Datos del vehiculo
                                                        </div>
                                                        <div class="panel-body">
                                                            <ul id="Matricula">
                                                                <!-- Colgar la matricula del vehiculo aqui -->
                                                            </ul>
                                                            <ul id="Tipovehiculo">
                                                                <!-- Colgar el tipo del vehiculo aqui -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Script especial -->
<script src="js/VerCaja.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>