<?php


DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'projektopia');


$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!$link){
    echo "Napaka: Neuspešna povezava na MySQL bazo"+PHP_EOL;
    echo "Definicija napake: ".mysqli_connect_errno();
    exit;
}else{
    mysqli_set_charset($link, 'utf-8');
}
?>