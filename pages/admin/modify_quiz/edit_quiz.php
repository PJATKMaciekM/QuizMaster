<?php
/** @var PDO $pdo */
require_once '../../../includes/session.php';
require_once '../../../config/db.php';
require_once '../../../classes/Quiz.php';
require_once '../../../includes/logger.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator']) || !isset($_GET['quiz_id'])) {
    $url = 'http://localhost:8000';
    $url = $url . '/pages/login.php';
    echo "<script>window.location.href='$url';</script>";
    exit;
}

$quizObj = new Quiz($pdo);
$quiz_id = (int) $_GET['quiz_id'];
$quiz = $quizObj->getQuizById($quiz_id);

if (!$quiz) {
    echo "Quiz not found.";
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $type = $_POST['type'];

    if ($quizObj->updateQuiz($quiz_id, $title, $category, $type, $difficulty)) {
        logMessage("Quiz updated successfully by User {$_SESSION['user_id']}");
        $message = "Quiz updated successfully.";
        $quiz = $quizObj->getQuizById($quiz_id); // refresh data
    } else {
        logMessage("Failed to update quiz", "ERROR");
        $message = "Failed to update quiz.";
    }
}
?>

<?php include '../../../includes/header.php'; ?>

<h2>Edit Quiz</h2>
<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($quiz['title']); ?>" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category" value="<?php echo htmlspecialchars($quiz['category']); ?>" required><br><br>

    <label>Difficulty:</label><br>
    <select name="difficulty" required>
        <option value="easy" <?= $quiz['difficulty'] === 'easy' ? 'selected' : '' ?>>Easy</option>
        <option value="medium" <?= $quiz['difficulty'] === 'medium' ? 'selected' : '' ?>>Medium</option>
        <option value="hard" <?= $quiz['difficulty'] === 'hard' ? 'selected' : '' ?>>Hard</option>
    </select><br><br>

    <label>Type:</label><br>
    <select name="type" required>
        <option value="single" <?= $quiz['type'] === 'single' ? 'selected' : '' ?>>Single Choice</option>
        <option value="multiple" <?= $quiz['type'] === 'multiple' ? 'selected' : '' ?>>Multiple Choice</option>
    </select><br><br>

    <button type="submit">Update Quiz</button>
</form>

<p><a href="../admin_manage_quizzes.php">Back to Quiz List</a></p>

<?php include '../../../includes/footer.php'; ?>
