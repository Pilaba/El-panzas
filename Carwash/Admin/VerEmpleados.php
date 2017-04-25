<body>
<div id="wrapper">
    <?php
    require_once ("Menu.php");
    require_once  ("../FuncionesPHP.php");

    ?>


    <div id="page-wrapper">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title"> Ver Empleados</div>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Genero</th>
                            <th>Telefono</th>
                            <th>Turno</th>
                            <th>Direccion</th>
                            <th>Salio</th>
                            <th>Estado</th>
                            <th>Fecha Ingreso</th>
                            <th>Roles</th>
                        </tr>
                    </thead>
                    <thbody>
                        <?php
                        $Link=ConectarseaBD();
                        $Resultado=$Link->query("SELECT * FROM empleado");
                        $Link->close();

                        $filas=$Resultado->num_rows;

                        for ($i=0; $i<$filas; $i++){
                            $Resultado->data_seek($i);
                            $array=$Resultado->fetch_array(MYSQLI_ASSOC);

                            $Nombre=$array["nombreE"];
                            $correo=$array["Correo"];
                            $genero=$array["Genero"];
                            $telefono=$array["Telefono"];
                            $turno=$array["Turno"];
                            $Direccion=$array["direccion"];
                            $salario=$array["salario"];
                            $estado=$array["estado"];
                            $fechaIn=$array["FechaIngreso"];
                            $rol=$array["id_rol"];

                            echo <<<eti
                                <tr class="alert-success">
                                    <td> $Nombre </td>
                                    <td>  $correo</td>
                                    <td>  $genero</td>
                                    <td>  $telefono</td>
                                    <td>  $turno</td>
                                    <td>  $Direccion</td>
                                    <td>  $salario</td>
                                    <td>  $estado</td> 
                                    <td>  $fechaIn</td>
                                    <td> $rol</td>
                                </tr>  
eti;
                        }
                        ?>
                    </thbody>
                </table>
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
