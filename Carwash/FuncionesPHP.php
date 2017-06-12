<?php

function ConectarseaBD(){
    STATIC $dbHost = 'localhost';
    STATIC $dbUser = 'root';
    STATIC $dbPass = '';
    STATIC $dbName = 'carwashBD';

    /* Se utilizara el modo orientado a objetos por sobre el procedural  http://php.net/manual/es/book.mysqli.php */

    $Mysqli = new mysqli($dbHost, $dbUser, $dbPass,$dbName);
    $Mysqli->set_charset("utf8");

    if ($Mysqli->connect_error) die($Mysqli->connect_error);/* comprobacion si existe error */
    return $Mysqli;
}

/* Funcion para desplegar el menu de usuario adecuado para cada tipo 1=admin 2=cliente */
function MenuUsuario(){
    @session_start();
    if(isset ($_SESSION["Nombre"]) && isset($_SESSION['rol'])){
        $user=$_SESSION["Nombre"];
        $rol=$_SESSION['rol'];

        if($rol==1){
            echo <<<_etiqueta
            <ul class="nav navbar-nav navbar-right"> 
                <a href="Admin" type="button" class="btn btn-default navbar-btn">
                    <span class="glyphicon glyphicon-cog"></span> ADMINISTRAR
                </a>
            </ul>
_etiqueta;
        }
        echo <<<_end
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"> 
                                <span class="glyphicon glyphicon-user"></span> $user
                                <b class="caret"></b>   
                            </a>
                            <ul class="dropdown-menu">
                            <li><a id="MiCuenta" href="#"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Mi Cuenta</a></li>
                            <li class="divider"></li>
_end;
        if($rol==1){

        }else{
            echo <<<_endd
                                
                                <li><a href="#" id="DarAlta"><i class="glyphicon glyphicon-wrench">&nbsp;</i>Dar de alta una matricula</a></li>
                                <li><a id="Historial" href="#"><i class="glyphicon glyphicon-th-list">&nbsp;</i>Historial</a></li>
                                <li class="divider"></li>
_endd;
        }
        echo <<<_enddd
                                
                                <li><a href="EliminarSession.php"><i class="glyphicon glyphicon-off">&nbsp;</i> Salir </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
_enddd;

    }else{
        echo <<<_end
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Inicio de sesión</a>
                         </li>
                    </ul>
_end;
    }
}