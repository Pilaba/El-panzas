<?php
require_once ('ConexionBD.php');
$user =$_POST['usuario'];
$email =$_POST['email'];
$pass =$_POST['pass'];

$result=mysql_query("INSERT INTO usuariossistem VALUES ('','$user', '$email','$pass',1)");

if($result==TRUE){
  echo ("Registro correcto");
}else{
 echo ("Registro fallido"); 
}

?>
