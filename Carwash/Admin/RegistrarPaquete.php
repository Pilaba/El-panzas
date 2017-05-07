<?php
require_once ("../FuncionesPHP.php");

if(isset($_POST["servicios"]) && isset($_POST["cliente"]) && isset($_POST["desc"])){
    $link=ConectarseaBD();
    $cliente=$link->real_escape_string($_POST['cliente']);
    $arrayServicios=$_POST["servicios"];

    //Se inserta el usuario del paquete a la BD
    $Reasultado=$link->query("INSERT INTO usuario 
                                     VALUES (NULL,2,'$cliente',NULL,'$cliente',NULL)");
    if($Reasultado){
        $id_cliente=realizarSelect($link,"SELECT * FROM usuario WHERE nombre='$cliente'");
        $id_cliente["id_usuario"];

        //Se insertan los servicios que pidio este cliente y se insertan en la BD en la tabla detalleservusuario
        $Reasultado=$link->query("INSERT INTO  ")





    }else{
        echo "Ya Existe ese nombre en la BD";
        exit ;
    }



    foreach ($arrayServicios as $servicio){ //Array de servicios tiene {Nombre, precio, id}
        echo $servicio;
    }

     //echo implode(", ", $_POST["array"]); separar por comas
}else{
    echo "No se recibio ningun dato";
}

?>