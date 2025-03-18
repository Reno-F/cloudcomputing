<?php
include 'firebase_config.php';
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $userRef = $db->getReference('users/'.$uid);
    $userData = $userRef->getValue();
    if ($userData) {
        $userRef->update(['verified' => true]);
        echo "Email Anda telah diverifikasi. Silakan login.";
    } else {
        echo "Akun tidak ditemukan.";
    }
}
?>