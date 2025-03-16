<?php
include 'firebase_config.php';

if (!isset($auth)) {
    die("Firebase Authentication tidak diinisialisasi dengan benar."); // Debugging
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $userProperties = [
            'email' => $email,
            'password' => $password,
        ];
        $createdUser = $auth->createUser($userProperties);
        
        // Redirect ke login setelah berhasil registrasi
        header('Location: login.php?success=registered');
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
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
