<?php
require_once ("../FuncionesPHP.php");

if( isset($_POST["idEmp"]) ){
    $enlace  = ConectarseaBD();
    $idemp  = $_POST["idEmp"];

    $linn=ConectarseaBD();
    $ress=$linn->query("SELECT * FROM empleado WHERE emp_idEmpleado=".$idemp);

    $ress->data_seek(0);
    $arr=$ress->fetch_array(MYSQLI_ASSOC);
    $JsonResponse["name"]=$arr["emp_nombre"];
    $JsonResponse["mail"]=$arr["emp_correo"];
    $JsonResponse["gender"]=$arr["emp_genero"];
    $JsonResponse["tel"]=$arr["emp_telefono"];
    $JsonResponse["turn"]=$arr["emp_turno"];
    $JsonResponse["address"]=$arr["emp_direccion"];
    $JsonResponse["salary"]=$arr["emp_salario"];
    $JsonResponse["state"]=$arr["emp_estado"];
    $JsonResponse["dateIng"]=$arr["emp_fechaIngreso"];
    $ress->close();

    $result=$linn->query("SELECT re.re_idRol
                                 FROM rolempleado re join empleado_rolempleado ere on ere.ER_idRol=re.re_idRol
                                 WHERE ere.ER_idEmpleado=".$idemp);

    $arrayRoles=Array();
    for ($i=0; $i<$result->num_rows; $i++){
        $result->data_seek($i);
        $arr=$result->fetch_array(MYSQLI_ASSOC);
        array_push($arrayRoles, $arr["re_idRol"]);
    }

    $JsonResponse["idEmp"]=$idemp;
    $JsonResponse["Roles"]=$arrayRoles;
    echo json_encode($JsonResponse);
    $linn->close();
}