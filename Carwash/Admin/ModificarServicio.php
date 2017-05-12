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
                            if(isset($_POST["nombre"])){    //Modificar servicio antes de que los cargue de nuevo
                                $con=ConectarseaBD();
                                $nom=$con->real_escape_string($_POST["nombre"]);
                                $precio=$con->real_escape_string($_POST["precio"]);
                                $estado=$con->real_escape_string($_POST["equisDe"]);
                                $idserv=$con->real_escape_string($_POST["idserv"]);

                                $result=$con->query("UPDATE servicio SET serv_nombre='$nom', serv_precioBase='$precio', serv_estado='$estado' WHERE serv_idServicio='$idserv'; ");

                                if($result){
                                    echo "Exito";
                                }else{
                                    echo "Fallo";
                                }
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
                                    $ID=$row["serv_idServicio"];
                                    $estate=$row["serv_estado"];

                                    echo <<<_Init
                                        <tr>
                                            <td>
                                                <button type="button" class="col-md-12 list-group-item" title="$ID$estate" name='$NomServicio' value='$Price'>$NomServicio
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
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <form id="subir" action="ModificarServicio.php" method="POST">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Nombre</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" id="nombre" name="nombre" type="text">
                                                            <input class="form-control" id="idserv" name="idserv" type="hidden">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Precio</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" id="precio" name="precio" type="number">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Estado</label>
                                                        <div class="col-md-9">
                                                            <select name="equisDe" id="equisDe" CLASS="alert-danger">
                                                                <option value="1">Activo</option>
                                                                <option value="0"> Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-sm-6" style="height: 150px;width: 200px">
                                                <img id="imgServ" src="" width="100%" height="100%" hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <button id="submitModif" type="submit" class="btn btn-primary">Save changes</button>
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
