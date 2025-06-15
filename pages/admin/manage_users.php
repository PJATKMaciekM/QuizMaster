<link rel="stylesheet" href="../../assets/css/style.css">
<?php include '../../includes/header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}
/** @var PDO $pdo */
require_once '../../config/db.php';
require_once '../../classes/Admin.php';
$admin = new Admin($pdo);
$users = $admin->getAllUsers();
foreach ($users as $user) {
    echo "<p>{$user['name']} ({$user['email']}) - {$user['role']}</p>";
}
?>
<?php include '../../includes/footer.php'; ?>