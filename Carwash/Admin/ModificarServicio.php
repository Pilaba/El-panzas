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
                <!-- Alerta de proposito general -->
                <div id='MensajeGeneral' class='alert alert-success text-center' role='alert' style="display: none">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="contenidoMensaje">...</strong>
                </div>

                <div class="col-md-3">
                    <div class="list-group">
                        <?php
                            if(isset($_POST["nombre"])) {    //Modificar servicio antes de que los cargue de nuevo
                                $con = ConectarseaBD();
                                $nom = $con->real_escape_string($_POST["nombre"]);
                                $precio = $con->real_escape_string($_POST["precio"]);
                                $estado = $_POST["state"];
                                $idserv = $con->real_escape_string($_POST["idserv"]);

                                switch ($_FILES["archivito"]["error"]){
                                    case 0: //Se quiere cambiar de imagen
                                        $size = $_FILES['archivito']['size'];
                                        if(! ($size > 0 && $size <= 948000)){ //Una ultima comprobacion a la imagen
                                            echo "<script> //Imagen muy grande
                                                    document.getElementById('MensajeGeneral').className = 'alert alert-danger text-center';
                                                    document.getElementById('MensajeGeneral').style.display = 'block';
                                                    document.getElementById('contenidoMensaje').innerHTML='¡Error, La imagen no cumple los requisitos minimos!'
                                                 </script>";
                                            break;
                                        }
                                        $tipo = $_FILES['archivito']['type'];
                                        $temName = $_FILES['archivito']['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
                                        $fp = fopen($temName, "rb");//abrimos el archivo con permiso de lectura
                                        $data = fread($fp, filesize($temName));//leemos el contenido del archivo
                                        //Una vez leido el archivo se obtiene un string con caracteres especiales.
                                        $data = $con->real_escape_string($data);//se escapan los caracteres especiales
                                        fclose($fp);//Cerramos el archivo
                                        $result = $con->query("UPDATE servicio SET serv_nombre='$nom', serv_precioBase='$precio', serv_estado='$estado',serv_imagen='$data',serv_mime='$tipo' WHERE serv_idServicio='$idserv'");
                                        if ($result) {
                                            echo "<script> //Exito modificando con Imagen
                                                    document.getElementById('MensajeGeneral').style.display = 'block';
                                                    document.getElementById('contenidoMensaje').innerHTML='¡Se han guardado las modificaciones!'
                                                  </script>";
                                        } else {
                                            echo "<script> //fallo modificacion con imagen, ya existe un servicio con tal nombre 
                                                    document.getElementById('MensajeGeneral').className = 'alert alert-danger text-center';
                                                    document.getElementById('MensajeGeneral').style.display = 'block';
                                                    document.getElementById('contenidoMensaje').innerHTML='¡Error ya existe un servicio con ese nombre!'
                                                  </script>";
                                        }
                                        break;
                                    case 1: //Error Imagen muy grande
                                        echo "<script> //Imagen muy grande
                                                    document.getElementById('MensajeGeneral').className = 'alert alert-danger text-center';
                                                    document.getElementById('MensajeGeneral').style.display = 'block';
                                                    document.getElementById('contenidoMensaje').innerHTML='¡Error, Imagen demasiado pesada. Intente con otra!'
                                            </script>";
                                        break;
                                    default: //4 No se selecciono imagen
                                        $result = $con->query("UPDATE servicio SET serv_nombre='$nom', serv_precioBase='$precio', serv_estado='$estado' WHERE serv_idServicio='$idserv' ");
                                        if ($result) {
                                            echo "<script> //Exito modificando sin imagen
                                                    document.getElementById('MensajeGeneral').style.display = 'block';
                                                    document.getElementById('contenidoMensaje').innerHTML='¡Se han guardado las modificaciones!'
                                                  </script>";
                                        } else {
                                            echo "<script> //fallo modificacion ya existe el nombre del servicio e la BD , 
                                                    document.getElementById('MensajeGeneral').className = 'alert alert-danger text-center';
                                                    document.getElementById('MensajeGeneral').style.display = 'block';
                                                    document.getElementById('contenidoMensaje').innerHTML='¡Error ya existe un servicio con ese nombre!'
                                                  </script>";
                                        }
                                        break;
                                }
                                $con->close();
                            }

                            //DESPUES QUE SE MODIFICARON LAS IMAGENES SE CARGAN A LA TABLA
                            $link = ConectarseaBD(); //CARGA LOS SERVICIOS DE LA BD
                            $Result = $link->query("SELECT * FROM servicio ");
                            $link->close();

                            echo "<table id='Tablita' class='table'> ";
                                for($i=0; $i<$Result->num_rows; $i++) {
                                    $Result->data_seek($i);
                                    $row = $Result->fetch_array(MYSQLI_ASSOC);

                                    $NomServicio = $row["serv_nombre"];
                                    $Price = $row["serv_precioBase"];
                                    $ID = $row["serv_idServicio"];
                                    $estate = $row["serv_estado"];

                                    if ($estate == 0){// Color Rojo si el estado es inactivo
                                        echo "<tr>
                                                  <td>
                                                     <button type='button' class='col-md-12 list-group-item alert-danger' title='$ID$estate' name='$NomServicio' value='$Price'>$NomServicio
                                                        <div class='badge alert-success'> \$ $Price</div>
                                                     </button>
                                                  </td>
                                              </tr>";
                                    }else{ //Color verde si el estado esta activo
                                        echo "<tr>
                                                  <td>
                                                     <button type='button' class='col-md-12 list-group-item alert-success' title='$ID$estate' name='$NomServicio' value='$Price'>$NomServicio
                                                        <div class='badge alert-success'> \$ $Price</div>
                                                     </button>
                                                  </td>
                                              </tr>";
                                    }
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
                                            <div class="col-md-6">
                                                <form enctype="multipart/form-data" id="subir" action="ModificarServicio.php" method="POST">

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Nombre</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" maxlength="30" id="nombre" name="nombre" type="text">
                                                            <input class="form-control" id="idserv" name="idserv" type="hidden">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Precio</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" min="0" max="999" id="precio" name="precio" type="number">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Imagen</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" type="file" name="archivito" id="archivoI" style="color: transparent">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Estado</label>
                                                        <div class="col-md-9">
                                                            <input id="toggle" type="checkbox" data-toggle="toggle"
                                                                   data-on="Activo" data-off="Inactivo"
                                                                   data-onstyle="success" data-offstyle="danger"
                                                                   data-width="100">
                                                            <input id="state" name="state" type="hidden"> <!-- almacena el valor del toggle -->
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
                                        <button id="submitModif" type="submit" class="btn btn-primary">Guardar Cambios</button>
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

<!-- plug-in para el toggle button -->
<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap-toggle.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>
