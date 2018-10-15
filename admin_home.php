<?php
require ('inc/config.php');
session_start();
require (MYSQL);

if (!isset($_SESSION['id_skrbniki'])) {

    $url = BASE_URL . 'login.php';
    ob_end_clean();
    header("Location: $url");
    exit();

}

$query1 = "SELECT COUNT(*) as steviloProjektov FROM projektopia.projekt;";
$resultSet1 = mysqli_query($link, $query1) or trigger_error("Query: $query1\n<br />MySQL Error: " . mysqli_error($link));
$steviloProjektov = mysqli_fetch_array($resultSet1, MYSQLI_ASSOC);

$query2 = "SELECT COUNT(*) as steviloSodelujocih FROM projektopia.sodelujoci;";
$resultSet2 = mysqli_query($link, $query2) or trigger_error("Query: $query2\n<br />MySQL Error: " . mysqli_error($link));
$steviloSodelujocih = mysqli_fetch_array($resultSet2, MYSQLI_ASSOC);

$query3 = "SELECT COUNT(*) as steviloKarakteristik FROM projektopia.karakteristike;";
$resultSet3 = mysqli_query($link, $query3) or trigger_error("Query: $query3\n<br />MySQL Error: " . mysqli_error($link));
$steviloKarakteristik = mysqli_fetch_array($resultSet3, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="img/ikona3.ico" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PROJEKTopia - Skrbniški pogled</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap_admin.css" rel="stylesheet">

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

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="admin_home.php">PROJEKTopia Admin Panel</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['ime']." ".$_SESSION['priimek']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-home"></i>Izhod iz plošče</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="admin_home.php"><i class="fa fa-fw fa-dashboard"></i> Vstopna stran</a>
                </li>
                <li>
                    <a href="admin_add_participant.php"><i class="fa fa-fw fa-adn"></i> Dodaj Sodelujoče</a>
                </li>
                <li>
                    <a href="admin_add_projekt.php"><i class="fa fa-fw fa-archive"></i> Dodaj Projekt</a>
                </li>
                <li>
                    <a href="admin_projekti.php"><i class="fa fa-fw fa-bullseye"></i> Ogled vseh Projektov</a>
                </li>
                <li>
                    <a href="admin_sodelujoci.php"><i class="fa fa-fw fa-pencil"></i> Ogled vseh Sodelujocih</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Dobrodošli v administracijskem panelu <?php echo $_SESSION['ime']." ".$_SESSION['priimek'] ?>
                        <small>Vstopna stran</small>
                    </h1>

                    <!-- IZPIS STEVILA PROJEKTOV -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">

                                            <?php echo $steviloProjektov['steviloProjektov']; ?>

                                        </div>
                                        <div>Število projektov</div>
                                    </div>
                                </div>
                            </div>
                            <a href="admin_projekti.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Poglej podrobno</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- IZPIS STEVILA SODELUJOCIH -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">

                                            <?php echo $steviloSodelujocih['steviloSodelujocih'] ?>

                                        </div>
                                        <div>Skupno število sodelujočih</div>
                                    </div>
                                </div>
                            </div>
                            <a href="admin_sodelujoci.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Poglej podrobno</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- IZPIS STEVILA KARAKTERISTIK -->
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">

                                            <?php echo $steviloKarakteristik['steviloKarakteristik'] ?>

                                        </div>
                                        <div>Število Karakteristik na izbiro</div>
                                    </div>
                                </div>
                            </div>
                            <a href="admin_add_participant.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Poglej podrobno</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    </div>
            </div>
            <!-- /.row -->

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

</body>

</html>
