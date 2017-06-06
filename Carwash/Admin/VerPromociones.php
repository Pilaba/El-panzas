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
                        <form id="formEditaPromo" NAME="COCO" action="VerPromociones.php" method="POST">
                            <div class="panel-body">
                                <table id="tablita">
                                    <tr>
                                        <td>Nombre: </td>
                                        <td><input id="Nom" class="form-control" maxlength="30" type="text" name="Nom" required></td>
                                    </tr>
                                    <tr>
                                        <td>Fecha Creacion: </td>
                                        <td><input id="fecha" class="form-control"  type="datetime" name="fecha" required disabled></td>
                                    </tr>

                                    <tr>
                                        <td>Importe: </td>
                                        <td><input id="importe" class="form-control" min="1" type="number" name="importe" required disabled></td>
                                    </tr>

                                    <tr>
                                        <td>Descuento: </td>
                                        <td><input id="descuento" class="form-control" min="1" type="number" name="descuento" required  disabled></td>
                                    </tr>
                                    <tr>
                                        <td>Total: </td>
                                        <td><input id="total" class="form-control" min="1" type="number" name="total" required disabled ></td>
                                    </tr>
                                    <input name="idProm" id="idProm" type="hidden">
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
    if(isset($_POST["Nom"])){ //HACER DISPARADOR PARA CALCULAR TOTAL Y QUE SOLO SE MODIFIQUE EL PRECIO E IMPORTE
        $lenk=ConectarseaBD();
        //FALTA SANITIZARLAS
        $Nombre = $_POST["Nom"];
        $state= $_POST["state"];
        $idprom= $_POST["idProm"];
        $resultao=$lenk->query("UPDATE tipopaquete tp JOIN paquete p ON p.paq_tipo=tp.tp_idTipo SET tp.tp_nombre='$Nombre' WHERE P.paq_idPaquete=".$idprom );
        $lenk->query("UPDATE tipopaquete tp JOIN paquete p on p.paq_tipo=tp.tp_idTipo SET p.paq_Estado='$state' WHERE P.paq_idPaquete=".$idprom );
        $lenk->close();
    }
    ?>

    <div id="page-wrapper">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Ver Clientes </h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Fecha&nbsp;de&nbsp;Creacion</th>
                                <th>Importe</th>
                                <th>Descuento</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="body">
                            <?php
                            $Link=ConectarseaBD(); //Conexion a la BD
                            $Resultado= $Link->query("SELECT * FROM paquete P join tipopaquete TP on P.paq_tipo=TP.tp_idTipo WHERE P.paq_tipo!=1"); //Se realiza la consulta para obtener los usuarios clientes en el sistema
                            $Link->close(); //Se cierra la conexion a la BD

                            for($i=0; $i<$Resultado->num_rows; $i++){ //$Resultado->num_rows numero de filas obtenidas por la consulta
                                $Resultado->data_seek($i); //Puntero
                                $array=$Resultado->fetch_array(MYSQLI_ASSOC); //se obtiene un array associativo para cada fila
                                $Nombre=$array["tp_nombre"]; //Se obtienen los datos del array

                                $Estado =  ($array["paq_Estado"]==1) ? 'ACTIVA' : "INACTIVA";
                                $Fecha=$array["paq_fechaCreacion"];
                                $Importe=$array["paq_importe"];
                                $Descuento=$array["paq_descuento"];
                                $Total=$array["paq_Total"];
                                $promoId=$array["paq_idPaquete"];

                                if($Estado=='ACTIVA'){
                                    echo "<tr class='alert-success'>";
                                }else{
                                    echo "<tr class='alert-danger'>";
                                }


                                echo <<<_Etiqueta
                                                <td>$Nombre</td>
                                                <td>$Estado</td>
                                                <td>$Fecha</td>
                                                <td>$Importe</td>
                                                <td>$Descuento</td>
                                                <td>$Total</td>
                                                <td><button class="btn-group" value="$promoId" style="background-color:transparent;  border:none"> <a class="glyphicon glyphicon-edit"> editar </a></button></td>
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

<!-- CUSTOM SCRIPT -->
<script src="js/VerPromociones.js"></script>

<!-- plug-in para el toggle button -->
<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap-toggle.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>


</body>