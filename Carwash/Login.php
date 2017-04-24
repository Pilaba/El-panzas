<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesion</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="CSS/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="CSS/CssIndex.css">
    </head>

<body>
<?php
session_start();
if(isset($_SESSION["Nombre"])){
    header("location: index.php");
}
?>


<div class="container" style="margin-top: 30px;">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="login-form" name="login" method="post" action="ValidarUserEiniciarSession.php" role="form">
                    <legend>Inicio de sesión</legend>
                    <?php
                        if(isset($_POST["Err"]))
                            echo "<div class='alert alert-danger text-center' role='alert'>
                                  Inicio de sesión Fallido! usuario o password invalidos!
                            </div>";
                    ?>


                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="User" placeholder="Usuario o email" required class="form-control"/>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="pass" placeholder="Contraseña" required class="form-control"/>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Iniciar Sesión" class="btn btn-primary btn-block" />
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6" style="padding: 0;">¿Nuevo Usuario? <a href="Registro.php">Registrarse</a></div>
                        <div class="col-sm-6" style="padding: 0;">¿Olvidaste tu contraseña? <a href="#">!Pulsa aqui!</a> </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6  brand" style="padding: 0;">ElPanzas.com</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
