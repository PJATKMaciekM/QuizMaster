<link rel="stylesheet" href="../assets/css/style.css">
<?php include '../includes/header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/** @var PDO $pdo */
require_once '../includes/init.php';
$quiz = new Quiz($pdo);
$quizzes = $quiz->getAllQuizzes();
foreach ($quizzes as $q) {
    echo "<div><a href='take_quiz.php?quiz_id={$q['id']}'>{$q['title']}</a></div>";
}
?>
<?php include '../includes/footer.php'; ?>