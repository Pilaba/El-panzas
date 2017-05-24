<body>
<div id="wrapper">
    <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");
    ?>


    <!-- modal de proposito general-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header alert-success">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">...</h4>
                </div>
                <div class="modal-body">
                    <div class="panel panel-info">
                        <form id="formEditarEmpleado" NAME="COCO" action="VerEmpleados.php" method="POST">
                            <div class="panel-body">
                            <table id="tablita">

                                <tr>
                                    <td>Nombre: </td>
                                    <td><input id="Nom" class="form-control" maxlength="30" type="text" name="Nom" required></td>
                                </tr>
                                <tr>
                                    <td>Correo: </td>
                                    <td><input id="Correo" class="form-control"  maxlength="30" type="email" name="Correo" required></td>
                                </tr>

                                <tr>
                                    <td>Telefono: </td>
                                    <td><input id="Telefono" class="form-control" onKeyPress='if(this.value.length==10) return false;' min='0'  type="number" name="Telefono" required></td>
                                </tr>

                                <tr>
                                    <td>Direccion: </td>
                                    <td><input id="Direccion" class="form-control" maxlength="50" type="text" name="Direccion" required></td>
                                </tr>
                                <tr>
                                    <td>Salario: </td>
                                    <td><input id="Salario" class="form-control" min="1" type="number" name="Salario" required></td>
                                </tr>
                                <tr>
                                    <td>Fecha_Ingreso: </td>
                                    <td><input id="FechaIngreso" class="form-control" type="date" name="FechaIngreso" required></td>
                                </tr>
                                <input name="idEmp" id="idEmp" type="hidden">
                                <tr id="roles">
                                    <td>Roles:</td>
                                    <td>
                                        <?php
                                        $link=ConectarseaBD();
                                        $result=$link->query("SELECT * FROM rolempleado");
                                        for($i=0; $i<$result->num_rows; $i++){
                                            $result->data_seek($i);
                                            $arr=$result->fetch_array(MYSQLI_ASSOC);
                                            $idrol  = $arr["re_idRol"];
                                            $nombre = $arr["re_nombre"];
                                            echo "<label> <input class='pibe' type='checkbox' name='roles[]' value='$idrol'> $nombre &nbsp; </label> ";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td >Genero:</td>
                                    <td>
                                        <label><input class="gen" type="radio" name="Genero" value="h">Masculino&nbsp;</label>
                                        <label><input class="gen" type="radio" name="Genero" value="m">Femenino</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Turno:</td>
                                    <td>
                                        <label><input class="turn" type="radio" name="Turno" value="m"required>Matutino  &nbsp; &nbsp;</label>
                                        <label><input class="turn" type="radio" name="Turno" value="v">Vespertino  &nbsp; </label>
                                        <label><input class="turn" type="radio" name="Turno" value="d">Diurno </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <label>
                                            <input id="toggle" type="checkbox" data-toggle="toggle"
                                            data-on="Activo" data-off="Inactivo"
                                            data-onstyle="success" data-offstyle="danger"
                                            data-width="100">
                                        </label>
                                        <input id="state" name="state" type="hidden"> <!-- almacena el valor del toggle -->
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="submitModif" type="submit" form="COCO" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST["Nom"])){
            $lenk=ConectarseaBD();
            //FALTA SANITIZARLAS
            $Nombre = $_POST["Nom"];
            $Correo = $_POST["Correo"];
            $Telefono = $_POST["Telefono"];
            $Direccion = $_POST["Direccion"];
            $Salario = $_POST["Salario"];
            $FechaIngreso = $_POST["FechaIngreso"];
            $Genero = $_POST["Genero"];
            $state= $_POST["state"];
            $Turnoo = $_POST["Turno"];
            $idEmp= $_POST["idEmp"];

            $resultao=$lenk->query("UPDATE empleado SET emp_nombre = '$Nombre', emp_correo = '$Correo', emp_genero = '$Genero', emp_telefono = '$Telefono',
             emp_turno = '$Turnoo', emp_direccion = '$Direccion', emp_salario = '$Salario', emp_estado = '$state', 
             emp_fechaIngreso = '$FechaIngreso'
             WHERE emp_idEmpleado =".$idEmp);

            $delete=$lenk->query("DELETE FROM empleado_rolempleado 
                                        WHERE ER_idEmpleado =".$idEmp);
            $InserionRoles="";
            if($resultao && $delete){
                foreach ($_POST["roles"] as $rol){ //Se llena el detalle empleado_rolempleado
                    $InserionRoles=$lenk->query("INSERT INTO empleado_rolempleado VALUES ($idEmp, $rol)");
                }
            }
            $lenk->close();
        }
    ?>
    <div id="page-wrapper">
        <div class="panel panel-red">
            <div class="panel-heading">
                <i class="fa fa-user fa-3x"></i>
                <div class="panel-title"> Empleados</div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-responsive"><!--Creamos la tabla-->
                    <thead> <!--Creamos la fila de la tabla-->
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="body">
                    <!--Hacemos conexion con la base de datos-->
                        <?php
                        $Link=ConectarseaBD();
                        $Resultado=$Link->query("SELECT * FROM empleado");

                        for ($i=0; $i<$Resultado->num_rows; $i++){
                            $Resultado->data_seek($i);
                            $array=$Resultado->fetch_array(MYSQLI_ASSOC);

                            $idEmp    = $array["emp_idEmpleado"];
                            $Nombre   = $array["emp_nombre"];
                            $correo   = $array["emp_correo"];
                            $genero   = ($array["emp_genero"]=="h") ? "Hombre": 'Mujer';
                            $telefono = $array["emp_telefono"];
                            $turno="";
                            switch ($array["emp_turno"]){
                                case "m": $turno="Matutino";
                                    break;
                                case "v": $turno="Vespertino";
                                    break;
                                case "d": $turno="Diurno";
                                    break;
                            }
                            $Direccion= $array["emp_direccion"];
                            $salario  = $array["emp_salario"];
                            $estado   = ($array["emp_estado"]==1) ? "Activo": "Inactivo";
                            $fechaIn  = $array["emp_fechaIngreso"];
                            $Array=Array();

                            $res=$Link->query("SELECT re.re_nombre
                                                      FROM empleado_rolempleado ER JOIN rolempleado re on ER.ER_idRol=re.re_idRol
                                                      WHERE ER.ER_idEmpleado='$idEmp'");

                            for($j=0; $j<$res->num_rows; $j++){
                                $res->data_seek($j);
                                $arr=$res->fetch_array(MYSQLI_ASSOC);
                                $Array[$j]=$arr["re_nombre"];
                            }
                            $roles=implode(", ", $Array);

                            if($estado=="Activo"){
                                echo "<tr class='alert-succesS'>";
                            }else{
                                echo "<tr class='alert-danger'>";
                            }
                            echo <<<eti
                                    <td>  $Nombre </td>
                                    <td>  $correo </td>
                                    <td>  $genero </td>
                                    <td>  $telefono </td>
                                    <td>  $turno </td>
                                    <td>  $Direccion </td>
                                    <td>  $salario </td>
                                    <td>  $estado </td> 
                                    <td>  $fechaIn </td>
                                    <td>  $roles </td>
                                    <td><button class="btn-group" value="'$idEmp'" style="background-color:transparent;  border:none"> <a class="glyphicon glyphicon-edit"> editar </a></button></td>
                                </tr>  
eti;
                        }
                        $Link->close();
                        ?>
                    </tbody>
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
<!-- Custom script -->
<script src="js/VerEmpleados.js"></script>

<!-- plug-in para el toggle button -->
<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap-toggle.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>
