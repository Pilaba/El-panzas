<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["servicios"])){
    $link=ConectarseaBD();
    $arrayServicios=$_POST["servicios"];  // {Nombre, precio, ID}
    $discount=$link->real_escape_string($_POST["desc"]);
    $subtotal=$link->real_escape_string($_POST["sub"]);
    $nombreP=$link->real_escape_string($_POST["nombreP"]);

    //Se comprueba que no exista el nombre de la promocion
    $result = $link->query("SELECT * FROM tipopaquete WHERE tp_nombre='$nombreP'");
    if($result->num_rows != 0){
        $ArrayRespuesta["Error"]="Error";
    }else{
        //Se inserta el nombre de la promocion
        $link->query("INSERT INTO tipopaquete VALUES (NULL,'$nombreP')");

        //Se Llama al procedimiento para insertar un paquete (LLenarPaquete)
        $link->query("CALL LLenarPaquete ('$subtotal','$discount','$nombreP')");

        //Se llama al procedimiento que llena el detalle paquete_servicio (Pr_DetallePaq_Serv)
        //Se insertan los datos al detalle
        $contador=0;
        foreach ($arrayServicios as $servicio){
            if($contador==2){
                $Reasultado=$link->query("CALL Pr_DetallePaq_Serv ('$servicio','$nombreP')");
                $contador=0;
            }else{
                $contador++;
            }
        }

        //Retorna el ID de la promocion
        $retorna2=ConectarseaBD()->query("SELECT P.paq_idPaquete FROM paquete p JOIN tipopaquete TP on TP.tp_idTipo=P.paq_tipo WHERE TP.tp_nombre='$nombreP'");
        $retorna2->data_seek(0);
        $retorna2=$retorna2->fetch_array(MYSQLI_NUM);
        $ArrayRespuesta["IDpaq"]=$retorna2[0];

        echo json_encode($ArrayRespuesta);
        $link->close();
    }
}