<?php
require('inc/config.php');
require('inc/header.php');
require(MYSQL);

mysqli_set_charset($link, "utf8");






$start = 0;
$limit = 4;
$FLAG_prva_stran = TRUE;
$stran = 1;
if(isset($_GET['stran'])){
    if($_GET['stran'] < 1 || $_GET['stran'] > 10){
        $url = BASE_URL;
        ob_end_clean();
        header("Location: $url");
        exit();
    }else if($_GET['stran'] == 1){
        $FLAG_prva_stran = TRUE;
        $stran = 1;
        $limit = 4;
        $start =($stran-1)*$limit;
    }else{
        $FLAG_prva_stran = FALSE;
        $stran=$_GET['stran'];
        $limit = 8;
        $start=(($stran-1)*$limit)-4;

    }
}

$query_get_vse_sodelujoce = "CREATE OR REPLACE VIEW vsi_sodelujoci AS
SELECT tk_idprojekt ,COUNT(*) as stevilo_sodelujocih
FROM projektopia.projekt_sodelujoci
GROUP BY tk_idprojekt;";

$query_get_projekti = "SELECT idprojekt, naziv, grafika, narocnik, datum_konca, stevilo_sodelujocih
FROM projektopia.projekt, vsi_sodelujoci
WHERE idprojekt = tk_idprojekt
ORDER BY datum_konca DESC
LIMIT $limit OFFSET $start;";

if ($link->query($query_get_vse_sodelujoce) === TRUE){
    $resultSet_get_projekti = mysqli_query($link, $query_get_projekti) or
    trigger_error("Query: $query_get_projekti\n<br />MySQL Error: " . mysqli_error($link));
}
?>

<!-- Page Content -->
<div class="container">

    <!-- Jumbotron Header -->
    <?php
    if($FLAG_prva_stran){
    ?>
        <header class="jumbotron hero-spacer">
            <h1>Dobrodošli</h1>
            <p>PROJEKTopia je spletna rešitev za pregledovanje opravljenih projektov, razvit pri predmetu Dinamične spletn rešitve. </p>

        </header>
    <?php
    }
    ?>
    <hr>

    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3>Najnovejši projekti</h3>
        </div>
    </div>
    <!-- /.row -->

    <!-- Page Features -->
    <div class="row text-center" >


        <?php
        while($row = $resultSet_get_projekti -> fetch_array()){
            echo "<div class=\"col-md-3 col-sm-6 hero-feature\">";
                echo "<div class=\"thumbnail\">";
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['grafika'] ).'"/>';
                    echo "<div class=\"caption\">";
                        echo "<table class='table table-striped'>";
                        echo "<tr><th class='text-center' height=\"60\">". $row['naziv'] ."</th></tr>";
                        echo "<tr><td height=\"60\">";
                            echo "Naročnik: <i>" . $row['narocnik'] . "</i>";
                        echo "</tr></td>";
                        echo "<tr><td>";
                            echo "Stevilo sodelujocih: " .$row['stevilo_sodelujocih'];
                        echo "</tr></td>";
                        echo "<tr><td>";
                            echo "<a href='projekti.php?p=" . $row['idprojekt']  ."' class='btn btn-primary'>Poglej podrobno</a>";
                        echo "</tr></td>";
                        echo "</table>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }

        echo "<div class=\"col-lg-12\">";

        if($stran>1){
            echo "<a href='index.php?stran=".($stran-1)."' class='btn btn-info btn-xs'>PREJŠNJA</a>";
        }else if($stran == 1){
            echo "<a href='#' class='btn btn-info disabled btn-xs'>PREJŠNJA</a></li>";
        }
            echo "&#8231;";
        if($stran < 10){
            echo "<a href='index.php?stran=".($stran+1)."' class='btn btn-info btn-xs'>NASLEDNJA</a>";
        }else{
            echo "<a href='#' class='btn btn-info disabled btn-xs'>NASLEDNJA</a></li>";
        }

        echo "</div>";
        ?>

    </div>


<?php
    require ('inc/footer.php');
?>

