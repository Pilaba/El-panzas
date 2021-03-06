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
                            <tbody>
                                <?php
                                    $Link=ConectarseaBD(); //Conexion a la BD
                                    $Resultado= $Link->query("SELECT * FROM usuario WHERE usu_idRol=2"); //Se realiza la consulta para obtener los usuarios clientes en el sistema
                                    $Link->close(); //Se cierra la conexion a la BD


                                    for($i=0; $i<$Resultado->num_rows; $i++){ //$Resultado->num_rows numero de filas obtenidas por la consulta
                                        $Resultado->data_seek($i); //Puntero
                                        $array=$Resultado->fetch_array(MYSQLI_ASSOC); //se obtiene un array associativo para cada fila
                                        $Nombre=$array["usu_nombre"]; //Se obtienen los datos del array
                                        $email=$array["usu_correo"];
                                        $Tel=$array["usu_telefono"];
                                        echo <<<_Etiqueta
                                            <tr class="alert-success">
                                                <td>$Nombre</td>
                                                <td>$email</td>
                                                <td>$Tel</td>
                                            </tr>
_Etiqueta;
                                    }
                                ?>
                            </tbody>
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