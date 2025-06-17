<link rel="stylesheet" href="../../assets/css/style.css">
<?php include '../../includes/header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
    header("Location: ../dashboard.php");
    exit;
}
echo "<h1>Admin Panel</h1>";
echo "<p><a href='create_quiz.php'>Create Quiz</a></p>";
echo "<p><a href='admin_manage_quizzes.php'>Manage Quizzes</a></p>";
if ($_SESSION['role'] == 'admin') {
    echo "<p><a href='manage_users.php'>Manage Users</a></p>";
    echo "<p><a href='export_data.php'>Export Quiz Data</a></p>";
    echo "<p><a href='admin_logs.php'>View logs</a></p>";
}
?>
<?php include '../../includes/footer.php'; ?>