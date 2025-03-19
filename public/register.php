<?php
session_start();
include 'firebase_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

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
            $verificationCode = bin2hex(random_bytes(16)); // Generate kode unik

            // Simpan data user ke Firebase Realtime Database
            $userData = [
                'email' => $email,
                'is_verified' => false,
                'verification_code' => $verificationCode,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $database->getReference('users/'.$uid)->set($userData);

            // Kirim email verifikasi
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Ganti dengan SMTP server Anda
                $mail->SMTPAuth = true;
                $mail->Username = 'renovansetio0906@gmail.com'; // Ganti dengan email Anda
                $mail->Password = 'your-email-password'; // Ganti dengan password email
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'No-Reply');
                $mail->addAddress($email);
                $mail->Subject = 'Verifikasi Akun Anda';
                $mail->Body = "Klik link berikut untuk verifikasi akun Anda: http://yourdomain.com/verify.php?code=$verificationCode";
                
                $mail->send();
                echo "Registrasi berhasil! Cek email Anda untuk verifikasi.";
            } catch (Exception $e) {
                echo "Email tidak dapat dikirim. Error: {$mail->ErrorInfo}";
            }
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
