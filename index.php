<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start(); // <--- Enable output buffering
?>
<link rel="stylesheet" href="assets/css/style.css">
<?php include 'pages/dashboard.php'; ?>