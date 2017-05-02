
     |<body>
    <div id="wrapper">
        <?php
         /*SE UTILIZA EL REQUIRE_ONCE PARA TRAER TODA LA INFORMACION QUE SE ENCUENTRA EN LOS ARCHIVOS Menu.php y FuncionesPHP.php*/
        require_once ("Menu.php");
        require_once ("../FuncionesPHP.php");


        if(isset($_POST["Nom"])) {
            $Nombre = $_POST["Nom"];
            $Correo = $_POST["Correo"];
            $Genero = $_POST["Genero"];
            $Telefono = $_POST["Telefono"];
            $Turno = $_POST["Turno"];
            $Direccion = $_POST["Direccion"];
            $Salario = $_POST["Salario"];
            $Estado = $_POST["Estado"];
            $FechaIngreso = $_POST["FechaIngreso"];
            $IdRol = $_POST["IdRol"];

            /*$sql="INSERT INTO empleado VALUES (NULL,'$Nombre','$Correo','$Genero','$Telefono','$Turno','$Direccion','$Salario','$Estado','$FechaIngreso','$IdRol')";
            $Resultado=mysql_query($sql);*/
            
            /*HACEMOS CONEXION CON LA BASE DE DATOS*/
            $Link = ConectarseaBD();
            /*INSERTAMOS LOS DATOS DE LA TABLA EMPLEADOS A LA BASE DE DATOS*/
            $Resultado = $Link->query("INSERT INTO empleado VALUES ('','$Nombre','$Correo','$Genero','$Telefono','$Turno','$Direccion','$Salario','1','$FechaIngreso','$IdRol')");
            /*SERRAMOS LA VARIABLE LINK*/
            $Link->close();
            /*SE HACE UNA CONDICION */
            if ($Resultado == TRUE) {
                echo <<<_Exito
                    <form name="formExito" action="IngresarEmpleado.php" method="POST"> 
                        <input type="hidden" name="exito" value="TRUE">
                    </form>
                    
                    <script> 
                        document.forms['formExito'].submit();
                    </script>
_Exito;
            } else {
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
                 <i class="fa fa-user fa-3x"></i>
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
                    <form class="navbar-form navbar-left" action="IngresarEmpleado.php" method="POST">
                        <table><!--SE CREA LA TABLA-->
                            <tr>
                                <td>Nombre: </td>
                                <td><input class="form-control" type="text" name="Nom" required></td>
                            </tr>
                            <tr>
                                <td>Correo: </td>
                                <td><input class="form-control" type="text" name="Correo" required></td>
                            </tr>
                            
                            <tr>
                                <td>Telefono: </td>
                                <td><input class="form-control" type="text" name="Telefono" required></td>
                            </tr>
                            
                            <tr>
                                <td>Direccion: </td>
                                <td><input class="form-control" type="text" name="Direccion" required></td>
                            </tr>
                            <tr>
                                <td>Salario: </td>
                                <td><input class="form-control" type="text" name="Salario" required></td>
                            </tr>
                            <tr>
                                <td>Fecha_Ingreso: </td>
                                <td><input class="form-control" type="date" name="FechaIngreso" required></td>
                            </tr>
                            <tr>
                                <td>Id_Rol: </td>
                                <td><input class="form-control" type="text" name="IdRol" required></td>
                            </tr>
                            <tr>
                                <td>Genero:</td>
                                <td><input class="form-control" type="radio" name="Genero" value="h" >Masculino</td>
                                <td><input class="form-control" type="radio" name="Genero" value="m" >Femenino</td>
                            </tr>
                             <tr>
                                <td>Turno:</td>
                                <td><input class="form-control" type="radio" name="Turno" value="m" >Matutino</td>
                                <td><input class="form-control" type="radio" name="Turno" value="v" >Vespertino</td>
                            </tr>
                            
                            <tr>
                                <td></td>
                                <td><input class="btn btn-danger" type="submit"> </input></td>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>


</body>