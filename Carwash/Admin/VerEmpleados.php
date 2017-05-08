<body>
<div id="wrapper">
    <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");
    ?>


    <div id="page-wrapper">
        <div class="panel panel-info">
        <div class="panel panel-red">
            <div class="panel-heading">
            <i class="fa fa-user fa-3x"></i>
                <div class="panel-title"> Empleados</div>
            </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped"><!--Creamos la tabla-->
               
                    <thead><!--Creamos la fila de la tabla-->
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Genero</th>
                            <th>Telefono</th>
                            <th>Turno</th>
                            <th>Direccion</th>
                            <th>Salario</th>
                            <th>Estado</th>
                            <th>Fecha Ingreso</th>
                            <th>Roles</th>
                        </tr>
                    </thead>
                    <thbody>
                    <!--Hacemos conexion con la base de datos-->
                        <?php
                        $Link=ConectarseaBD();
                        $Resultado=$Link->query("SELECT * FROM empleado WHERE emp_estado=1");
                        $Link->close();

                        $filas=$Resultado->num_rows;

                        for ($i=0; $i<$filas; $i++){
                            $Resultado->data_seek($i);
                            $array=$Resultado->fetch_array(MYSQLI_ASSOC);

                            $idEmp = $array["emp_idEmpleado"];
                            $Nombre=$array["emp_nombre"];
                            $correo=$array["emp_correo"];
                            $genero=$array["emp_genero"];
                            $telefono=$array["emp_telefono"];
                            $turno=$array["emp_turno"];
                            $Direccion=$array["emp_direccion"];
                            $salario=$array["emp_salario"];
                            $estado=$array["emp_estado"];
                            $fechaIn=$array["emp_fechaIngreso"];
                            $rol=$array["emp_idRol"];

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
                                    <form action="EliminarEmpleado.php" method="POST">
                                    <input name="Id" type="hidden" value="$idEmp">
                                    <td><button style="background-color:transparent;border:none" type="submit"><a class="glyphicon glyphicon-trash"></a></button></td>
                                    </form>
                                    
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
