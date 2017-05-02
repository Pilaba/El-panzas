
     <div id="wrapper">
        <?php

      /*SE UTILIZA EL REQUIRE_ONCE PARA TRAER TODA LA INFORMACION QUE SE ENCUENTRA EN EL ARCHIVO FuncionesPHP.php*/
        require_once ("../FuncionesPHP.php");
      /*SE CREA UNA VARIABLE IdEmpl DONDE SE VA A GUARDAR LA INFORMACION */
       $IdEmpl=$_POST["Id"];
            /*SE HACE LA CONEXION CON LA BASE DE DATOS*/
            $Link = ConectarseaBD();
            $Resultado = $Link->query ("DELETE FROM empleado WHERE id_empleado='$IdEmpl'");
            $Link->close();
            /*SE HACE UNA CONDICION*/
            if ($Resultado==TRUE ) {
                /*SE UTILIZA LA FUNCION header PARA QUE NO NO SE IMPRIMA OTRA INFORMACION DE LA PAGINA*/
                header("location: VerEmpleados.php");
                }else{
                    echo "error";
                }
        ?>
