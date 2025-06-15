<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../.idea/');
$dotenv->load();

function sendVerificationEmail($toEmail, $token) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['GMAIL_USER'];
        $mail->Password   = $_ENV['GMAIL_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($_ENV['GMAIL_USER'], $_ENV['GMAIL_NAME']);
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Verify your email';
        $verifyLink = $_ENV['BASE_URL'] . "/pages/verify_email.php?token=" . urlencode($token);
        $mail->Body    = "Click the link to verify your account: <a href='$verifyLink'>$verifyLink</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

function sendPasswordResetEmail($toEmail, $token) {
    $mail = new PHPMailer(true);
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['GMAIL_USER'];
        $mail->Password   = $_ENV['GMAIL_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($_ENV['GMAIL_USER'], $_ENV['GMAIL_NAME']);
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Reset your password';
        $link = $_ENV['BASE_URL'] . "/pages/password_reset.php?token=" . urlencode($token);
        $mail->Body    = "Click here to reset your password: <a href='$link'>$link</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
