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
mysqli_set_charset($link, "utf8");

$query_temp1 = "CREATE OR REPLACE VIEW vsi_sodelujoci AS
SELECT tk_idprojekt ,COUNT(*) as stevilo_sodelujocih
FROM projektopia.projekt_sodelujoci
GROUP BY tk_idprojekt;";

$query_temp2 = "CREATE OR REPLACE VIEW vsi_stroski AS
SELECT SUM(dejanski_strosek) as stroski, tk_idprojekt as tk_idprojekt2
FROM projektopia.strosek
GROUP BY tk_idprojekt2;";

$link ->query($query_temp1);
$link ->query($query_temp2);
$FLAG_NOBEN_PROJEKT = FALSE;
if (isset($_POST['_METHOD'])) {

    if ($_POST['_METHOD'] == 'POST_PRO_SPEC') {
        $query_get_projekte = "SELECT idprojekt, naziv, grafika, narocnik, datum_konca, stevilo_sodelujocih, stroski
        FROM projektopia.projekt, vsi_sodelujoci, vsi_stroski
        WHERE idprojekt = tk_idprojekt
        AND idprojekt = tk_idprojekt2
        AND naziv LIKE '%" . $_POST['iskanje'] . "%'
        ORDER BY datum_konca DESC;";
    }
}else{
    $query_get_projekte = "SELECT idprojekt, naziv, grafika, narocnik, datum_konca, stevilo_sodelujocih, stroski
FROM projektopia.projekt, vsi_sodelujoci, vsi_stroski
WHERE idprojekt = tk_idprojekt
AND idprojekt = tk_idprojekt2
ORDER BY datum_konca DESC;";
}
$RS_get_projekte = $link ->query($query_get_projekte);
if(mysqli_num_rows($RS_get_projekte) == 0){
    $FLAG_NOBEN_PROJEKT = TRUE;
}
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
                <li>
                    <a href="admin_home.php"><i class="fa fa-fw fa-dashboard"></i> Vstopna stran</a>
                </li>
                <li>
                    <a href="admin_add_participant.php"><i class="fa fa-fw fa-adn"></i> Dodaj Sodelujoče</a>
                </li>
                <li>
                    <a href="admin_add_projekt.php"><i class="fa fa-fw fa-archive"></i> Dodaj Projekt</a>
                </li>
                <li class="active">
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
                        Brskanje med projekti
                        <small>za podrobno iskanje vnesite ključno besedo (poizvedovanje po NAZIVu)</small>
                    </h1>
                    <form action="admin_projekti.php" method="post" role="form">
                        <div class="col-lg-6">
                            <label for="iskanje">Iskanje po projektih</label>
                            <input type="text" class="form-control" name="iskanje" placeholder="Vnesite kljucno besedo">
                        </div>
                        <div class="col-lg-2">
                            <div style="height: 24px;">
                                <label for="Poizveduj"></label>
                            </div>
                            <input type="hidden" name="_METHOD" value="POST_PRO_SPEC"/>
                            <input class="btn btn-primary form-control" type="submit" value="Poizveduj "/>
                        </div>
                    </form>
                </div>
                <hr style="width: 100%; color: black; height: 1px;" />
                <div class="col-lg-12">
                    <?php
                    if($FLAG_NOBEN_PROJEKT){
                        echo "Najden ni bil noben taki projekt ki bi usrezal ključni besedi :(";
                    }else{
                    while($row = $RS_get_projekte ->fetch_array()){
                        echo "<div class='col-lg-10'>";
                        echo "<div class=\"panel panel-default\">";
                        echo "<div class=\"panel-body\">";
                        echo strtoupper($row['naziv']) . " 	&#8594; narocnik: " . $row['narocnik'] . " 	&#8594; število sodelujocih: " . $row['stevilo_sodelujocih'] . " 	&#8594; skupni stroški: " . $row['stroski'];
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='col-lg-1'>";
                        echo "</i><a href='projekti.php?p=" . $row['idprojekt'] . "' class='btn btn-warning btn-lg'> Polni Pogled</a>";
                        echo "</div>";

                    }
                    }
                    ?>






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
