<?php
require_once '../config/db.php';
require_once '../includes/mailer.php';
require_once '../includes/logger.php';
/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM USERS WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        require_once __DIR__ . '/../includes/mailer.php';
        // Generate token and expiry
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", time() + 3600); // valid for 1 hour

        // Save token in DB
        $stmt = $pdo->prepare("UPDATE USERS SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        // Send reset email
        if (sendPasswordResetEmail($email, $token)) {
            $success = "Reset link sent. Check your email.";
        } else {
            $error = "Failed to send email. Try again later.";
        }
    } else {
        $error = "No user found with that email.";
        logMessage("User {$_SESSION['user_id']} attempted a password reset, but encountered an error", "WARNING");
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Password Reset Request</h2>

<?php if (!empty($error)): ?>
    <p style="color: #f44336;"><?php echo htmlspecialchars($error); ?></p>
<?php elseif (!empty($success)): ?>
    <p style="color: #4caf50;"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Your email" required>
    <button type="submit">Send Reset Link</button>
</form>

<p><a href="login.php">Back to login</a></p>

<?php include '../includes/footer.php'; ?>
