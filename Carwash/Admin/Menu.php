
    <head>
        <title>Panel administrativo el panzas</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <?php

    /* TO DELETE THE WARNING PHP SESSION IS ALREADY BEEN STARTED  - OPTION 2 is use @session_start() */
    $user = (session_status()===PHP_SESSION_NONE) ? (session_start()): NULL;
    $user = $_SESSION["Nombre"];

    echo <<<_end
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Panel administrativo</a>
            </div>
            
            
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"> 
                          <span class="glyphicon glyphicon-user"></span> $user
                          <b class="caret"></b>   
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Mi Cuenta</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="glyphicon glyphicon-wrench">&nbsp;</i>Preferencias</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-th-list">&nbsp;</i>Historial</a></li>
                        <li class="divider"></li>
                        <li><a href="../EliminarSession.php"><i class="glyphicon glyphicon-off">&nbsp;</i> Salir </a>
                       </li>
                    </ul>
                </li>
            </ul>
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="Index.php"><i class="fa fa-fw fa-dashboard"></i> Panel </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-car fa-table"></i> Servicios <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="AgregarServicio.php">Agregar servicios</a>
                            </li>
                            <li>
                                <a href="ModificarServicio.php">Modificar servicios</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo3"><i class="fa fa-gift"></i> Promociones <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="demo3" class="collapse">
                                <li>
                                    <a href="#">Ver Promociones</a>
                                </li>
                                <li>
                                    <a href="AgregarPromociones.php">Agregar promocion</a>
                                </li>
                            </ul>
                    </li>
                    <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="fa fa-users fa-edit"></i> Clientes <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="demo4" class="collapse">
                                <li>
                                    <a href="VerClientes.php">Ver Clientes</a>
                                </li>
                            </ul>
                    </li>
                    <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-user"></i> Empleados <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo2" class="collapse">
                            <li>
                                <a href="VerEmpleados.php">Ver empleados</a>
                            </li>
                            <li>
                                <a href="IngresarEmpleado.php">Agregar empleados</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demoo"><i class="glyphicon glyphicon-usd"></i> Caja <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demoo" class="collapse">
                            <li>
                                <a href="VerCaja.php">Caja</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="../Index.php"><i class="fa fa-user fa-desktop"></i> Vista de la página</a>
                    </li>
                    
                    
                   
                </ul>
            </div>
    </nav>
_end;
    ?>



