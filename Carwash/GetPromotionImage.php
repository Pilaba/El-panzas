<?php
if(isset($_GET["numProm"])){
    require_once ("FuncionesPHP.php");
    $Link=ConectarseaBD();
    $id=$Link->real_escape_string($_GET["numProm"]);
    $result=$Link->query("SELECT paq_Img,paq_ImgMime,paq_Estado FROM paquete WHERE (paq_idPaquete='$id' AND paq_Estado=1)");
    $img=NULL;
    $type=NULL;
    for($i=0; $i<$result->num_rows; $i++) {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $img=$row["paq_Img"];
        $type=$row["paq_ImgMime"];
    }
    header("Content-Type: image");
    echo ($img);
}
