<link rel="stylesheet" href="../assets/css/style.css">
<?php include 'includes/header.php'; ?>
<?php
/** @var PDO $pdo */
require_once 'config/db.php';
require_once 'classes/Quiz.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: pages/accounts/login.php');
    exit;
}
$quizObj = new Quiz($pdo);
$rand_int = $quizObj->getRandomQuizId();
if (!$rand_int) {
    echo "<p>No quizzes available.</p>";
    exit;
}
echo "<h1>Welcome to QuizMaster</h1>";
echo "<p><a href='pages/quiz.php'>All quizzes</a></p>";
echo "<p><a href='pages/quizes/arcade.php'>Arcade</a></p>";
echo "<p><a href='pages/quizes/pictures.php'>Picture Quiz</a></p>";
echo "<p><a href='pages/take_quiz.php?quiz_id=$rand_int'> Quiz of the day</a></p>";
?>
<?php include 'includes/footer.php'; ?>