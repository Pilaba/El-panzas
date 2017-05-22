<?php
require_once ("FuncionesPHP.php");
@session_start();
if(isset($_SESSION["id"])){
    $link=ConectarseaBD();
    $idUsuario=$link->real_escape_string($_SESSION["id"]);

    $resultado=$link->query("SELECT * FROM usuario WHERE usu_idUsuario='$idUsuario'");

    if($resultado){
        $resultado->data_seek(0);
        $array=$resultado->fetch_array(MYSQLI_ASSOC);

        $JSONresp["nombre"]=$array["usu_nombre"];
        $JSONresp["correo"]=$array["usu_correo"];
        $JSONresp["tel"]=$array["usu_telefono"];

        echo json_encode($JSONresp);
    }
    $link->close();

}

?>