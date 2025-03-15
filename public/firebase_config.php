<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
    ->withServiceAccount(__DIR__ . '/firebase_credentials.json')
    ->withDatabaseUri('https://cloudcomputing-f7ce8-default-rtdb.asia-southeast1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth(); // Tambahkan autentikasi Firebase

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
