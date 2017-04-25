<body>
<div id="wrapper">
    <?php
    require_once ("Menu.php");
    require_once  ("../FuncionesPHP.php");

    ?>


    <div id="page-wrapper">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Ver Clientes </h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                            </tr>
                            </thead>
                            <thbody>
                                <?php
                                    $Link=ConectarseaBD();
                                    $Resultado= $Link->query("SELECT * FROM usuario WHERE id_rolS=2");
                                    $Link->close();

                                    for($i=0; $i<$Resultado->num_rows; $i++){
                                        $Resultado->data_seek($i);
                                        $array=$Resultado->fetch_array(MYSQLI_ASSOC);
                                        $Nombre=$array["nombre"];
                                        $email=$array["correo"];
                                        $Tel=$array["Telefono"];
                                        echo <<<_Etiqueta
                                            <tr class="alert-success">
                                                <td>$Nombre</td>
                                                <td>$email</td>
                                                <td>$Tel</td>
                                            </tr>
_Etiqueta;
                                    }
                                ?>
                            </thbody>
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