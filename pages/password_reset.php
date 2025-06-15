<link rel="stylesheet" href="../assets/css/style.css">
<?php
/** @var PDO $pdo */
require_once '../config/db.php';
require_once '../classes/User.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM USERS WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE USERS SET password_hash = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $stmt->execute([$newPassword, $user['id']]);
        echo "Password reset successful. You can <a href='login.php'>Log in now</a>.";
        exit;
    }
} else {
    echo "Invalid or expired token.";
    exit;
}
?>
<?php include '../includes/header.php'; ?>
<form method="POST">
    New Password: <input type="password" name="password" required>
    <button type="submit">Reset Password</button>
</form>
<?php include '../includes/footer.php'; ?>