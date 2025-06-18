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
$rand_quiz = $quizObj->getRandomQuizId();
$rand_pic = $quizObj->getRandomQuizIdByType("image");
$rand_text = $quizObj->getRandomQuizIdByType("text");

echo "<h1>Welcome to QuizMaster</h1>";
echo "<p><a href='pages/quiz.php'>All quizzes</a></p>";
echo "<p><a href='pages/quizes/arcade.php'>Arcade</a></p>";
echo "<p><a href='pages/quizes/pictures.php'>Picture Quiz</a></p>";
echo "<p><a href='pages/take_quiz.php?quiz_id=$rand_quiz'> Quiz of the day</a></p>";
echo "<p><a href='pages/quizes/pictures.php?quiz_id=$rand_pic'> Picture Quiz</a></p>";
echo "<p><a href='pages/quizes/text_quiz.php?quiz_id=$rand_text'>Fill Blank Quiz</a></p>";
?>
<?php include 'includes/footer.php'; ?>