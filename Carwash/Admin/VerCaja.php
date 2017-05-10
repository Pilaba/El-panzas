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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id Paquete</th>
                                    <th>Fecha</th>
                                    <th>Subtotal</th>
                                    <th>Descuento</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <thbody>
                                <?php
                                    $Link=ConectarseaBD();
                                    $Resultado= $Link->query("SELECT * FROM vehiculo_paquete");
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
                                                    <td><a href="#" data-toggle="modal" data-target="#myModal"> $id</a> </td>
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
                            </thbody>

                            <!-- modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Servicio en el paquete</h4>
                                        </div>
                                        <div class="modal-body">

                                            Vehiculo:
                                            <br>
                                            MATRICULA XX-XX-XX
                                            TIPO Minivan
                                            Usuario balde

                                            <br>
                                            SERVICIO :
                                            <br>
                                            Detallado 24
                                            Pulido 25

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
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

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>