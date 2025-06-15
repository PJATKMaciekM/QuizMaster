<link rel="stylesheet" href="../assets/css/style.css">
<?php include 'includes/header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: pages/login.php');
    exit;
}
echo "<h1>Welcome to QuizMaster</h1>";
echo "<p><a href='pages/quiz.php'>Take a Quiz</a></p>";
if ($_SESSION['role'] == 'admin') {
    echo "<p><a href='pages/admin/panel.php'>Admin Panel</a></p>";
}
?>
<?php include 'includes/footer.php'; ?>