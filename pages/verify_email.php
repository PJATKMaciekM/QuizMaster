<link rel="stylesheet" href="../assets/css/style.css">
<?php
/** @var PDO $pdo */
require_once '../config/db.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT * FROM USERS WHERE verify_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $update = $pdo->prepare("UPDATE USERS SET verified = 1, verify_token = NULL WHERE id = ?");
        $update->execute([$user['id']]);
        echo "✅ Your email has been verified. <a href='login.php'>Login now</a>";
    } else {
        echo "❌ Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>
