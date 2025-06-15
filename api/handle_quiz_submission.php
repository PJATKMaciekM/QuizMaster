<?php
/** @var PDO $pdo */
require_once '../config/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['user_id'];
$quiz_id = $_POST['quiz_id'];
$score = $_POST['score'];
$stmt = $pdo->prepare("INSERT INTO RESULTS (user_id, quiz_id, score, date_taken) VALUES (?, ?, ?, NOW())");
$stmt->execute([$user_id, $quiz_id, $score]);
echo json_encode(["status" => "success"]);
?>