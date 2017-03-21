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
$result = Mysql_query("select * FROM usuariossistem us JOIN rolessistema rs ON us.id_Rol=rs.id_rolS WHERE (us.nombre='$user' OR us.email='$user') AND us.contrasena='$pass'");

if(mysql_num_rows($result)){
    echo ("Tu usuario existe");
}else{
    echo ("tu usuario no existe");
}











