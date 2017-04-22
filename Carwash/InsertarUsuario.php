<?php
require_once ('ConexionBD.php');
$user =$_POST['usuario'];
$email =$_POST['email'];
$pass =$_POST['pass'];


$result=$Mysqli->query("INSERT INTO usuario 
                               VALUES (NULL,2,'$user','$email','$pass',NULL)");

$Mysqli->close();
if($result==TRUE){
    echo ("Registro Correcto");
}else{
    echo ("Registro fallido");
}

?>


