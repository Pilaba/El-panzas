<?php
require_once ('ConexionBD.php');
$user =$_POST['usuario'];
$email =$_POST['email'];
$pass =$_POST['pass'];

mysql_query("INSERT INTO usuariossistem VALUES ('','$user', '$email','$pass',10)");



?>