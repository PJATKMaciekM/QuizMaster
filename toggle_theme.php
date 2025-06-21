<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current = $_COOKIE['theme'] ?? 'dark';
$new = ($current === 'dark') ? 'light' : 'dark';

setcookie('theme', $new, time() + (86400 * 30), '/'); // 30 days

// Redirect back to the previous page
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
