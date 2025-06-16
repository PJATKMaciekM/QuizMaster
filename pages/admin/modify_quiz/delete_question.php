<?php
/** @var PDO $pdo */
require_once '../../../includes/session.php';
require_once '../../../config/db.php';
require_once '../../../classes/Question.php';
require_once '../../../classes/Answer.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' || !isset($_GET['question_id']) || !isset($_GET['quiz_id'])) {
    $url = 'http://localhost:8000';
    $url = $url . '/pages/login.php';
    echo "<script>window.location.href='$url';</script>";
    exit;
}

$question_id = (int) $_GET['question_id'];
$quiz_id = (int) $_GET['quiz_id'];
$answerObj = new Answer($pdo);
$questionObj = new Question($pdo);

// Delete all answers first, then the question
$answerObj->deleteAnswersByQuestionId($question_id);
$questionObj->deleteQuestion($question_id);

header("Location: manage_questions.php?quiz_id=" . $quiz_id);
exit;
?>
