<?php
require_once ("FuncionesPHP.php");
@session_start();
if(isset($_POST["matricula"])){
    $link=ConectarseaBD();
    $iduser=$_SESSION["id"];
    $matr=$link->real_escape_string($_POST["matricula"]);
    $contador=$link->real_escape_string($_POST["contador"]);

    if($contador>=15){
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '+3 hour' , strtotime ( $fecha ) ) ;
        if($nuevafecha==date('Y-m-j')){
            $contador=0;
        }
    }else{
        $resultado=$link->query("INSERT INTO vehiculo_usuario (VU_idUsuario,VU_matricula) VALUES ('$iduser','$matr')");
        if($resultado){
            $JSONresp["exito"]="true";
            $JSONresp["contadorr"]=$contador;
            echo json_encode($JSONresp);
        }else {
            $JSONresp["contadorr"]=$contador;
            $JSONresp["error"]="false";
            echo json_encode($JSONresp);
        }
    }
    $link->close();
}