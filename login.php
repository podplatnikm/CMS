<?php
require ('inc/config.php');
$page_title = 'Login';
require ('inc/header.php');

if (isset($_POST['_METHOD'])){
    if($_POST['_METHOD'] == 'POST_LOGIN'){
    require (MYSQL); //povezava do baze

    //preverjanje uporabniškega imena
    if(!empty($_POST['up_ime'])){
        $uporabnisko_ime = mysqli_real_escape_string($link, $_POST['up_ime']);
    }else{
        $uporabnisko_ime = FALSE;
        echo '<p class="alert alert-dismissible alert-danger"> Pozabili ste vpisati uporabniško ime!</p>';
    }

    //preverjanje gesla
    if(!empty($_POST['geslo'])){
        $geslo = mysqli_real_escape_string($link, $_POST['geslo']);
    }else{
        $geslo = FALSE;
        echo '<p class="alert alert-dismissible alert-danger"> Pozabili ste vpisati geslo!</p>';
    }

    if($uporabnisko_ime && $geslo){  //Če sta oba vpisna podatka NEFalse tj. vredu

        //query z uporabniškimi podatki
        $query = "SELECT * FROM projektopia.skrbniki WHERE (username='$uporabnisko_ime' AND password=SHA1('$geslo'))";
        $resultSet = mysqli_query($link, $query) or trigger_error("Query: $query\n<br />MySQL Error: " . mysqli_error($link));

        if(@mysqli_num_rows($resultSet) == 1) {//če obstaja natanko en tak

            $_SESSION = mysqli_fetch_array($resultSet, MYSQLI_ASSOC);
            mysqli_free_result($resultSet); //sprosti spomin povezan z rezultatom poizvedovanja
            mysqli_close($link);

            $url = BASE_URL. 'admin_home.php';
            ob_end_clean(); //brisanje napak (output buffer)
            header("Location: $url");
            exit(); //konča skripto

        }else{ //Če so podatki napačni (ni takega uporabnika)
            echo '<p class="alert alert-dismissible alert-danger">Vnešeno uporabniško ime ali geslo
            je nepravilno. Poskusite znova!</p>';
        }

    }else{ //če je error
        echo '<p class="alert alert-dismissible alert-danger">Prosimo, poskusite znova!</p>';
    }
    mysqli_close($link);
}
}

?>
<div class="container">




    <div class="row">
        <div class="col-lg-12">
            <header class="jumbotron hero-spacer" style="max-width: 50%; margin: 0 auto;">
            <h3>VPIS SKRBNIKA</h3><br/>

            <form action="login.php" method="post">
                <fieldset>
                    <input type="text" placeholder="Uporabniško ime"  class="form-control" name="up_ime" size="20" maxlength="60" required
                    value="<?php if(isset($_POST['up_ime'])){
                        echo $_POST['up_ime'];
                    }else{
                        echo "";
                    }?>"

                    /><br />

                    <input type="password" class="form-control" name="geslo" size="20" maxlength="20" required placeholder="Geslo"/>

                    <input type="hidden" name="_METHOD" value="POST_LOGIN" />
                    <br />
                    <div align="center"><input type="submit" name="submit" value="Vstopi" class="btn btn-primary" /></div>
                </fieldset>
            </form>
            </header>

        </div>
    </div>


<?php
require ('inc/footer.php');
?>
