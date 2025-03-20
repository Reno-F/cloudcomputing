<?php
session_start();
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Cek apakah email sudah terdaftar di Firebase Authentication
        try {
            $user = $auth->getUserByEmail($email);
            echo "Email sudah digunakan. <a href='login.php'>Login di sini</a>";
            exit();
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            // Jika email belum terdaftar, lanjutkan proses registrasi
        }

        // Buat akun pengguna di Firebase Authentication
        $userProperties = [
            'email' => $email,
            'password' => $password,
        ];
        $createdUser = $auth->createUser($userProperties);

        if ($createdUser) {
            $uid = $createdUser->uid;

            // Simpan data user ke Firebase Realtime Database
            $userData = [
                'email' => $email,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $database->getReference('users/'.$uid)->set($userData);

            echo "Registrasi berhasil! Silakan <a href='login.php'>login di sini</a>.";
        }
    } catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
        echo "Email sudah terdaftar. Silakan gunakan email lain atau login.";
    } catch (Exception $e) {
        echo "Registrasi gagal: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 400px;
            background: white;
            padding: 20px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background: blue;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
