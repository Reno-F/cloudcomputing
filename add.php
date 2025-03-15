<?php
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    

    $data = [
        'name' => $name,
        'email' => $email,
        'gender' => $gender,
        'phone' => $phone
    ];

    $database->getReference('users')->push($data);
    header('Location: index.php');
}
?>
