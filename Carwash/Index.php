<!DOCTYPE html>
<html lang="es">
<head>
    <title>Autolavado "El Panzas"</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Boostrap and custom CSS -->
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <!-- Theme CSS -->
    <link href="CSS/creative.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/CssIndex.css">
</head>
<body>
<?php
require_once ("FuncionesPHP.php");
if(isset($_POST["nombre"])){
    @session_start();
    $link=ConectarseaBD();
    $nombre=$link->real_escape_string($_POST["nombre"]);
    $Correo=$link->real_escape_string($_POST["correo"]);
    $tel=$link->real_escape_string($_POST["telefono"]);
    $sessionID=$_SESSION["id"];

    $result=$link->query("UPDATE usuario 
                                SET usu_nombre='$nombre', usu_correo='$Correo', usu_telefono='$tel' 
                                WHERE usu_idUsuario='$sessionID' ");
    if($result){
        $_SESSION["Nombre"]=$nombre; //Se actualiza la sesion actual
    }
    require_once ("FuncionesPHP.php");
}
?>
<!-------------------------------------------- MENU SUPERIOR--------------------------------------------------->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Index.php"><img src="Images/LOGO.jpg" height="35" width="80"></a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#header">Inicio</a></li>
                    <li><a id="help" href="#promos">Promociones</a></li>
                    <li><a id="services" href="#servicios">Servicios</a></li>
                    <li><a id="help" href="#sucursal">Sucursal</a></li>
                    <li><a id="help" href="#nosotros">Nosotros</a></li>
                    <li><a id="contact" href="#contacto">Contacto</a></li>
                </ul>
            </div>
            <?php /* Se utilza para verificar si el usuario esta logueado y desplegar el menu correspondiente
                (Menu de opciones de perfil o menu de inicio de sesion)*/
                MenuUsuario(); //Desde FuncionePHP
            ?>
        </div>
    </div>
</nav>
<div class="container" style="height: 50px">
</div>

<header id="header" class="well">
    <div class="header-content">
        <div class="header-content-inner">
            <br> <br> <br> <br><br> <br><br>
            <p style="color: #f85933; font-size: 30px">Autolavado <span style="background-color: #0f0f0f">"EL PANZAS"</span> <br> Atendido por sus propietarios Chuy y Caro
            <a href="#promos" class="btn btn-primary btn-xl page-scroll">Observa nuestras promociones</a>
            </p>
        </div>
    </div>
</header>

<!--------------------------------------------------------- Carrusel --------------------------------------------------------------->
<div id="promos" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#promos" data-slide-to="0" class="active"></li>
        <li data-target="#promos" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" style="height: 100%; width: 100%" role="listbox">
        <?php
        $link=ConectarseaBD();
        $result=$link->query("SELECT * FROM paquete P JOIN tipopaquete TP ON P.paq_tipo=TP.tp_idTipo WHERE (paq_tipo!=1 AND paq_Estado=1)");
        $bandera=true;
        for($i=0; $i<$result->num_rows; $i++){
            $result->data_seek($i);
            $array=$result->fetch_array(MYSQLI_ASSOC);
            $nombre=$array["tp_nombre"];
            $id=$array["paq_idPaquete"];
            $PB=$array["paq_importe"];
            $total=$array["paq_Total"];

            if($bandera){
                echo "<div class='item active'>";
                $bandera=false;
            }else{
                echo "<div class='item'>";
            }
            echo "<img class='img-rounded' src='GetPromotionImage.php?numProm=$id' height='100%' width='100%'> 
                    <div class='carousel-caption'>
                        <h1 style='color: black'><b>$nombre</b></h1>
                        <p style='color: black; font-size: 200%'> <em style='text-decoration:line-through'>&#36;$PB</em> <b style='font-size: 180%'>&#36;$total</b> </p>
                    </div>
                 </div>";
        }
        $link->close();
        ?>
    </div>

    <style>
        .item {
            display: block;
            width: 100%;
            height: 450px;
        }
        .item img {
            height: 150px;
            width: 100%;
        }
    </style>

    <!-- Controles Izquierda y derecha -->
    <a class="left carousel-control" href="#promos" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#promos" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>

<!-- FONDO INFERIOR -->
<div class="Fondonaranja">
<br>
<div class="well well-sm alert-info" id="servicios">
    <div>
        <div class="container">
            <h3>Nuestros Servicios</h3>
            <div class="row">
                <?php
                require_once ("FuncionesPHP.php");
                $link=ConectarseaBD();
                $result=$link->query("SELECT * FROM servicio WHERE serv_estado=1");

                for($i=0; $i<$result->num_rows; $i++){
                    $result->data_seek($i);
                    $array=$result->fetch_array(MYSQLI_ASSOC);
                    $nombre=$array["serv_nombre"];
                    $id=$array["serv_idServicio"];
                    $PB=$array["serv_precioBase"];

                    echo "<div class='col-md-3 well' style='height:100%'>
                    <img class='img-rounded' src='Admin/GetImage.php?id=$id' height='150px' width='100%'> 
                        <div class='alert-success'>
                             <strong class='form-group form-inline'>$nombre  &nbsp;</strong>
                             <strong class='form-group form-inline'> $ $PB </strong>
                        </div>
                    </img>
                  </div>
                 ";
                }
                $link->close();
                ?>
            </div>
        </div>
    </div>
</div>


<!-- Sucursal -->
<div id="sucursal" class="well alert-info">
    <div class="container">
        <h3>Nuestra sucursal</h3>
        <div class="row">
            <iframe class="col-lg-12" src="http://maps.google.com.mx/maps?q=Autolavado+el+Pansas&amp;output=embed"
                    height="350"
                    frameborder="1"
                    scrolling="no">
            </iframe>
        </div>
    </div>
</div>

<!-- Nosotros -->
<div id="nosotros" class="well alert-info">
    <div class="container">
        <h3>Acerca de nosotros</h3>
        <div class="row well alert-danger">
            <p>
                Somos un servicio de autolavado ubicado en el estado de colima
                manejamos los precios mas bajos a comparacion de la diosa del agua :)
            </p>
            <em>
                "Lavar coches esta bien chido" - CEO doña Caro
            </em>
        </div>
    </div>
</div>

<!--Pie de pagina-->
<footer id="contacto" class="footer" style="padding: 60px 0 20px; background: #0e0f11; color: #bcbecc;">
    <div class="container text-center">
        <div>
            <strong> panzasautolavado@gmail.com</strong> <br>
            2017 Autolavado El Panzas. Todos los derechos reservados  <hr>
            Desarrollado por <a>Alumnos Ing. Informática, colima méxico</a>
        </div>
    </div>
</footer>
</div>

<!------------------------- MODAL DE PROPOSITO GENERAL ------------------->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body">
                <div id="Panel" class="panel panel-info">
                    <div class="panel-heading" id="title">

                    </div>
                    <div id="PanelBody" class="panel-body">
                        <!-- Colgar datos aqui-->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="Cambios" type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


<!-- Jquery Library Y boostrap Script library-->
<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
<script src="JS/Modales.js"> </script>

</body>
</html>















