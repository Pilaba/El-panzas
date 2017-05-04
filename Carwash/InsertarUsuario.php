<?php

session_start();
if(isset($_SESSION["Nombre"])){
    header("location: index.php");
}

require_once ("FuncionesPHP.php");
$Mysqli=ConectarseaBD();
$user  = $Mysqli->real_escape_string($_POST['usuario']);
$email = $Mysqli->real_escape_string($_POST['email']);
$pass  = $Mysqli->real_escape_string($_POST['pass']);


$result=$Mysqli->query("INSERT INTO usuario 
                               VALUES (NULL,2,'$user','$email','$pass',NULL)");

$Mysqli->close();
if($result==TRUE){
    echo <<<_texto
        <form name="formExito" action="Registro.php" method="POST"> 
            <input type="hidden" name="exito" value="TRUE">
        </form>
        
        <script> 
            document.forms['formExito'].submit();
        </script>
_texto;
}else{
    echo <<<_texto
        <form name="formFallo" action="Registro.php" method="POST"> 
            <input type="hidden" name="fallo" value="TRUE">
        </form>
        
        <script> 
            document.forms['formFallo'].submit();
        </script>
_texto;
}

?>


