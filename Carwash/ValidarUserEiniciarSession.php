<?php
require_once ("FuncionesPHP.php");
$Mysqli=ConectarseaBD();
$user =$_POST['User'];
$pass =$_POST['pass'];
$global=FALSE;

$result= $Mysqli->query("select * 
                                FROM usuario us JOIN rolessistema rs ON us.id_rolS=rs.id_rolS 
                                WHERE (us.nombre='$user' OR us.correo='$user') AND us.contrasena='$pass'");

if($rows=$result->num_rows){
    try{
        session_start();
    }catch(Exception $e){
    }
    /* SE inicia la sesion con las credenciales del usuario */
    for ($i=0; $i<$rows; $i++){
        $result->data_seek($i);                             /* PUNTERO Ajusta el puntero de resultado a una fila arbitraria ($i) del resultado  */
        $array=$result->fetch_array(MYSQLI_ASSOC);/*tratar el resultado como un array associativo key -> value */
        $_SESSION['Nombre'] = $array["nombre"];
        $_SESSION['rol'] = $array["id_rolS"];
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