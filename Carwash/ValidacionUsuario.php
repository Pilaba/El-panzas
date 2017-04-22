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

if(isset($_SESSION["Nombre"])){
    header("location: index.php");
}

$result= $Mysqli->query("select * 
                                FROM usuario us JOIN rolessistema rs ON us.id_rolS=rs.id_rolS 
                                WHERE (us.nombre='$user' OR us.correo='$user') AND us.contrasena='$pass'");

if($rows=$result->num_rows){
    session_start();  /* SE inicia la sesion con las credenciales del usuario */
    $_SESSION['Nombre'] = $user;
    $_SESSION['password'] = $pass;
    header("location: Index.php");
}else{
    header("location: Login.php");
}

    /*Se cierran las conecciones abiertas */
$Mysqli->close();
















