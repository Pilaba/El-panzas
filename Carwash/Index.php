<!DOCTYPE html>
<html lang="en">
<head>
    <title>Autolavado "El Panzas"</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="JS/jquery.min.js"></script>
    <script src="JS/bootstrap.min.js"></script>
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
                    <li><a href="#">Acerca</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <?php /* Se utilza para verificar si el usuario esta logueado y desplegar el menu correspondiente
                (Menu de opciones de perfil o menu de inicio de sesion)*/
                require_once ("AutenticarSesion.php");
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
<div class="container text-center">
    <h3>What We Do</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Current Project</p>
        </div>
        <div class="col-sm-4">
            <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
            <p>Project 2</p>
        </div>
        <div class="col-sm-4">
            <div class="well">
                <p>Some text..</p>
            </div>
            <div class="well">
                <p>Some text..</p>
            </div>
        </div>
    </div>
</div><br>

<!-- Pie de pagina -->
<div class="container">
    <h3 align="center">Visita Nuestra sucursal</h3>
    <div class="row">
        <iframe class="col-lg-12" src="http://maps.google.com.mx/maps?q=Autolavado+el+Pansas&amp;output=embed"
            height="350"
            frameborder="1"
            scrolling="no">
        </iframe>
    </div>
</div>

<div class="container">
    <div class="row">
        contacto: pilaba@live.com
    </div>

</div>

</body>
</html>















