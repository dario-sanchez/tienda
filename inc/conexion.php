<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale (LC_ALL,'es_MX.UTF-8');
$mysqli = new mysqli("mysql.tsplus.mx", "tsplus_tienda", "tsplus.Tienda.2024", "tsplus_tienda");