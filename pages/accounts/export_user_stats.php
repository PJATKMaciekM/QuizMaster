<?php
require_once '../../includes/session.php';
require_once '../../config/db.php';

/** @var PDO $pdo */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get user basic info
$stmt = $pdo->prepare("SELECT name, email, created_at, arcade_record FROM USERS WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Get quiz stats
$stmt = $pdo->prepare("
    SELECT 
        SUM(score) AS total_score, 
        SUM(total_questions) AS total_possible,
        (SUM(score) / SUM(total_questions)) * 100 AS accuracy
    FROM RESULTS 
    WHERE user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetch();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM results WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total =  $stmt->fetchColumn();
// Prepare CSV content
$filename = "user_stats_" . date("Ymd_His") . ".csv";
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=$filename");

$output = fopen("php://output", "w");

fputcsv($output, ["User Info"]);
fputcsv($output, ["Name", "Email", "Joined"]);
fputcsv($output, [$user['name'], $user['email'], $user['created_at']]);
fputcsv($output, []);

fputcsv($output, ["Statistics"]);
fputcsv($output, ["Quizzes Taken", "Total Score", "Accuracy (%)", "Arcade Record"]);
fputcsv($output, [
    $total ?? 0,
    $stats['total_score'] ?? 0,
    round(($stats['accuracy'] ?? 0), 2),
    $user['arcade_record'] ?? 0
]);

fclose($output);
exit;
?>
