
    <body>
    <div id="wrapper">
        <?php
        require_once ("Menu.php");
        require_once ("../FuncionesPHP.php");

        if(isset($_POST["Nom"])) {
            $Nombre = $_POST["Nom"];
            $Correo = $_POST["Correo"];
            $Telefono = $_POST["Telefono"];
            $Direccion = $_POST["Direccion"];
            $Salario = $_POST["Salario"];
            $FechaIngreso = $_POST["FechaIngreso"];
            $Genero = $_POST["Genero"];
            $Turno = $_POST["Turno"];

            $Link = ConectarseaBD();
            $Resultado = $Link->query("INSERT INTO empleado VALUES ('','$Nombre','$Correo','$Genero','$Telefono','$Turno','$Direccion','$Salario',1,'$FechaIngreso')");

            //se toma el ultimo empleado que se a insertado
            $res = $Link->query("SELECT MAX(emp_idEmpleado) from empleado");
            if( $Resultado && $res){
                $res->data_seek(0);
                $array=$res->fetch_array(MYSQLI_NUM);
                $idEmpleado = $array[0];
                foreach ($_POST["roles"] as $rol){ //Se llena el detalle empleado_rolempleado
                    $InserionRoles=$Link->query("INSERT INTO empleado_rolempleado VALUES ('$idEmpleado','$rol')");
                }
            }

            $Link->close();

            if ($Resultado && $res) {
                echo <<<_Exito
                    <form name="formExito" action="IngresarEmpleado.php" method="POST"> 
                        <input type="hidden" name="exito" value="TRUE">
                    </form>
                    
                    <script> 
                        document.forms['formExito'].submit();
                    </script>
_Exito;
            }else{
                echo <<<_Fallo
                    <form name="formFallo" action="IngresarEmpleado.php" method="POST"> 
                        <input type="hidden" name="fallo" value="TRUE">
                    </form>
                    
                    <script> 
                        document.forms['formFallo'].submit();
                    </script>
_Fallo;
            }
        }
        ?>


        <div id="page-wrapper">
            <div class="panel panel-info">
            <div class="panel panel-red">
                <div class=" panel-heading">
                     <i class="fa fa-user fa-2x"></i>
                     <h4 class="panel-title">Empleado</h4>
                </div>
            </div>
                <?php
                if(isset($_POST["fallo"])){
                    echo "<div class='alert alert-danger text-center' role='alert'>
                              Inserción Fallida!
                          </div>";
                }else if(isset($_POST["exito"])){
                    echo "<div class='alert alert-success text-center' role='alert'>
                              Exito!
                         </div>";
                }
                ?>

                <!--SE CREA EL FORMULARIO-->
                <div class="panel-body">
                    <form id="formulario" class="navbar-form navbar-left" action="IngresarEmpleado.php" method="POST">
                        <table><!--SE CREA LA TABLA-->
                            <tr>
                                <td>Nombre: </td>
                                <td><input class="form-control" maxlength="30" type="text" name="Nom" required></td>
                            </tr>
                            <tr>
                                <td>Correo: </td>
                                <td><input class="form-control"  maxlength="30" type="email" name="Correo" required></td>
                            </tr>

                            <tr>
                                <td>Telefono: </td>
                                <td><input class="form-control" onKeyPress='if(this.value.length==10) return false;' min='0'  type="number" name="Telefono" required></td>
                            </tr>

                            <tr>
                                <td>Direccion: </td>
                                <td><input class="form-control" maxlength="50" type="text" name="Direccion" required></td>
                            </tr>
                            <tr>
                                <td>Salario: </td>
                                <td><input class="form-control" min="1" type="number" name="Salario" required></td>
                            </tr>
                            <tr>
                                <td>Fecha_Ingreso: </td>
                                <td><input class="form-control" type="date" name="FechaIngreso" required></td>
                            </tr>
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
                                            echo "<label class='pibe'> <input type='checkbox' name='roles[]' value='$idrol'> $nombre &nbsp; </label> ";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Genero:</td>
                                <td>
                                    <label><input class="form-control" type="radio" name="Genero" value="h" required>Masculino  &nbsp;</label>
                                    <label><input class="form-control" type="radio" name="Genero" value="m">Femenino </label>
                                </td>
                            </tr>
                            <tr>
                                <td>Turno:</td>
                                <td>
                                    <label><input class="form-control" type="radio" name="Turno" value="m" required>Matutino  &nbsp; &nbsp;</label>
                                    <label><input class="form-control" type="radio" name="Turno" value="v">Vespertino  &nbsp; </label>
                                    <label><input class="form-control" type="radio" name="Turno" value="d">Diurno </label>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td><input class="btn btn-danger" id="subirForm" type="submit" value="ACEPTAR"> </input></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <!--/.container-fluid--> 
        </div>
        <!-- /#page-wrapper -->

    </div>

    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script>
        $("#subirForm").click(function () {
          if($("#roles td label.pibe input").is(":checked")){
              $("#roles td label.pibe input").attr("required",false)
          }else{
              $("#roles td label.pibe input").attr("required",true)
              alert("Falta ingresar roles")
          }
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>


</body>