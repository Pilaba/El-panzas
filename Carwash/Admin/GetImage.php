<?php

if(isset($_GET["id"])){
    require_once ("../FuncionesPHP.php");

    $Link=ConectarseaBD();
    $id=$Link->real_escape_string($_GET["id"]);

    $result=$Link->query("SELECT serv_imagen,serv_mime FROM servicio WHERE serv_idServicio='$id'");

    $img=NULL;
    $type=NULL;
    for($i=0; $i<$result->num_rows; $i++) {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $img=$row["serv_imagen"];
        $type=$row["serv_mime"];
    }

    header("Content-Type: image");
    echo ($img);
}

?>


