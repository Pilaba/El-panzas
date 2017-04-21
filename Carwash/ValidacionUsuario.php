<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 17/03/2017
 * Time: 01:31 AM
 */
require_once("ConexionBD.php");
$user =$_POST['User'];
$pass =$_POST['pass'];

function destroy_sesion(){
    $_SESSION=array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}
destroy_sesion();

$result= $Mysqli->query("select * 
                                FROM usuario us JOIN rolessistema rs ON us.id_rolS=rs.id_rolS 
                                WHERE (us.nombre='$user' OR us.correo='$user') AND us.contrasena='$pass'");

if($rows=$result->num_rows){
    session_start();  /* SE inicia la sesion con las credenciales del usuario */
    $_SESSION['Nombre'] = $user;
    $_SESSION['pass'] = $pass;
    header("location: index.php");
}else{
    header("location: Login.php");
}

/*Se cierran las conecciones abiertas */
$result->close();
$Mysqli->close();











