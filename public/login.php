<?php
session_start();
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Proses login ke Firebase Authentication
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $user = $signInResult->data();
        
        // Ambil UID pengguna yang login
        $uid = $signInResult->firebaseUserId();

        // Ambil data user dari Realtime Database berdasarkan UID
        $userData = $database->getReference('users/'.$uid)->getValue();

        if ($userData) {
            $_SESSION['user'] = $userData; // Simpan data user ke session
            $_SESSION['user']['uid'] = $uid; // Simpan UID juga untuk referensi

            header('Location: index.php'); // Redirect ke halaman utama setelah login
            exit();
        } else {
            echo "User tidak ditemukan di database.";
        }
    } catch (Exception $e) {
        echo "Login gagal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" required placeholder="Email"><br>
        <input type="password" name="password" required placeholder="Password"><br>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Belum punya akun? Register</a>
</body>
</html>
