<html>
<head>
    <title> Panel de administración </title>
</head>
<body>

<?php
@session_start();
if(!isset($_SESSION["Nombre"]) || $_SESSION["rol"]==2) {
    header("location: ../Index.php");
}

?>

<div id="wrapper">
    <?php
    require_once ("../FuncionesPHP.php");
    require_once ("Menu.php");
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-header"> Promociones </h3>
                </div>
            </div>
            <!-- Alerta de proposito general -->
            <?php
            //<!--Subir la imagen de la promocion-->
                if(isset($_POST["idPromo"]) && $_FILES["Archii"]){
                    $enlace  = ConectarseaBD();
                    $IdPromo = $enlace->real_escape_string($_POST["idPromo"]);
                    $NomPromo= $enlace->real_escape_string($_POST["NomPromo"]);

                    $type   = $_FILES['Archii']['type'];
                    $temp   = $_FILES['Archii']['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
                    $fpp    = fopen($temp, "rb");//abrimos el archivo con permiso de lectura
                    $datos  = fread($fpp, filesize($temp));//leemos el contenido del archivo

                    //Una vez leido el archivo se obtiene un string con caracteres especiales.
                    $datos = $enlace->real_escape_string($datos);//se escapan los caracteres especiales

                    $Resultado = $enlace->query("UPDATE paquete SET paq_Img='$datos', Paq_ImgMime='$type' WHERE paq_idPaquete='$IdPromo'");
                    if($Resultado){
                        echo "<div id='MensajeGeneral' class='alert alert-success alert-dismissible text-center' role='alert'>
                                <strong>¡Exito!, se ha creado la promoción $NomPromo</strong>
                             </div>";
                    }else{
                        echo "<div id='MensajeGeneral' class='alert alert-warning alert-dismissible text-center' role='alert'>
                                   <strong>¡Error Imagen no soportada!, intente modificarla en \"Ver Promociones\"</strong>
                              </div>";
                    }
                    $enlace->close();
                }
            ?>
        </div>
        <div class="row">
            <!-- AQUI SE DESPLEGARA INFORMACION DEL PEDIDO-->
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Promocion No: "<strong id="matr">
                            <?php
                                $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM paquete WHERE paq_tipo!=1");
                                $resuta->data_seek(0);
                                $resuta=$resuta->fetch_array(MYSQLI_NUM);
                                echo ($resuta[0]+1);
                            ?>
                        </strong>"
                    </div>
                    <div id="DetallePaquete" class="panel-body" style="min-height: 300px">
                        <table id="tablitaDetalles" class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- COLGAR AQUI LOS DETALLES UTILIZANDO JQUERY ;) -->
                            </tbody>
                        </table>
                    </div>
                    <div id="footer" class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                descuento
                            </div>
                            <div class="col-md-12">
                                <div id="spiner">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AQUI VA EL PANEL PARA ALMACENAR LOS SERVICIOS -->
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        PROMOCIÓN
                    </div>
                    <div id="paquete-container" title="¡Ingresa servicios!" class="panel-body" style="min-height: 300px">

                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" maxlength="30" id="nombrePromo" class="form-control" title="Ingresa el nombre de la promoción" placeholder="Nombre de la promoción" required>
                            </div>
                            <div class="col-md-12">
                                <input type="file" id="archivo" name="archivo" class="form-control" title="Ingresa una imagen" placeholder="Imagen de promo" required>
                            </div>
                            <div class="col-md-12">
                                <input type="button" id="botonPaquete" value="ENVIAR" class="btn btn-info btn-group-justified">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AQUI VA EL PANEL DE LOS SERVICIOS -->
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        SERVICIOS DISPONIBLES
                    </div>
                    <div id="panelBody" class="panel-body" style="min-height: 300px">
                        <ul id="gallery" class="list-group" >
                            <?php
                            $Mysqli=ConectarseaBD();
                            $resultado=$Mysqli->query("SELECT * FROM servicio WHERE serv_estado=1");

                            if($rows=$resultado->num_rows){
                                for ($i=0; $i<$rows; $i++){
                                    $resultado->data_seek($i);
                                    $array=$resultado->fetch_array(MYSQLI_ASSOC);
                                    $nombre=$array["serv_nombre"];
                                    $id=$array["serv_idServicio"];
                                    $precio=$array["serv_precioBase"];

                                    echo <<<_end
                                                <li class="list-group-item">
                                                    <img src="GetImage.php?id=$id" alt="$nombre - $precio" width="96" height="72">
                                                    <a href="#" class="glyphicon glyphicon-plus">Agregar $nombre</a>
                                                    <input class="nombre" value="$nombre" type="hidden">
                                                    <input class="id" value="$id" type="hidden">
                                                    <input class="precio" value="$precio" type="hidden">
                                                </li>
_end;
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="container"> <!-- Se coloca la imagen de la promocion-->

        </div>


        <form hidden action="AgregarPromociones.php" id="FormUpload" method="post" enctype="multipart/form-data">
            <input type="text" id="idPromo" name="idPromo" hidden>
            <input type="text" id="NomPromo" name="NomPromo" hidden>
            <input type="file" id="clone" name="Archii" hidden>
        </form>



    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>

</div>
<!-- /#wrapper -->
<!-- jQuery & jQuery UI CDN -->
<script src="js/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<style>
    input {display: block; padding: 0; margin: 0; border: 0; width: 100%}
    .ui-state-highlight {background: darkseagreen !important;}
    .custom-state-active {background: lightblue !important;}
</style>

<!-- Custom script -->
<script src="js/AgregarPromociones.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script src="js/plugins/morris/morris-data.js"></script>

</body>
</html>