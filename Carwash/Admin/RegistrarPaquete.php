<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["servicios"])){
    $link=ConectarseaBD();
    $matricula=$link->real_escape_string($_POST['matric']);
    $arrayServicios=$_POST["servicios"];  // {Nombre, precio, ID}
    $discount=$link->real_escape_string($_POST["desc"]);
    $subtotal=$link->real_escape_string($_POST["sub"]);
    $idVehiculo=$_POST["idvehiculo"];
    $total=$subtotal-$discount;

    //Se inserta en paquete en la BD
    $link->query("INSERT INTO paquete VALUES (NULL,NULL,$subtotal,$discount,$total,1,1)");
    //se toma el ultimo paquete que se ha insertado
    $Reasultado=$link->query("SELECT MAX(paq_idPaquete) from paquete");
    if($Reasultado){
        //Se Obtiene el id del paquete
        $Reasultado->data_seek(0);
        $array=$Reasultado->fetch_array(MYSQLI_NUM);
        $idPaquete= $array[0];
        //Se insertan los datos al detalle
       $contador=0;
       foreach ($arrayServicios as $servicio){
           if($contador==2){
               $result=$link->query("INSERT INTO paquete_servicio VALUES ('$idPaquete','$servicio')");
               $contador=0;
           }else{
               $contador++;
           }
       }

       //Se inserta la matricula en el vehiculo
        $link->query("INSERT INTO vehiculo VALUES('$matricula','$idVehiculo')");

        //Se actualiza el detalle vehiculo_paquete
        $total=$subtotal-$discount;
        $resultado=$link->query("INSERT INTO vehiculo_paquete VALUES ('$matricula','$idPaquete',NULL)");

        //Retornara el numero de orden siguiente
        $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM paquete WHERE paq_tipo=1");
        $resuta->data_seek(0);
        $resuta=$resuta->fetch_array(MYSQLI_NUM);

        echo ($resuta[0]+1);
    }else{
        echo "Error";
    }
    $link->close();
}else{
    //echo "No se recibieron datos";
}

?>