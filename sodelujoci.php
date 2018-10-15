<?php
require('inc/config.php');
$page_title = 'Ogled sodelujocih - PROJEKTopia';
require('inc/header.php');
require(MYSQL);

mysqli_set_charset($link, "utf8");

$FLAG_POLN_POGLED = FALSE;
$FLAG_NEOBSTAJA_SODELUJOC = TRUE;


if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];

    $query_get_sodelujoci = "SELECT id_sodelujoci, ime, priimek, slika, cv, opombe, COUNT(*) as stevilo_projektov 
                              FROM projektopia.sodelujoci, projektopia.projekt_sodelujoci
                              WHERE id_sodelujoci = $id
                              AND id_sodelujoci = tk_idsodelujoci;";

    $query_get_karakteristike ="SELECT id_sodelujoci, id_karakteristike, keyword, prednost, ime, priimek
                                FROM projektopia.sodelujoci, projektopia.karakteristike, projektopia.karakteristike_sodelujoci
                                WHERE id_sodelujoci = $id
                                AND id_sodelujoci = tk_id_sodelujoci
                                AND tk_id_karakteristike = id_karakteristike;";

    $guery_get_projekte = "SELECT ime, priimek, naziv, naziv_dela, stevilo_ur, idprojekt
                            FROM projektopia.projekt, projektopia.projekt_sodelujoci, projektopia.sodelujoci
                            WHERE id_sodelujoci = tk_idsodelujoci
                            AND tk_idprojekt = idprojekt
                            AND id_sodelujoci = $id;";

    $RS_get_sodelujoci = mysqli_query($link, $query_get_sodelujoci);
    $row_dev = $RS_get_sodelujoci ->fetch_array();
    if($row_dev['id_sodelujoci'] != NULL ){
        $FLAG_NEOBSTAJA_SODELUJOC = FALSE;

        $RS_get_kar = $link -> query($query_get_karakteristike);


        $RS_get_projekt = $link -> query($guery_get_projekte);


    }else{
        $FLAG_NEOBSTAJA_SODELUJOC = TRUE;
    }





}

if (isset($_SESSION['id_skrbniki'])) {
    $FLAG_POLN_POGLED = TRUE;
}
?>

<!-- Page Content -->
<div class="container">

    <!-- Title -->
    <div class="row">
        <?php
        if($FLAG_NEOBSTAJA_SODELUJOC){
        ?>
            <div class="col-md-4 col-md-offset-4 text-center">
                    <h1><b>NAPAKA #</b></h1>
                    <p>Iskan developer ni bil najden :(</p>
                    <a href="<?php echo  $_SERVER['HTTP_REFERER']  ?>" class="btn btn-info btn-xs">Vrni me nazaj</a>
                </div>
            <?php
        }else{
            ?>

            <div class="col-lg-12 text-center">
                <div class="col-lg-4 text-right">
                    <img src="data:image/jpeg;base64,<?php echo(base64_encode($row_dev['slika'])); ?>"
                         style="border: 1px solid #1a242f; max-width:400px; max-height: 300px"/>
                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-7 text-left">
                    <h3><b><?php echo strtoupper($row_dev['ime']) . " " . strtoupper($row_dev['priimek']) ?></b></h3>
                    <ul>
                        <li >
                            <i class="text-info">Življene(opis): </i><small>
                            <?php echo $row_dev['cv'];?></small>
                        </li>
                        <br />
                        <?php
                        if($FLAG_POLN_POGLED){
                            echo "<li >";
                                echo "<i class=\"text-warning\">Opombe: </i>";
                                echo $row_dev['opombe'];
                            echo "</li>";
                            echo "<br />";
                        }
                        ?>
                        <li>
                            <i class="text-info">Število opravljenih projektov: </i>
                            <?php echo $row_dev['stevilo_projektov'] ?>
                        </li>
                    </ul>

                </div>

            </div>

            <hr style="width: 100%; color: black; height: 1px;" />

            <div class="col-lg-12">
                <div class="col-lg-4">
                    <div class="col-md-12 text-center">
                        <h4> - KARAKTERISTIKE -</h4>
                    </div>
                    <div class="col-lg-6">
                        <span class="btn btn-success btn-xs center-block">+</span>
                        <ul>
                            <?php
                            $neg_kar = array();
                            while ($row_kar = $RS_get_kar->fetch_array()) {
                                if ($row_kar['prednost'] == 1) {
                                    echo "<li class='text-success disabled'>";
                                    echo $row_kar['keyword'];
                                    echo "</li>";
                                } else {
                                    array_push($neg_kar, $row_kar);
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-lg-6 ">
                        <span class="btn btn-danger btn-xs center-block">-</span>
                        <ul>
                            <?php
                            foreach ($neg_kar as $temp_row) {
                                if ($temp_row['prednost'] == 0) {
                                    echo "<li class='text-danger disabled'>";
                                    echo $temp_row['keyword'];
                                    echo "</li>";
                                }
                            }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-1">
                    </div>
                <div class="col-lg-7">
                    <div class="col-md-12 text-center">
                        <h4> - OPRAVLJENI PROJEKTI - </h4>
                    </div>
                    <div class="col-lg-12">
                        <ol>
                            <?php
                            while ($row_pro = $RS_get_projekt->fetch_array()) {
                                echo "<li>";
                                    echo "<b>" . $row_pro['naziv'] ."</b> , delo: '" . $row_pro['naziv_dela'] . "'";
                                    if($FLAG_POLN_POGLED){
                                        echo " , število ur: ";
                                        echo $row_pro['stevilo_ur'];
                                    }
                                         echo"    <a href='projekti.php?p=" . $row_pro['idprojekt'] . "' class='label label-primary'> --> na Projekt</a>";

                                echo "</li>";
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>


            <?php
        }

        ?>
    </div>
    <!-- /.row -->

    <?php
    require ('inc/footer.php');
    ?>

