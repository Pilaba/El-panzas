<body>
    <div id="wrapper">
        <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");


        if(isset($_POST["Nom"])) {
            $Nombre = $_POST["Nom"];
            $PBase = $_POST["PBase"];
            $Link = ConectarseaBD();
            $Resultado = $Link->query("INSERT INTO servicio VALUES (NULL,'$Nombre','$PBase',1)");
            $Link->close();

            if ($Resultado == TRUE) {
                echo <<<_Exito
                    <form name="formExito" action="AgregarServicio.php" method="POST"> 
                        <input type="hidden" name="exito" value="TRUE">
                    </form>
                    
                    <script> 
                        document.forms['formExito'].submit();
                    </script>
_Exito;
            } else {
                echo <<<_Fallo
                    <form name="formFallo" action="AgregarServicio.php" method="POST"> 
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
                <div class="panel-heading">
                    <h2 class="panel-title"> Agregar Servicio </h2>
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

                <div class="panel-body">
                    <form class="navbar-form navbar-left" action="AgregarServicio.php" method="POST">
                        <table>
                            <tr>
                                <td>Nombre: </td>
                                <td><input class="form-control" type="text" name="Nom" required></td>
                            </tr>
                            <tr>
                                <td>Precio Base: </td>
                                <td><input class="form-control" type="number" name="PBase" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="btn btn-info" type="submit"> </input></td>
                            </tr>
                        </table>
                    </form>
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
