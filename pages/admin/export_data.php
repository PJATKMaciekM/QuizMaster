<?php
/** @var PDO $pdo */
require_once '../../config/db.php';
require_once '../../classes/Admin.php';
require_once '../../includes/session.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}

$admin = new Admin($pdo);
$data = $admin->exportQuizData();
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="quizzes.csv"');
$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Title', 'Category', 'Type']);
foreach ($data as $row) {
    fputcsv($output, [$row['id'], $row['title'], $row['category'], $row['type']]);
}
fclose($output);
exit;
?>
