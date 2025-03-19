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
                $mail->Host = 'smtp.example.com'; // Ganti dengan SMTP server Anda
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@example.com'; // Ganti dengan email Anda
                $mail->Password = 'your-email-password'; // Ganti dengan password email
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'No-Reply');
                $mail->addAddress($email);
                $mail->Subject = 'Verifikasi Akun Anda';
                $mail->Body = "Klik link berikut untuk verifikasi akun Anda: http://yourdomain.com/verify.php?code=$verificationCode";
                
                $mail->send();
                echo "<p>Registrasi berhasil! Cek email Anda untuk verifikasi.</p>";
            } catch (Exception $e) {
                echo "<p>Email tidak dapat dikirim. Error: {$mail->ErrorInfo}</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p>Registrasi gagal: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register Page</h1>
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register</button>
    </form>
</body>
</html>
