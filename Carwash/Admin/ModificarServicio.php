<body>
<div id="wrapper">
    <?php
        require_once ("Menu.php");
        require_once  ("../FuncionesPHP.php");
    ?>

    <div id="page-wrapper">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title"> Modificar Servicio </h2>
            </div>
            <div class="panel-body">
                <div class="col-md-3">
                    <div class="list-group">
                        <?php
                            $link = ConectarseaBD();
                            $Result = $link->query("SELECT * FROM servicio ");
                            $link->close();

                            for($i=0; $i<$Result->num_rows; $i++) {
                                $Result->data_seek($i);
                                $row = $Result->fetch_array(MYSQLI_ASSOC);

                                $NomServicio = $row["serv_nombre"];
                                $Price = $row["serv_precioBase"];
                                echo <<<_Init
                                    <a class="list-group-item " data-value="$i"> 
                                        <div class="row">
                                            <div class="col-md-6">$NomServicio</div>
                                            <div class="col-md-6" align="right">$Price</div>
                                        </div>
                                    </a>
_Init;
                            }
                        ?>
                        <!-- <a class="list-group-item" href="#">Enserado</a> -->
                    </div>
                </div>
            </div>
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
