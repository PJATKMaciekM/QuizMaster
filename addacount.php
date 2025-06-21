<?php
/** @var PDO $pdo */
require_once 'config/db.php';
$password = 'Password';
$name = 'Admin';
$email = 'm13mor@gmail.com';

$hash = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(32));

$stmt = $pdo->prepare("
        INSERT INTO USERS (name, email, password_hash, role, verify_token, verified, created_at)
        VALUES (?, ?, ?, 'admin', ?, 1, NOW())
    ");
$stmt->execute([$name, $email, $hash, $token]);

?>