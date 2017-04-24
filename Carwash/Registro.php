<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="CSS/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="CSS/CssIndex.css">
</head>
<?php
    session_start();
    if(isset($_SESSION["Nombre"])){
        header("location: index.php");
    }
?>

<body>
<div class="container" style="margin-top: 30px;">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="login-form" method="post" action="InsertarUsuario.php" role="form">
                    <legend>Registro</legend>

                    <?php
                    if(isset($_POST["fallo"])){
                        echo "<div class='alert alert-danger text-center' role='alert'>
                                  Registro Fallido!, email o usuario invalido.
                              </div>";
                    }else if(isset($_POST["exito"])){
                        echo "<div class='alert alert-success text-center' role='alert'>
                                    Registro Exitoso!, Ahora puedes <a href='Login.php' class='alert-link'> iniciar sesión </a>
                              </div>";
                    }
                    ?>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="usuario" placeholder="usuario" required class="form-control" />
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="email" name="email" placeholder="email" required class="form-control"/>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="pass" placeholder="Contraseña" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Registrarse" class="btn btn-primary btn-block" />
                    </div>

                    <div class="form-group">
                        <hr/>
                        <div class="col-sm-6" style="padding: 0;">Ya tiene cuenta? <a href="Login.php">Inicio de sesión</a></div>
                        <div class="col-sm-6 text-right brand" style="padding: 0;">ElPanzas.com</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

