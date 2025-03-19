<?php
include 'firebase_config.php';

if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];
    
    // Ambil semua user untuk mencari kode verifikasi
    $usersRef = $database->getReference('users')->getValue();
    $found = false;

    if ($usersRef) {
        foreach ($usersRef as $uid => $userData) {
            if (isset($userData['verification_code']) && $userData['verification_code'] === $verificationCode) {
                // Update status verifikasi
                $database->getReference('users/'.$uid.'/is_verified')->set(true);
                $found = true;
                break;
            }
        }
    }
    
    if ($found) {
        echo "Verifikasi berhasil! Anda sekarang dapat login.";
        echo "<br><a href='login.php'>Login</a>";
    } else {
        echo "Kode verifikasi tidak valid atau sudah digunakan.";
    }
} else {
    echo "Kode verifikasi tidak ditemukan.";
}
?>
