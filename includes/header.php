<?php
$theme = $_COOKIE['theme'] ?? 'dark';
ob_start(); // <--- Enable output buffering
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuizMaster</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="/assets/css/style.css" as="style">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/theme_<?= $theme ?>.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
