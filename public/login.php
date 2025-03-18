<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'firebase_config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $uid = $signInResult->firebaseUserId();
        $userData = $db->getReference('users/'.$uid)->getValue();
        if ($userData) {
            if (!$userData['verified']) {
                echo "Akun belum diverifikasi. Silakan cek email Anda.";
                exit();
            }
            $_SESSION['user'] = $userData;
            $_SESSION['user']['uid'] = $uid;
            header('Location: index.php');
            exit();
        } else {
            echo "User tidak ditemukan.";
        }
    } catch (Exception $e) {
        echo "Login gagal: " . $e->getMessage();
    }
}
?>
