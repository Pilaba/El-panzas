<?php
session_start();
if(isset ($_SESSION["Nombre"])){
    $user=$_SESSION["Nombre"];
    echo <<<_end
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"> 
                                <span class="glyphicon glyphicon-user"></span> $user
                                <b class="caret"></b>   
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Mi Cuenta</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Preferencias</a></li>
                                <li><a href="#">Historial</a></li>
                                <li class="divider"></li>
                                <li><a href="EliminarSession.php">Salir</a></li>
                            </ul>
                        </li>
                    </ul>
_end;
}else{
    echo <<<_end
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Inicio de sesión</a>
                         </li>
                    </ul>
_end;
}



















?>