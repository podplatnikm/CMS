<?php


define('EMAIL', 'miha.podplatnik@gmail.com');

define('BASE_URL', 'http://localhost/DSR_projekt/');

define('MYSQL', '/inc/mysqli_connector.php');

date_default_timezone_set ('Europe/Ljubljana');

/*function error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) {

    // ustvarjanje sporočila o napakah
    $message = "Napaka v datoteki '$e_file' v vrstici $e_line: $e_message\n";

    // dodajenje datuma in časa
    $message .= "Datum/Čas: " . date('n-j-Y H:i:s') . "\n";

    if (!LIVE) { // izpis napak - v postopku razvoja

        // izpis napak - pri razvoju
        echo '<div class="error">' . nl2br($message);

        // dodajenje podrobnosti o napakah
        echo '<pre>' . print_r ($e_vars, 1) . "\n";
        debug_print_backtrace();
        echo '</pre></div>';

    } else { // preprečevanje izpisa napak - ko splavimo stran

        // pošiljanje e-mail sporočila adminu
        //$body = $message . "\n" . print_r ($e_vars, 1);
        //mail(EMAIL, 'Site Error!', $body, 'From: marko.holbl@um.si');

        // splošen izpis napake
        if ($e_number != E_NOTICE) {
            echo '<div class="error">A system error occurred. We apologize for the inconvenience.</div><br />';
        }
    }

}*/

//set_error_handler(error_handler());

?>