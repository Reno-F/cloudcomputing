<?php
require __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

$firebaseCredentialsPath = __DIR__ . '/../firebase_credentials.json';

if (!file_exists($firebaseCredentialsPath)) {
    die("Firebase credentials file not found.");
}

$serviceAccount = json_decode(file_get_contents($firebaseCredentialsPath), true);

if (!$serviceAccount) {
    die("Invalid Firebase credentials.");
}


$factory = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://cloudcomputing-f7ce8-default-rtdb.asia-southeast1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
