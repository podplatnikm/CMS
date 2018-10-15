<?php
require ('inc/config.php');
session_start();
require (MYSQL);

/*
 * Prevejramo, če je uporabnik sploh prijavljen
 */
if (!isset($_SESSION['id_skrbniki'])) {

    $url = BASE_URL . 'login.php';
    ob_end_clean();
    header("Location: $url");
    exit();

}

mysqli_set_charset($link, "utf8");
/*
 * Za izpis v nabor sodelujocih
 */
$query_get_sodelujoci = "SELECT id_sodelujoci, ime, priimek FROM projektopia.sodelujoci;";
$resultSet_get_sodelujoci = mysqli_query($link, $query_get_sodelujoci) or trigger_error("Query: $query_get_sodelujoci\n<br />MySQL Error: " . mysqli_error($link));


$msg = FALSE;
$msg_error = FALSE;

if (isset($_POST['_METHOD'])) {

    if ($_POST['_METHOD'] == 'POST_PRO') {



        //predvidevamo vse neveljavne
        $naizv = FALSE;
        $slika = FALSE;
        $narocnik = FALSE;
        $opis_resitve = FALSE;
        $datumZacekta = FALSE;
        $datumKonca = FALSE;
        $link_resitve = FALSE;

        /*
         * Preverjamo naziv projekta
         */
        if(isset($_POST['naziv'])){
            $naziv = mysqli_real_escape_string($link, $_POST['naziv']);
        }else{
            $naziv = FALSE;
            $msg_error = " Pozabili ste vpisati naziv!";
        }

        /*
         * Preverjamo sliko projekta
         */
        if($_FILES['grafika']['size'] < 3*1024*1024){
            $fileName = $_FILES['grafika']['name'];
            $tmpName = $_FILES['grafika']['tmp_name'];


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

        /*
         * Preverjamo naročnika
         */
        if(isset($_POST['narocnik'])){
            $narocnik = mysqli_real_escape_string($link, $_POST['narocnik']);
        }else{
            $narocnik = FALSE;
            $msg_error = " Pozabili ste vpisati Naročnika!";
        }

        /*
         * Preverjamo opis rešitve
         */
        if(!empty($_POST['opis_resitve'])){
            $opis_resitve = mysqli_real_escape_string($link, $_POST['opis_resitve']);
        } else {
            $msg_error = "Pozabili ste vpisati Opis Rešitve!";
        }

        /*
         * Preverjamo datum začetka projekta
         */
        if(isset($_POST['izbiraDatumaZacetka'])){
            $tempdatumZacekta = mysqli_real_escape_string($link, $_POST['izbiraDatumaZacetka']);
            $datumZacekta = date("Y-m-d",strtotime($tempdatumZacekta));
        }else{
            $datumZacekta = FALSE;
            $msg_error = " Pozabili ste izbrati Datum Začetka Projekta!";
        }

        /*
         * Preverjamo datum konca projekta
         */
        if(isset($_POST['izbiraDatumaKonca'])){
            $tempDatumKonca = mysqli_real_escape_string($link, $_POST['izbiraDatumaKonca']);
            $datumKonca = date("Y-m-d",strtotime($tempDatumKonca));
        }else{
            $datumKonca = FALSE;
            $msg_error = " Pozabili ste izbrati Datum Konca Projekta!";
        }

        /*
         * Preverjamo link resitve projekta
         */
        if(isset($_POST['resitev'])){
            $link_resitve = mysqli_real_escape_string($link, $_POST['resitev']);
        }else{
            $link_resitve = FALSE;
            $msg_error = " Pozabili ste vnesti povezavo do rešitve!";
        }

        if ($narocnik && $naziv && $slika && $opis_resitve && $link_resitve && $datumKonca && $datumZacekta){


            $query_projekt = "INSERT INTO projektopia.projekt (naziv, grafika, narocnik, opis_resitve, datum_zacetka, datum_konca, resitev)
                          VALUES ('$naziv', '$content', '$narocnik', '$opis_resitve', '$datumZacekta', '$datumKonca', '$link_resitve');";
            if ($link->query($query_projekt) === TRUE) {

                $msg = TRUE;
                $idProjekta = mysqli_insert_id($link);

                if (isset($_POST['ime_stroski']) && is_array($_POST['ime_stroski'])) {
                    $velikost = count($_POST['ime_stroski']);
                    $imena_stroskov = $_POST['ime_stroski'];
                    $dejanski_stroski = $_POST['stroski'];
                    for ($i = 0; $i < $velikost; $i++) {
                        $query_strosek = "INSERT INTO projektopia.strosek (tk_idprojekt, ime, dejanski_strosek) VALUES ('$idProjekta', '$imena_stroskov[$i]', '$dejanski_stroski[$i]');";
                        if ($link->query($query_strosek) === TRUE) {
                            $msg = TRUE;
                        } else {
                            $msg = FALSE;
                            $msg_error = "Težava pri vnosu stroskov :(";
                            break;
                        }
                    }
                }
                if (isset($_POST['ure']) && is_array($_POST['ure'])) {
                    $stevilo_sodelujocih = count($_POST['ure']);
                    $value_imena = $_POST['value_ime'];
                    $ure = $_POST['ure'];
                    $nazivi_dela = $_POST['naziv_dela'];

                    for ($j = 0; $j < $stevilo_sodelujocih; $j++) {
                        $query_vnos_sodelujocih_na_projektu = "INSERT INTO projektopia.projekt_sodelujoci 
                        (tk_idprojekt, tk_idsodelujoci, stevilo_ur, naziv_dela) 
                        VALUES ('$idProjekta', '$value_imena[$j]', '$ure[$j]', '$nazivi_dela[$j]');";

                        if($link ->query($query_vnos_sodelujocih_na_projektu) === TRUE){
                            $msg = TRUE;
                        }else{
                            $msg = FALSE;
                            $msg_error = "Težava pri vnosu sodelujocih na projetk :(";
                            break;
                        }
                    }
                }
            }else {
                echo "Error: " . $query_projekt . "<br>" . $link->error;
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

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>

    <script src="js/jquery.browser.js" ></script>

    <link rel="stylesheet" type="text/css" media="all"
          href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/smoothness/jquery-ui.css"

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


    <!--DATE PICKER -->
    <!-- date picker -->


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
                <li class="active">
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
                        Vnos novih projektov
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
                <form action="admin_add_projekt.php" method="post" role="form" enctype="multipart/form-data">
                <div class="col-lg-5">

                    <div class="form-group">
                        <label for="Naziv">Naziv oziroma ime projekta</label>
                        <input type="text" class="form-control" name="naziv" placeholder="Vnesite naziv" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="grafika">Predstavitvena slika/grafika (do 3MB, naj bo 800x500 px)</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
                        <input type="file" class="form-control" name="grafika" placeholder="Izberite sliko" onchange="ValidateSingleInput(this);" required>
                    </div>

                    <div class="form-group">
                        <label for="narocnik">Polno ime naročnika projekta</label>
                        <input type="text" class="form-control" name="narocnik" placeholder="Vnesite naziv naročnika" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="opis_resitve">Opis (problema/rešitve)</label>
                        <textarea class="form-control" name="opis_resitve" rows="4" required></textarea>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="izbiraDatumaZacetka">Datum začetka projekta</label>
                            <input type="text" class="form-control"  name="izbiraDatumaZacetka" id="izbiraDatumaZacetka" placeholder="Datum začetka"
                                   required/>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="izbiraDatumaKonca">Datum konca projekta</label>
                            <input type="text" class="form-control" name="izbiraDatumaKonca" id="izbiraDatumaKonca" placeholder="Datum konca" required
                                   />

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="resitev">Povezava na rešitev (spletna stran, program, video)</label>
                        <input type="text" class="form-control" name="resitev" placeholder="Vnesite link do rešitve" required>
                    </div>


                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <label for="izbSod">Izberite in dodajte sodelujoče</label>
                        <select class="form-control-static" id="izbSod" name="izbSod" required>
                            <?php
                            while($row = $resultSet_get_sodelujoci ->fetch_array()){
                                echo "<option value='".$row['id_sodelujoci']."'>".$row['ime']." ".$row['priimek']."</option>";

                            }
                            ?>
                        </select>
                        <a href="#" class="btn btn-success add_field_button">+</a>

                        <div class="table-responsive">
                        <table class="table table-bordered table-hover input_fields_wrap">
                            <tr>
                                <th>Ime in priimek</th>
                                <th class="col-sm-12 col-md-2">Število ur</th>
                                <th>Naziv dela</th>
                                <th>Odstranitev</th>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="stroski">Dodajte strošek</label>
                        <a href="#" class="btn btn-success add_field_strosek">+</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover input_fields_strosek">
                                <tr>
                                    <th>Naziv/Ime Stroska</th>
                                    <th class="col-sm-12 col-md-3">Dejanski strosek (€)</th>
                                    <th class="col-sm-12 col-md-3">Odstranitev</th>
                                </tr>
                            </table>
                        </div>
                        <b>Skupni Strosek:</b> <div class="vsota_stroski btn btn-sm btn-info" >0 €</div>
                    </div>
                </div>
                    <div class="col-lg-12 text-center">

                    <input type="hidden" name="_METHOD" value="POST_PRO" />
                    <input class="btn btn-primary btn-lg" type="submit" value="*** VNESITE PROJEKT ***" />
                    </div>
                </form>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Date picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

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
<script>
    $(document).ready(function() {
        var max_fields      = 50; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID


        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var ime            = $("#izbSod").find("option:selected" ).text();
                var value_od_ime    = $("#izbSod").val();
                $(wrapper).append('<tr><td>'+ime+'<input type="hidden" name="value_ime[]" value="'+ value_od_ime +'" /> </td><td>' +
                    '<input type="number" class="form-control " name="ure[]" required/>' +
                    '</td><td>' +
                    '<input type="text" class="form-control " name="naziv_dela[]" required/>' +
                    '</td><td><a href="#" class="btn-danger btn" onClick="$(this).closest(\'tr\').remove();">Odstrani Kolega</a></td> </tr>');
                //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });

</script>
<script>
    $(document).ready(function() {
        var max_fields1      = 50; //maximum input boxes allowed
        var wrapper1         = $(".input_fields_strosek"); //Fields wrapper
        var add_button1      = $(".add_field_strosek"); //Add button ID


        var x = 1; //initlal text box count
        $(add_button1).click(function(e1){ //on add input button click
            e1.preventDefault();
            if(x < max_fields1){ //max input box allowed
                x++; //text box increment
                $(wrapper1).append('<tr>' +
                    '<td><input type="text" class="form-control" name="ime_stroski[]" required /></td>' +
                    '<td>' +
                    '<div class="form-group input-group"><span class="input-group-addon"><i class="fa fa-eur"></i></span>' +
                    '<input type="number" class="form-control stroski" name="stroski[]" required/></div></td>' +
                    '<td><a href="#" class="btn-danger btn" onclick="$(this).closest(\'tr\').remove();">Odstrani strosek</a></td>' +
                    '</tr>');
                //add input box
            }
        });

        $(wrapper1).on("click",".remove_field", function(e){ //user click on remove text
            e1.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });

</script>
<script>

    $(document).on("change", ".stroski", function() {
        var sum = 0;
        $(".stroski").each(function(){
            sum += +$(this).val();
        });
        $("div.vsota_stroski").html(sum+" €");
    });

</script>
<script>
    $( function() {
        $("#izbiraDatumaKonca" ).datepicker({
            dateFormat : "dd-mm-yy",
            weekStart : 1,
            startDate : "-Infinity",
            language : "sl",
            autoclose : true,
            todayHighlight : true,
            orientation: "bottom auto"
        });
        $("#izbiraDatumaZacetka").datepicker({
            dateFormat : "dd-mm-yy",
            weekStart : 1,
            startDate : "-Infinity",
            language : "sl",
            autoclose : true,
            todayHighlight : true,
            rientation: "top auto"
        });
    } );



</script>

</body>

</html>
