<?php
include 'firebase_config.php';

if (isset($_GET['id'])) {
    $key = $_GET['id'];
    $database->getReference('users/'.$key)->remove();
    header('Location: index.php');
}
?>
