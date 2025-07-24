<?php
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
setlocale (LC_ALL,'es_MX.UTF-8');


require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => env('DB_CONNECTION'),
    'host'      => env('DB_HOST'),
    'port'      => env('DB_PORT'),
    'database'  => env('DB_DATABASE'),
    'username'  => env('DB_USERNAME'),
    'password'  => env('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();