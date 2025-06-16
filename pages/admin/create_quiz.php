<link rel="stylesheet" href="../../assets/css/style.css">
<?php
/** @var PDO $pdo */
require_once '../../config/db.php';
require_once '../../classes/Quiz.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$message = "";
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}
$quiz = new Quiz($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $type = $_POST['type'];

    $quizId = $quiz->createQuiz($title, $category, $_SESSION['user_id'], $type, $difficulty);
    if ($quizId !== false) {
        header("Location: add_questions_single.php?quiz_id=" . $quizId);
        exit;
    } else {
        $message = "Failed to create quiz.";
    }
}
?>
<?php include '../../includes/header.php'; ?>
<h2>Create a New Quiz</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="title" placeholder="Quiz Title" required><br><br>
    <input type="text" name="category" placeholder="Category" required><br><br>
    <label>Difficulty:</label><br>
    <select name="difficulty" required>
        <option value="easy">Easy</option>
        <option value="medium" selected>Medium</option>
        <option value="hard">Hard</option>
    </select><br><br>
    <label>Type:</label><br>
    <select name="type" required>
        <option value="single">Single Choice</option>
        <option value="multiple">Multiple Choice</option>
    </select><br><br>
    <button type="submit">Create Quiz</button>
</form>
<?php include '../../includes/footer.php'; ?>