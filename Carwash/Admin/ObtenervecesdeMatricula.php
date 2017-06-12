<?php

if(isset($_POST["matricula"])){
    require_once ("../FuncionesPHP.php");
    $link=ConectarseaBD();
    $matr=$link->real_escape_string($_POST["matricula"]);
    $result=$link->query("SELECT COUNT(*) FROM vehiculo_paquete WHERE VP_matricula='$matr'");
    $result->data_seek(0);
    $resuta=$result->fetch_array(MYSQLI_NUM);
    echo ($resuta[0]);
    $link->close();
}