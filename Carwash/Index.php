<!DOCTYPE html>
<html lang="es">
<head>
    <title>Autolavado "El Panzas"</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/CssIndex.css">
</head>
<body>

<!-------------------------------------------- MENU SUPERIOR--------------------------------------------------->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Inicio</a></li>

                    <li><a href="#" data-toggle="modal" data-target="#myModal"> ayuda</a> </li>
                    <!-- Modal para ayuda -->

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <?php /* Se utilza para verificar si el usuario esta logueado y desplegar el menu correspondiente
                (Menu de opciones de perfil o menu de inicio de sesion)*/
                require_once ("FuncionesPHP.php");
                MenuUsuario();
            ?>
        </div>
    </div>
</nav>

<!--------------------------------------------------------- Carrusel --------------------------------------------------------------->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="https://placehold.it/1200x400?text=IMAGE" alt="Image">
            <div class="carousel-caption">
                <h3>Sell $</h3>
                <p>Money Money.</p>
            </div>
        </div>

        <div class="item">
            <img src="https://placehold.it/1200x400?text=Another Image Maybe" alt="Image">
            <div class="carousel-caption">
                <h3>More Sell $</h3>
                <p>Lorem ipsum...</p>
            </div>
        </div>
    </div>

    <!-- Controles Izquierda y derecha -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-------------------------------------------------------- Imagenes inferiores ------------------------------------------------>
<div class="container text-center" ">
    <h3>Nuestros Servicios</h3><br>
    <div class="row" >

        <?php
        require_once ("FuncionesPHP.php");
        $link=ConectarseaBD();
        $result=$link->query("SELECT * FROM servicio WHERE serv_estado='1'");

        for($i=0; $i<$result->num_rows; $i++){
            $result->data_seek($i);
            $array=$result->fetch_array(MYSQLI_ASSOC);
            $nombre=$array["serv_nombre"];
            $id=$array["serv_idServicio"];
            $PB=$array["serv_precioBase"];

            echo "<div class='col-md-3 well' style='height:100%'>
                    <img class='img-rounded' src='Admin/GetImage.php?id=$id' height='150px' width='100%'> 
                        <div class='alert-success'>
                            <strong class='col-md-2'>$nombre </strong>
                            <strong class='col-md-offset-7 col-md-3'> $ $PB </strong>
                        </div>
                    </img>
                  </div>
                 ";
        }
        ?>
    </div>
</div>

<!-- REGLA CSS PARA EFECTO BLANCO Y NEGRO DE IMAGEN-->
<style>
    img.img-rounded {
        filter: gray; /* IE6-9 */
        -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
        -webkit-box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
        box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.75);
        margin-bottom:20px;
    }

    img:hover {
        filter: none; /* IE6-9 */
        -webkit-filter: grayscale(0); /* Google Chrome, Safari 6+ & Opera 15+ */
    }
</style>


<!-- Pie de pagina -->
<div class="container">
    <h1 class="label label-info">Visita Nuestra sucursal</h1>
    <div class="row ">
        <iframe class="col-lg-12" src="http://maps.google.com.mx/maps?q=Autolavado+el+Pansas&amp;output=embed"
            height="350"
            frameborder="1"
            scrolling="no">
        </iframe>
    </div>
</div>

<div class="container">
    <div class="row" align="right">
        <addres>
            <strong>contacto: pilaba@live.com</strong>
        </addres>
    </div>
</div>


<script src="JS/jquery.min.js"></script>
<script src="JS/bootstrap.min.js"></script>
</body>
</html>















