<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["seleccion"])){
    $Link=ConectarseaBD();
    $result=0;
    switch ($seleccion=$Link->real_escape_string($_POST["seleccion"])){
        case 0: $result=$Link->query("SELECT * 
                                    FROM vehiculo_paquete VP JOIN paquete P on P.paq_idPaquete=VP.VP_idPaquete
                                    ORDER BY VP_Fecha DESC LIMIT 10");
            break;
        case 1: $result=$Link->query("SELECT * 
                                             FROM vehiculo_paquete VP JOIN paquete P on P.paq_idPaquete=VP.VP_idPaquete
                                             WHERE (VP_Fecha BETWEEN (CURDATE()) AND (CURDATE() + INTERVAL 1 DAY) ) 
                                             ORDER BY VP_Fecha DESC");
            break;
        case 2:
            $result=$Link->query("SELECT * 
                                        FROM vehiculo_paquete VP JOIN paquete P on P.paq_idPaquete=VP.VP_idPaquete
                                        WHERE (VP_Fecha BETWEEN (CURDATE() - INTERVAL 7 DAY) AND (CURDATE() +INTERVAL 1 DAY) ) 
                                        ORDER BY VP_Fecha DESC");
            break;
        case 3:
            $from=$Link->real_escape_string($_POST["Fromm"]);
            $to=$Link->real_escape_string($_POST["Too"]);
            $result=$Link->query("SELECT * 
                                        FROM vehiculo_paquete VP JOIN paquete P on P.paq_idPaquete=VP.VP_idPaquete
                                        WHERE (VP_Fecha BETWEEN '$from' AND '$to' ) 
                                        ORDER BY VP_Fecha DESC");
            break;
        default:
            exit;
    }
    if($result){
        $filas=Array();
        for ($i=0; $i<$result->num_rows; $i++){
            $result->data_seek($i);
            $array=$result->fetch_array(MYSQLI_ASSOC);
            array_push($filas,$array["VP_idPaquete"]);
            array_push($filas,$array["VP_Fecha"]);
            array_push($filas,$array["paq_importe"]);
            array_push($filas,$array["paq_descuento"]);
            array_push($filas,$array["paq_Total"]);
        }
        $arrresp["resp"]=$filas;
        echo json_encode($arrresp);
    }
    $Link->close();
}



