
<?php
require_once ("../FuncionesPHP.php");

    if(isset($_POST["Id"])){
        $IdEmpl=$_POST["Id"];
        $Link = ConectarseaBD();
        $Resultado = $Link->query ("UPDATE empleado SET emp_estado='2' WHERE emp_idEmpleado='$IdEmpl'");
        $Link->close();
        if ($Resultado==TRUE ) {
            header("location: VerEmpleados.php");
        }else{
            echo "error";
        }
    }
?>
