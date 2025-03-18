<?php
require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$firebaseCredentials = getenv('FIREBASE_CREDENTIALS');
if (!$firebaseCredentials) {
    die("Firebase credentials not set in environment variables.");
}
$serviceAccount = json_decode($firebaseCredentials, true);
if (!$serviceAccount) {
    die("Invalid Firebase credentials.");
}
$factory = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://cloudcomputing-f7ce8-default-rtdb.asia-southeast1.firebasedatabase.app/');

$db = $factory->createDatabase();
$auth = $factory->createAuth();

var_dump($auth); 
exit();

function sendVerificationEmail($email, $verificationLink) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; 
        $mail->Password = 'your-email-password'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('your-email@example.com', 'Your App');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body    = "Click <a href='$verificationLink'>here</a> to verify your email.";
        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
    }
}
?>