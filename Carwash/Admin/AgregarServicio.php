<body>
<div id="wrapper">
    <?php
    require_once ("Menu.php");
    require_once  ("../FuncionesPHP.php");
    if(isset($_POST["Nom"]) && isset($_FILES["archivo"])) {
        $Link = ConectarseaBD(); //Conexion a BD
        $Nombre = $_POST["Nom"];
        $PBase = $_POST["PBase"];

        $size=$_FILES['archivo']['size'];
        echo $size;
        if( ! ($size > 0 && $size <= 950000) ){
            echo <<<_Fallo
                    <form name="formFallo" action="AgregarServicio.php" method="POST"> 
                        <input type="hidden" name="problemaImagen" value="TRUE">
                    </form>
                    
                    <script> 
                        document.forms['formFallo'].submit();
                    </script>
_Fallo;
        }else{
            $temName = $_FILES['archivo']['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
            $fp = fopen($temName, "rb");//abrimos el archivo con permiso de lectura

            $data = fread($fp, filesize($temName));//leemos el contenido del archivo
            //Una vez leido el archivo se obtiene un string con caracteres especiales.
            $data = $Link->real_escape_string($data);//se escapan los caracteres especiales
            fclose($fp);//Cerramos el archivo
            ob_clean();
            $Resultado = $Link->query("INSERT INTO servicio VALUES (NULL,'$Nombre','$PBase',1,'$data')");
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
                              Inserción Fallida!, Nombre de servicio ya existente 
                      </div>";
            }else if(isset($_POST["exito"])){
                echo "<div class='alert alert-success text-center' role='alert'>
                              Exito!, Se agrego el nuevo servicio.
                      </div>";
            }else if(isset($_POST["problemaImagen"])){
                echo "<div class='alert alert-danger text-center' role='alert'>
                              Error, Imagen demasiado grande!
                      </div>";
            }
            ?>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" class="form-horizontal" role="form" action="AgregarServicio.php" method="POST">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nombre</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="text" name="Nom" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Precio</label>
                                <div class="col-md-9">
                                    <input class="form-control" type="number" name="PBase" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Precio</label>
                                <div class="col-md-9">
                                    <input class="form-control oculto" type="file" name="archivo" id="archivo" style="color: transparent" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <input class="btn btn-info" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div CLASS="col-md-7" style="width: 400px; height: 200px">
                        <img id="imgSalida" width="100%" height="100%" src="" hidden>
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
<script src="js/AgregarServicio.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>