<?php
require_once ("../../FuncionesPHP.php");

if(isset($_POST["idPaquete"])){
    $link=ConectarseaBD();
    $IdPaquete=$link->real_escape_string($_POST['idPaquete']);
    $Arrayresp=Array(); //Array que contendra los valores retornados por el servidor

    $servicios=Array();
    $result=$link->query("SELECT PS_idServicio FROM paquete_servicio WHERE PS_idPaquete='$IdPaquete'");
    if($result){
        for ($i=0; $i<$result->num_rows; $i++){
            $result->data_seek($i);
            $array=$result->fetch_array(MYSQLI_ASSOC);
            array_push($servicios,$array["PS_idServicio"]);
        }
        $Arrayresp["idServicios"]=$servicios;
    }

    $NomServ=Array();
    $result2=$link->query("SELECT serv_nombre 
    FROM servicio S join paquete_servicio PS on S.serv_idServicio=PS.PS_idServicio
    WHERE serv_estado=1 AND PS.PS_idPaquete='$IdPaquete'");
    if($result2){
        for ($j=0; $j<$result2->num_rows; $j++){
            $result2->data_seek($j);
            $array2=$result2->fetch_array(MYSQLI_ASSOC);
            array_push($NomServ,$array2["serv_nombre"]);
        }
        $Arrayresp["NomServicios"]=$NomServ;
    }

    echo json_encode($Arrayresp);
    $link->close();
}

