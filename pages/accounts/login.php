<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/** @var PDO $pdo */
require_once '../../config/db.php';
require_once '../../classes/User.php';
require_once '../../includes/logger.php';
$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $user->login($_POST['email'], $_POST['password']);

    if ($result === 'resent_verification') {
        $error = "Please verify your email. A new verification link has been sent.";
    } elseif ($result === false) {
        logMessage("Invalid login attempt", "WARNING");
        $error = "Invalid email or password.";
    } else {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        header('Location: ../../index.php');
        exit;
    }
}
?>

<?php include '../../includes/header.php'; ?>

<h2>Login</h2>

<?php if (!empty($error)): ?>
    <p style="color: #f44336;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Log In</button>
</form>

<p>
    <a href="register.php">Don't have an account? Register</a><br>
    <a href="password_reset_request.php">Forgot your password?</a>
</p>

<?php include '../../includes/footer.php'; ?>
