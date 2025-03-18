<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

$firebaseCredentials = getenv('FIREBASE_CREDENTIALS');

if (!$firebaseCredentials) {
    die("Firebase credentials not set in environment variables.");
}

$serviceAccount = json_decode($firebaseCredentials, true);

if (!$serviceAccount) {
    die("Invalid Firebase credentials.");
}

$factory = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://cloudcomputing-f7ce8-default-rtdb.asia-southeast1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
?>
