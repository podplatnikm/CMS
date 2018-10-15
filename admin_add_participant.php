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


$query1 = "SELECT * FROM projektopia.karakteristike;";
$resultSet1 = mysqli_query($link, $query1) or trigger_error("Query: $query1\n<br />MySQL Error: " . mysqli_error($link));

$msg = FALSE;
$msg_error = FALSE;
if(isset($_POST['_METHOD'])){ //če je bijo zahtevek

    if($_POST['_METHOD'] == 'POST_KAR'){ //če je bila dodana nova karekteristika

        if(isset($_POST['naziv'])){ //preverjamo naziv
            $naziv = mysqli_real_escape_string($link, $_POST['naziv']);
        }else{
            $naziv = FALSE;
            $msg_error = " Pozabili ste vpisati naziv!";
        }


        if(isset($_POST['radio'])){ //preverjamo poz/neg
            $lastnost = (int) $_POST['radio'];
        }else{
            $lastnost = FALSE;
                $msg_error = " Pozabili ste označiti lastnost!";
        }


        if($naziv != FALSE){
        $query_kar = "INSERT INTO projektopia.karakteristike (keyword, prednost) VALUES ('$naziv', $lastnost)";

        if($link -> query($query_kar) === TRUE){
            $msg = TRUE;
        }else{
            echo "Error: " . $query_kar . "<br>" . $link->error;
        }
        }

    }

    if($_POST['_METHOD'] == 'POST_SOD'){

        //predvidevamo vse neveljavne
        $ime = FALSE;
        $priimek = FALSE;
        $slika = FALSE;
        $cv = FALSE;
        $opombe = FALSE;

        //preverjanje imena
        if(!empty($_POST['ime'])){
            $ime = mysqli_real_escape_string($link, $_POST['ime']);
        }else{
            $msg_error = "Pozabili ste vpisati ime!";
        }

        if(!empty($_POST['priimek'])){
            $priimek = mysqli_real_escape_string($link, $_POST['priimek']);
        }else{
            $msg_error = "Pozabili ste vpisati priimek!";
        }

        if($_FILES['slika']['size'] < 1024*1024){
            $fileName = $_FILES['slika']['name'];
            $tmpName = $_FILES['slika']['tmp_name'];


            $fp = fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);

            if(!get_magic_quotes_gpc()){
                $fileName = addslashes($fileName);
            }

            $slika = TRUE;

        }else{
            $msg_error = "Napaka s sliko, verjetno je prevelika!";
        }

        if(!empty($_POST['cv'])){
            $cv = mysqli_real_escape_string($link, $_POST['cv']);
        } else {
            $msg_error = "Pozabili ste vpisati opis!";
        }

        if ($_POST['opombe'] == null) {
            $opombe = null;
        } else {
            $opombe = mysqli_real_escape_string($link, $_POST['opombe']);
        }

        if ($ime && $priimek && $slika && $cv) {

            $query_sod = "INSERT INTO projektopia.sodelujoci (ime, priimek, slika, cv, opombe) VALUES ('$ime', '$priimek', '$content', '$cv', '$opombe');";
            if ($link->query($query_sod) === TRUE) {
                $msg = TRUE;

                if (isset($_POST['kar']) && is_array($_POST['kar'])) {
                    $id = mysqli_insert_id($link); //id zadnjega vnesenega sodelujocega (uporabno za linkanje karakteritik in sodelujocih)
                    foreach ($_POST['kar'] as $karItem) {
                        $query_karItem = "INSERT INTO projektopia.karakteristike_sodelujoci (tk_id_sodelujoci, tk_id_karakteristike) VALUES ($id, $karItem);";
                        if ($link->query($query_karItem) === TRUE) {
                            $msg = TRUE;
                        } else {
                            $msg = FALSE;
                            $msg_error = "Težava pri vnosu karakteristik :(";
                        }
                    }
                }
            } else {
                echo "Error: " . $query_sod . "<br>" . $link->error;
            }

        }



    }
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
                <li class="active">
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
                        Vnos sodelujočih
                        <small>Vnesite in/ali izberite atribute</small>
                    </h1>

                    <?php
                    if($msg){
                        echo "<div class=\"alert alert-success\">";
                        echo "<strong>Uspeh!</strong> Novi vnos je bil pravilno vpisan v bazo!";
                        echo "</div>";
                    }

                    if($msg_error){
                        echo "<div class=\"alert alert-danger\">";
                        echo "<strong>Napaka!</strong>".$msg_error;
                        echo "</div>";
                    }
                    ?>

                </div>
                <div class="col-lg-6">
                    <form action="admin_add_participant.php" method="post" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="ime">Ime</label>
                            <input type="text" class="form-control" name="ime" placeholder="Vnesite ime" required maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="priimek">Priimek/-ki</label>
                            <input type="text" class="form-control" name="priimek" placeholder="Vnesite priimek" required maxlength="45">
                        </div>

                        <div class="form-group">
                            <label for="slika">Slika oz avatar (do 1MB)</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                            <input type="file" class="form-control" name="slika" placeholder="Izberite sliko" onchange="ValidateSingleInput(this);" required>
                        </div>

                        <div class="form-group">
                            <label for="cv">(Življenje)Opis</label>
                            <textarea class="form-control" name="cv" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="opombe">Opombe</label>
                            <textarea class="form-control" name="opombe" rows="2"></textarea>
                        </div>

                        <div class="alert alert-info">
                            <strong>Karakteristike!</strong>
                            Obkljukajte značilnosti, ki veljajo za trenutni vnos
                        </div>

                        <div class="form-group">
                            <table class="table table-bordered table-hover">
                        <?php
                        $counter = 6;
                            while($row = $resultSet1 ->fetch_array()){
                                if($counter % 5 == 1){
                                    echo "<tr>";
                                }
                                echo "<td>";
                                echo "<input type='checkbox' value='".$row['id_karakteristike']."' name='kar[]' >".$row['keyword']."</input>";
                                echo "</td>";
                                $counter++;
                            }
                        ?>
                            </table>
                        </div>
                        <input type="hidden" name="_METHOD" value="POST_SOD" />
                        <input class="btn btn-primary" type="submit" value="Dodaj" />
                    </form>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-4">

                    <h3>Nova karakterisika</h3>
                    <form action="admin_add_participant.php" method="post">
                    <div class="form-group">
                        <label for="naziv">Naziv lastnosti</label>
                        <input type="text" class="form-control" name="naziv" placeholder="Vnesite naziv" required>
                    </div>

                    <label for="magnituda">Magnituda</label>

                    <div class="form-group">
                        <div class="radio"> <label>
                        <input type="radio" name="radio" id="lastnost" value="1" checked/>
                            Pozitivna
                        </label></div>

                        <div class="radio"> <label>
                        <input type="radio" name="radio" id="lastnost" value="0"  />
                            Negativna
                        </label></div>
                    </div>
                        <input type="hidden" name="_METHOD" value="POST_KAR" />
                        <input class="btn btn-primary" type="submit" value="Dodaj" />
                    </form>
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

<script>
    var _validFileExtensions = [".png", ".jpg", ".jpeg", ".gif"];
    function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    alert("NAPAKA: " + sFileName + " je napačne vrste, dovoljene datoteke so: " + _validFileExtensions.join(", "));
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
    }
</script>

</body>

</html>
