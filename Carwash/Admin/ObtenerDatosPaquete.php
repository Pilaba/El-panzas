<?php
require_once ("../FuncionesPHP.php");

if( isset($_POST["idpaquete"]) ){
    $enlace  = ConectarseaBD();
    $idemp  = $_POST["idpaquete"];

    $linn=ConectarseaBD();
    $ress=$linn->query("SELECT * FROM paquete P join tipopaquete TP on P.paq_tipo=TP.tp_idTipo 
    WHERE P.paq_tipo!=1 AND P.paq_idPaquete=".$idemp);

    $ress->data_seek(0);
    $arr=$ress->fetch_array(MYSQLI_ASSOC);
    $JsonResponse["nombreP"]=$arr["tp_nombre"];
    $JsonResponse["fechaP"]=$arr["paq_fechaCreacion"];
    $JsonResponse["importe"]=$arr["paq_importe"];
    $JsonResponse["Descuento"]=$arr["paq_descuento"];
    $JsonResponse["Total"]=$arr["paq_Total"];
    $JsonResponse["state"]=$arr["paq_Estado"];
    $JsonResponse["idPromo"]=$arr["paq_idPaquete"];
    $ress->close();

    echo json_encode($JsonResponse);
    $linn->close();
}