<?php
session_start();
include 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $userProperties = [
            'email' => $email,
            'password' => $password,
        ];
        $createdUser = $auth->createUser($userProperties);
        if ($createdUser) {
            $uid = $createdUser->uid;
            $verificationLink = "http://yourdomain.com/verify.php?uid=$uid";
            sendVerificationEmail($email, $verificationLink);
            $userData = [
                'email' => $email,
                'verified' => false,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $db->getReference('users/'.$uid)->set($userData);
            header('Location: login.php?success=verify_email');
            exit();
        }
    } catch (Exception $e) {
        echo "Registrasi gagal: " . $e->getMessage();
    }
}
?>