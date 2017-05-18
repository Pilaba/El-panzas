<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["idpaq"])){
    $link=ConectarseaBD();
    $idPaq=$link->real_escape_string($_POST["idpaq"]);

    $result=$link->query("SELECT SE.serv_nombre 
                                FROM paquete_servicio PS JOIN servicio SE ON SE.serv_idServicio=PS.PS_idServicio 
                                WHERE PS.PS_idPaquete='$idPaq'");
    if($result){
        $arrayservicios=Array();
        for ($i=0; $i<$result->num_rows; $i++){
            $result->data_seek($i);
            $array=$result->fetch_array(MYSQLI_ASSOC);
            array_push($arrayservicios,$array["serv_nombre"]);
        }
        echo json_encode($arrayservicios);
    }else{
        echo "Error";
    }
    $link->close();
}

?>