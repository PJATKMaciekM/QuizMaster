<link rel="stylesheet" href="../assets/css/style.css">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /** @var PDO $pdo */
    require_once '../config/db.php';
    require_once '../classes/User.php';
    require_once '../includes/logger.php';
    $user = new User($pdo);
    $result = $user->register($_POST['name'], $_POST['email'], $_POST['password']);

    if ($result === 'email_exists') {
        $error = "This email is already registered.";
    } elseif ($result) {
        echo "✅ Registered! Please check your email for a verification link.";
    } else {
        $error = "Something went wrong during registration.";
        logMessage("User failed to register", "WARNING");
    }
}
?>
<?php include '../includes/header.php'; ?>
<form method="POST">
    Username: <input type="text" name="name" required>
    Email: <input type="email" name="email" required>
    Password: <input type="password" name="password" required>
    <button type="submit">Register</button>
</form>
<?php include '../includes/footer.php'; ?>