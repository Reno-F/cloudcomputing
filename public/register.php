<?php
session_start();
include 'firebase_config.php';

if (!isset($auth)) {
    die("Firebase Authentication tidak diinisialisasi dengan benar."); // Debugging
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Buat akun pengguna di Firebase Authentication
        $userProperties = [
            'email' => $email,
            'password' => $password,
        ];
        $createdUser = $auth->createUser($userProperties);

        if ($createdUser) {
            $uid = $createdUser->uid; // Ambil UID pengguna dari Firebase

            // Data yang akan disimpan ke Realtime Database
            $userData = [
                'email' => $email,
                'role' => 'user', // Tambahkan role jika perlu
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Simpan data user ke Firebase Realtime Database
            $database->getReference('users/'.$uid)->set($userData);

            // Redirect ke login setelah berhasil registrasi
            header('Location: login.php?success=registered');
            exit();
        }
    } catch (Exception $e) {
        echo "Registrasi gagal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="email" name="email" required placeholder="Email"><br>
        <input type="password" name="password" required placeholder="Password"><br>
        <button type="submit">Register</button>
    </form>
    <a href="login.php">Sudah punya akun? Login</a>
</body>
</html>
