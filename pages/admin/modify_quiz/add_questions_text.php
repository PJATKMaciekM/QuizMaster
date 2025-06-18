<?php
/** @var PDO $pdo */
require_once '../../../includes/session.php';
require_once '../../../config/db.php';
require_once '../../../includes/logger.php';
require_once '../../../classes/Question.php';
require_once '../../../classes/Answer.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$quiz_id = $_GET['quiz_id'] ?? null;
if (!$quiz_id) {
    echo "<p>Invalid quiz ID.</p>";
    exit;
}
$questionModel = new Question($pdo);
$answerModel = new Answer($pdo);

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sentence = $_POST['sentence'];
    $correct_word = trim($_POST['correct_word']);

    // Validate input
    if (!str_contains($sentence, '___')) {
        $message = "You must include '___' as a placeholder for the missing word.";
    } else {
        // Insert question
        $question_id = $questionModel->addQuestion($quiz_id, $sentence, 'text');

        // Insert correct answer
        if ($question_id) {
            $answerModel->addAnswer($question_id, $correct_word, 1);
        }

        $message = "Fill-in-the-blank question added!";
        logMessage("User {$_SESSION['user_id']} added fill-blank question to quiz ID $quiz_id", "INFO");
    }
}
?>

<?php include '../../../includes/header.php'; ?>

<h2>Add Fill-in-the-Blank Question</h2>
<?php if ($message): ?>
    <p style="color: lime;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Sentence (use <strong>___</strong> as the blank):</label><br>
    <textarea name="sentence" rows="3" cols="60" required></textarea><br><br>

    <label>Correct word:</label><br>
    <input type="text" name="correct_word" required><br><br>

    <button type="submit">Add Question</button>
    <p style="margin-top: 1rem;"><a href="../../quiz.php">Done Adding Questions</a></p>
</form>

<?php include '../../../includes/footer.php'; ?>
