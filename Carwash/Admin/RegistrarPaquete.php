<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["servicios"])){
    $link=ConectarseaBD();
    $matricula=$link->real_escape_string($_POST['matric']);
    $arrayServicios=$_POST["servicios"];  // {Nombre, precio, ID}
    $discount=$link->real_escape_string($_POST["desc"]);
    $subtotal=$link->real_escape_string($_POST["sub"]);
    $idVehiculo=$_POST["idvehiculo"];

    //Se inserta la matricula en el vehiculo
    $link->query("INSERT INTO vehiculo VALUES('$matricula','$idVehiculo')");

    //En caso de que se seleccione una promo
    if(isset($_POST["promo"])){
        foreach ($_POST["promo"] as $idppromo){
            //Se inserta el detalle del promo seleccionado
            $link->query("INSERT INTO vehiculo_paquete VALUES ('$matricula','$idppromo',NULL,'$subtotal','$discount',NULL)");
        }
    }

    //Se Obtienen por nombre todos los servicios de la BD
    $Servicios=Array();
    $result=$link->query("SELECT serv_nombre FROM servicio WHERE serv_estado=1");
    if($result){
        for ($j=0; $j<$result->num_rows; $j++){
            $result->data_seek($j);
            $array2=$result->fetch_array(MYSQLI_ASSOC);
            array_push($Servicios,$array2["serv_nombre"]);
        }
    }

    //Si se agregaron servicios
    if(isset($_POST["servicios"])){
        $idPaquete="";
        $contador=0;
        $bandera=true;
        foreach ($_POST["servicios"] as $serv ){ //En caso de coincidir este se agrega una vez al paquete la detalle del mismo
            if($contador==0){
                foreach ($Servicios as $ServiciosDisponibles){
                    if($serv==$ServiciosDisponibles){
                        if($bandera){
                            //Se inserta en paquete en la BD
                            $link->query("INSERT INTO paquete VALUES (NULL,NULL,$subtotal,$discount,NULL,1,1)");
                            //se toma el ultimo paquete que se ha insertado
                            $Reasultado=$link->query("SELECT MAX(paq_idPaquete) from paquete");
                            if($Reasultado) {
                                //Se Obtiene el id del paquete
                                $Reasultado->data_seek(0);
                                $array = $Reasultado->fetch_array(MYSQLI_NUM);
                                $idPaquete = $array[0];
                            }
                            $bandera=false;
                        }
                        //Se obtiene el ID sel servicio
                        $reul=$link->query("SELECT serv_idServicio FROM servicio WHERE serv_nombre='$serv'");
                        $reul->data_seek(0);
                        $Arr=$reul->fetch_array(MYSQLI_NUM);
                        $idServ=$Arr[0];

                        //Se insertan los servicios al detalle
                        $result=$link->query("INSERT INTO paquete_servicio VALUES ('$idPaquete','$idServ')");
                    }
                }
                $contador++;
            }else if ($contador==2){
                $contador=0;
            }else{
                $contador++;
            }
        }
        //SE INSERTA EL DETALLE A VEHICULO_PAQUETE
        $link->query("INSERT INTO vehiculo_paquete VALUES ('$matricula','$idPaquete',NULL,$subtotal,'$discount',NULL)");

        //Retornara el numero de orden siguiente
        $resuta=ConectarseaBD()->query("SELECT COUNT(*) FROM paquete WHERE paq_tipo=1");
        $resuta->data_seek(0);
        $resuta=$resuta->fetch_array(MYSQLI_NUM);
        echo ($resuta[0]+1);
    }

    $link->close();
}





?>