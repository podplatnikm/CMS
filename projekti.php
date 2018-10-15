<?php
require('inc/config.php');
$page_title = 'Ogled projekta - PROJEKTopia';
require('inc/header.php');
require(MYSQL);

mysqli_set_charset($link, "utf8");

$FLAG_POLN_POGLED = FALSE;
$FLAG_NEOBSTAJA_PROJEKT;
$row;
$row_sodelujoci;
/*
 * Prevejramo, če je uporabnik sploh prijavljen
 */

if(isset($_GET['p']) && is_numeric($_GET['p'])){
    $id = $_GET['p'];
    $query_get_stroski = "CREATE OR REPLACE VIEW vsi_stroski AS
                            SELECT tk_idprojekt ,SUM(dejanski_strosek) as stroski
                            FROM projektopia.strosek
                            GROUP BY tk_idprojekt;";

    $query_get_projekt = "SELECT idprojekt, naziv, grafika, opis_resitve, narocnik, datum_zacetka, datum_konca, resitev, stroski
                          FROM projektopia.projekt, vsi_stroski
                          WHERE idprojekt = tk_idprojekt
                          AND idprojekt = $id;";

    if ($link->query($query_get_stroski) === TRUE){
        $resultSet_get_projekt = mysqli_query($link, $query_get_projekt) or
        trigger_error("Query: $query_get_projekt\n<br />MySQL Error: " . mysqli_error($link));
        if(mysqli_num_rows($resultSet_get_projekt) == 0){
            $FLAG_NEOBSTAJA_PROJEKT = TRUE;
        }else{
            $FLAG_NEOBSTAJA_PROJEKT = FALSE;
            $row = $resultSet_get_projekt -> fetch_array();

            $query_get_sodelujoce = "SELECT ime, priimek, slika, id_sodelujoci, naziv_dela, stevilo_ur
                                    FROM projektopia.sodelujoci, projektopia.projekt_sodelujoci
                                    WHERE tk_idsodelujoci = id_sodelujoci
                                    AND tk_idprojekt = $id;";

            $resultSet_get_sodelujoce = mysqli_query($link, $query_get_sodelujoce) or
            trigger_error("Query: $query_get_sodelujoce\n<br />MySQL Error: " . mysqli_error($link));

        }
    }


}else{
    $FLAG_NEOBSTAJA_PROJEKT = TRUE;
}

if (isset($_SESSION['id_skrbniki'])) {
    $FLAG_POLN_POGLED = TRUE;
    $query_get_stroski = "SELECT * FROM projektopia.strosek
                          WHERE tk_idprojekt = $id;";

    $resultSet_get_stroski = mysqli_query($link, $query_get_stroski) or
    trigger_error("Query: $query_get_stroski\n<br />MySQL Error: " . mysqli_error($link));

}
?>

<!-- Page Content -->
<div class="container">

    <!-- Title -->
    <div class="row">
        <?php
        if($FLAG_NEOBSTAJA_PROJEKT){
            ?>

                <div class="col-md-4 col-md-offset-4 text-center">
                    <h1><b>NAPAKA #</b></h1>
                    <p>Iskan projekt ni bil najden :(</p>
                    <a href="index.php" class="btn btn-info btn-xs">Vrni me nazaj</a>
                </div>

            <?php
        }else{
        ?>

            <div class="col-lg-5 ">
                <h2><?php echo $row['naziv']; ?></h2>
                <p>
                    <?php echo $row['opis_resitve']; ?>
                </p>
            </div>
            <div class="col-lg-7">
                <p>
                    <img src="data:image/jpeg;base64,<?php echo(base64_encode($row['grafika'])); ?>" style="border: 1px solid #1a242f; max-width:500px;"/>
                </p>
            </div>


            <div class="col-lg-12 text-center">
                <h4>LINK DO REŠITVE: <a href="<?php echo $row['resitev']; ?>" target="_blank" class="btn btn-info btn-xs"><?php echo $row['resitev']; ?></a></h4>
            </div>

            <hr style="width: 100%; color: black; height: 1px;" />

            <div class="col-lg-4 text-center">
            <h4>Datum začetka:</h4>
                <?php
                $datum = strtotime($row['datum_zacetka']);
                echo "<h6>" . date("d.m.y", $datum) . "</h6>"
                ?>
            </div>
            <div class="col-lg-4 text-center">
            <h4>Datum konca:</h4>
                <?php
                $datum = strtotime($row['datum_konca']);
                echo "<h6>" . date("d.m.y", $datum) . "</h6>"
                ?>
            </div>
            <div class="col-lg-4 text-center">
            <h4>Skupni strošek: </h4>
                <?php
                echo "<h6>" . $row['stroski'] . " €</h6>"
                ?>
            </div>

            <hr style="width: 100%; color: black; height: 1px;" />
            <div class="text-center">
                <h4>- SODELUJOČI -</h4>
            </div>
            <div class="col-lg-12">

                <?php
                while($row_sodelujoci = $resultSet_get_sodelujoce -> fetch_array()){


                echo "<div class='col-lg-3 text-center'>";

                    echo "<h4>" . $row_sodelujoci['ime'] . " " . $row_sodelujoci['priimek'] ."</h4>";
                    echo "<p class='text-center'>";
                    echo '<img style="max-height: 50px;" src="data:image/jpeg;base64,'.base64_encode( $row_sodelujoci['slika'] ).'"/>';
                    echo "</p>";
                    echo "Naziv dela: ";
                    echo "<i>".$row_sodelujoci['naziv_dela']."</i>";
                    if($FLAG_POLN_POGLED){
                        echo "<p>";
                        echo "Število opravljenih ur: ";
                        echo "<i>" . $row_sodelujoci['stevilo_ur'] . "</i>";
                        echo "</p>";
                    }
                    echo "<p>";
                    echo "<a href=sodelujoci?id=". $row_sodelujoci['id_sodelujoci']." class='btn btn-warning btn-xs' >Poglej osebno</a>";
                    echo "</p>";
                echo "</div>";
                }

                if($FLAG_POLN_POGLED){
                    echo "<hr style=\"width: 100%; color: black; height: 1px;\" />";
                    echo "<div class='text-center'><h4>STROSKI - PODROBNO</h4></div>";
                    while($row_stroski = $resultSet_get_stroski -> fetch_array()){
                    echo "<div class='col-lg-2 text-center'>";
                        echo "Operativno ime: ";
                        echo "<p>";
                        echo "<i>" . $row_stroski['ime']. "</i>";
                        echo "</p>";
                        echo "<div class='btn btn-danger btn-sm'>" . $row_stroski['dejanski_strosek'] . " €</div>";
                    echo "</div>";
                    }
                }
                ?>
            </div>

        <?php
        }
        ?>
    </div>
    <!-- /.row -->

    <?php
    require ('inc/footer.php');
    ?>

