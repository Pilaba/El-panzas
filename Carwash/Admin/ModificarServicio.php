<body>
<div id="wrapper">
    <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");
    ?>

    <div id="page-wrapper">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Modificar Servicio </h2>
            </div>
            <div class="panel-body">
                <div class="col-md-3">
                    <div class="list-group">
                        <?php
                            if(isset($_POST["nombre"])){

                            }

                            $link = ConectarseaBD();
                            $Result = $link->query("SELECT * FROM servicio ");
                            $link->close();


                            echo "<table id='Tablita' class='table'> ";
                                for($i=0; $i<$Result->num_rows; $i++) {
                                    $Result->data_seek($i);
                                    $row = $Result->fetch_array(MYSQLI_ASSOC);

                                    $NomServicio = $row["serv_nombre"];
                                    $Price = $row["serv_precioBase"];
                                    echo <<<_Init
                                        <tr>
                                            <td>
                                                <button type="button" class="col-md-12 list-group-item" name='$NomServicio' value='$Price'>$NomServicio
                                                    <div class="badge alert-success"> \$ $Price</div>
                                                </button>
                                            </td>
                                        </tr>
_Init;
                                }
                            echo "</table> ";
                        ?>


                        <!-- Modal general para cada servicio-->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel" >Modificar Servicio</h4>
                                    </div>
                                    <div id="coko" class="modal-body">
                                        <form action="ModificarServicio.php" method="POST">
                                            <table>
                                                <tr>
                                                     <td>Nombre:</td>
                                                     <td><input class="form-control" id="nombre" name="nombre" type="text"> </input></td>
                                                </tr>
                                                <tr>
                                                     <td>Precio:</td>
                                                     <td><input class="form-control" id="precio" name="precio" type="number"> </input></td>
                                                </tr>
                                                <tr>
                                                    <td>Estado</td>
                                                    <td>
                                                        <select name="" id="">
                                                            <option selected value="Activo">Activo
                                                            </option>
                                                            <option value="Inactivo"> Inactivo
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
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

<!-- jQuery -->
<script src="js/jquery.js"></script>
<script src="js/ModificarServicios.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>
