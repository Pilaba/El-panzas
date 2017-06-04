<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["servicios"])){
    $link=ConectarseaBD();
    $arrayServicios=$_POST["servicios"];  // {Nombre, precio, ID}
    $discount=$link->real_escape_string($_POST["desc"]);
    $subtotal=$link->real_escape_string($_POST["sub"]);
    $total=$subtotal-$discount;
    $nombreP=$link->real_escape_string($_POST["nombreP"]);

    //Se inserta el nombre de la promocion
    $link->query("INSERT INTO tipopaquete VALUES (NULL,'$nombreP')");

    //Se toma la ultima promocion para insertarla en paquete
    $ultimaPromo=$link->query("SELECT MAX(tp_idTipo) from tipopaquete");
    $idPromo=999;
    if($ultimaPromo){
        $ultimaPromo->data_seek(0);
        $array=$ultimaPromo->fetch_array(MYSQLI_NUM);
        $idPromo = $array[0];
    }

    //Se inserta en paquete en la BD
    $link->query("INSERT INTO paquete VALUES (NULL,NULL,$subtotal,$discount,$total,1,$idPromo)");

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

        //Retornara el numero de orden siguiente
        $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM paquete WHERE paq_tipo!=1");
        $resuta->data_seek(0);
        $resuta=$resuta->fetch_array(MYSQLI_NUM);

        echo ($resuta[0]+1);
    }else{
        echo "Error";
    }
    $link->close();

}