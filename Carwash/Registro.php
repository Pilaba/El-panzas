
<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="CSS/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="CSS/CssIndex.css">
    <link rel="stylesheet" href="">
</head>

<body>
<div class="container" style="margin-top: 30px;">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <form id="login-form" method="post" action="InsertarUsuario.php" role="form">
                    <legend>Registro</legend>

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
                        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block" />
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

