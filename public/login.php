<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Login page is running...<br>";
session_start();
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Form submitted...<br>";
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $uid = $signInResult->firebaseUserId();
        $userData = $db->getReference('users/'.$uid)->getValue();

        if ($userData) {
            if (!$userData['verified']) {
                echo "Akun belum diverifikasi.<br>";
                exit();
            }

            $_SESSION['user'] = $userData;
            $_SESSION['user']['uid'] = $uid;
            echo "Login berhasil, redirecting...<br>";
            header('Location: index.php');
            exit();
        } else {
            echo "User tidak ditemukan.<br>";
        }
    } catch (Exception $e) {
        echo "Login gagal: " . $e->getMessage();
    }
}
?>
