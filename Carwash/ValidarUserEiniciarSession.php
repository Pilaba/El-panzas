<?php
require_once ("FuncionesPHP.php");
$Mysqli=ConectarseaBD();

$user =$Mysqli->real_escape_string($_POST['User']);
$pass =$Mysqli->real_escape_string($_POST['pass']);

$result= $Mysqli->query("select * 
                                FROM usuario us JOIN rolsistema rs ON us.usu_idRol=rs.rs_idRol 
                                WHERE (us.usu_nombre='$user' OR us.usu_correo='$user') AND us.usu_contrasena='$pass'");

if($rows=$result->num_rows){
    @session_start();
    /* SE inicia la sesion con las credenciales del usuario */
    for ($i=0; $i<$rows; $i++){
        $result->data_seek($i);                             /* PUNTERO Ajusta el puntero de resultado a una fila arbitraria ($i) del resultado  */
        $array=$result->fetch_array(MYSQLI_ASSOC);/*tratar el resultado como un array associativo key -> value */
        $_SESSION['Nombre'] = $array["usu_nombre"];
        $_SESSION['rol'] = $array["usu_idRol"];
    }

    header("location: Index.php");
}else{
    echo "<form name='FormError'action='Login.php' method='post'>
            <input type='hidden' name='usuario' value=$user>
            <input type='hidden' name='Err' value='TRUE'> 
          </form>";

    echo "<script> 
               document.forms['FormError'].submit();
          </script>";
}

/*Se cierran las conecciones abiertas */
$result->close();
$Mysqli->close();

?>