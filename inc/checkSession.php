<?php
setlocale (LC_ALL,'es_MX.UTF-8');
session_start();
$currentPag = basename($_SERVER['PHP_SELF']);
$noLog = [
    'login.php',
    'recuperar.php',
    'registro.php',
];
// echo in_array($currentPag, $noLog);
if ( !isset( $_SESSION['usuario_email'] ) && !isset( $_SESSION['usuario_id'] ) ) {
    if( !in_array($currentPag, $noLog) ) header("Location: /tienda/login.php");
} else {
    if( in_array($currentPag, $noLog) )  header("Location: /tienda/");
}
