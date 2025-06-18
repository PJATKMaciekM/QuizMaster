<link rel="stylesheet" href="../../assets/css/style.css">
<?php
/** @var PDO $pdo */
require_once '../../config/db.php';
require_once '../../classes/Quiz.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$message = "";
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
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
        if($type == 'single'){
            header("Location: modify_quiz/add_questions_single.php?quiz_id=" . $quizId);
            exit;
        }else if($type == 'multiple'){
            header("Location: modify_quiz/add_questions_mult.php?quiz_id=" . $quizId);
            exit;
        }else if($type == 'image'){
            header("Location: modify_quiz/add_questions_image.php?quiz_id=" . $quizId);
            exit;
        }else if($type == 'text'){
            header("Location: modify_quiz/add_questions_text.php?quiz_id=" . $quizId);
            exit;
        }
    } else {
        logMessage("Failed to create quiz", "ERROR");
        $message = "Failed to create quiz.";
    }
    logMessage("Quiz created by User {$_SESSION['user_id']}", "INFO");
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
        <option value="image">Picture Quiz</option>
        <option value="text">Fill blanks Quiz</option>
    </select><br><br>
    <button type="submit">Create Quiz</button>
</form>
<?php include '../../includes/footer.php'; ?>