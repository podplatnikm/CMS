<?php
require ('inc/config.php');
session_start();
/**
 * Created by PhpStorm.
 * User: Miha
 * Date: 29.12.2016
 * Time: 17:10
 */
if (!isset($_SESSION['id_skrbniki'])) {

    $url = BASE_URL . 'login.php';
    ob_end_clean();
    header("Location: $url");
    exit();

}else{
    $_SESSION = array(); // izbris sejnih spremenljivk
    session_destroy(); // uničevanje seje
    setcookie (session_name(), '', time()-3600); // izbris piškotkov
    $url = BASE_URL . 'index.php';
    ob_end_clean();
    header("Location: $url");
    exit();
}