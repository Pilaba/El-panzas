<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["idpaq"])){
    $link=ConectarseaBD();
    $idPaq=$link->real_escape_string($_POST["idpaq"]);

    //CONSULTA PARA OBTENER LOS SERVICIOS
    $result=$link->query("SELECT SE.serv_nombre 
     FROM (( paquete_servicio PS JOIN servicio SE ON SE.serv_idServicio=PS.PS_idServicio ) 
	     JOIN paquete P on P.paq_idPaquete=PS.PS_idPaquete)
         JOIN vehiculo_paquete VP on VP.VP_idPaquete=P.paq_idPaquete
     WHERE VP.VP_Fecha='$idPaq'");

    //CONSULTA PARA OBTENER LOS DATOS DEL VEHICULO
    $result2=$link->query("SELECT v.vehi_matricula, tv.tv_nombre 
    FROM (vehiculo_paquete vp JOIN vehiculo v ON vp.VP_matricula=v.vehi_matricula) 
	    JOIN  tipovehiculo tv on tv.tv_idTipo=v.vehi_id_Tipo
    WHERE vp.VP_Fecha='$idPaq'");

    if($result && $result2){
        $arr=Array();
        for ($i=0; $i<$result->num_rows; $i++){
            $result->data_seek($i);
            $array=$result->fetch_array(MYSQLI_ASSOC);
            array_push($arr,$array["serv_nombre"]);
        }
        $ArrayRespuesta["servicios"]=$arr;
        for ($i=0; $i<$result2->num_rows; $i++){
            $result2->data_seek($i);
            $array=$result2->fetch_array(MYSQLI_ASSOC);
            $ArrayRespuesta["NomVehiculo"]=$array["tv_nombre"];
            $ArrayRespuesta["MatrVehiculo"]=$array["vehi_matricula"];
        }
        echo json_encode($ArrayRespuesta);
    }
    $link->close();
}
