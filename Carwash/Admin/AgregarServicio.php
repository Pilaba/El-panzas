<body>
    <div id="wrapper">
        <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");
        ConectarseaBD();
        ?>

        <div id="page-wrapper">
            <div class="container-fluid">

                <form class="navbar-form" method="post" action="AgregarServicio.php">
                    <table>
                        <tr>
                            <td>Nombre  </td>
                            <td><input type="text" name="name" id="name"></td>
                        </tr>
                        <tr>
                            <td>precio base </td>
                            <td><input type="number" name="price" id="price"> </td>
                        </tr>
                        <tr>
                            <td>Imagen</td>
                            <td><input type="file" name="archivo" id="archivo"></td>
                        </tr>
                        <tr>
                            <td><input type="submit"></td>
                        </tr>
                    </table>
                </form>




                <?php
                    if (!isset($_FILES["archivo"]) || $_FILES["archivo"]["error"] > 0){
                        echo "Ha ocurrido un error.";
                    }else{
                        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                        $limite_kb = 16384;
                        if (in_array($_FILES['archivo']['type'], $permitidos) && $_FILES['archivo']['size'] <= $limite_kb * 1024){

                            // Archivo temporal
                            $imagen_temporal = $_FILES['archivo']['tmp_name'];

                            // Tipo de archivo
                            $tipo = $_FILES['archivo']['type'];

                            // Leemos el contenido del archivo temporal en binario.
                            $fp = fopen($imagen_temporal, 'r+b');
                            $data = fread($fp, filesize($imagen_temporal));
                            fclose($fp);

                            //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
                            // $data=file_get_contents($imagen_temporal);

                            // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
                            $data = mysql_escape_string($data);

                            $precio= $_POST["price"];
                            $name=$_POST["name"];

                            // Insertamos en la base de datos.
                            $resultado = @mysql_query("INSERT INTO servicio VALUES ('','$precio','$name','1','$data')");

                            if ($resultado){
                                echo "El archivo ha sido copiado exitosamente.";
                            }
                            else{
                                echo "Ocurrió algun error al copiar el archivo.";
                            }
                        }
                        else{
                            echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
                        }
                    }
                ?>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>


</body>

<?php
function subir_fichero($directorio_destino, $nombre_fichero){
    $tmp_name = $_FILES[$nombre_fichero]['tmp_name'];
    //si hemos enviado un directorio que existe realmente y hemos subido el archivo
    if (is_dir($directorio_destino) && is_uploaded_file($tmp_name))
    {
        $img_file = $_FILES[$nombre_fichero]['name'];
        $img_type = $_FILES[$nombre_fichero]['type'];
        echo 1;
        // Si se trata de una imagen
        if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
                strpos($img_type, "jpg")) || strpos($img_type, "png")))
        {
            //¿Tenemos permisos para subir la imágen?
            echo 2;
            if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file))
            {
                return true;
            }
        }
    }
    //Si llegamos hasta aquí es que algo ha fallado
    return false;
}
?>