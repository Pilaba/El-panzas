<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesion</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="CSS/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="CSS/CssIndex.css">
</head>

<body>
<div class="container" style="margin-top: 30px;">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="login-form" method="post" action="ValidacionUsuario.php" role="form">
                    <legend>Inicio de sesión</legend>
                    <?php if (isset($_GET['err'])) { ?>
                        <div class="alert alert-danger text-center"> <?php echo "Login failed! Invalid email-id or password!"; ?></div>
                    <?php } ?>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="User" placeholder="Usuario o email" required class="form-control" />
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="pass" placeholder="Contraseña" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block" />
                    </div>

                    <div class="form-group">
                        <hr/>
                        <div class="col-sm-6" style="padding: 0;">Nuevo Usuario? <a href="Registro.php">Registrarse</a></div>
                        <div class="col-sm-6 text-right brand" style="padding: 0;">ElPanzas.com</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
