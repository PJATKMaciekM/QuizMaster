<?php
/** @var PDO $pdo */
require_once '../../../includes/session.php';
require_once '../../../config/db.php';
require_once '../../../classes/Question.php';
require_once '../../../classes/Answer.php';
require_once '../../../includes/logger.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || !isset($_GET['quiz_id']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
    $url = 'http://localhost:8000';
    $url = $url . '/pages/dashboard.php';
    echo "<script>window.location.href='$url';</script>";
    exit;
}
$quiz_id = (int) $_GET['quiz_id'];
$questionModel = new Question($pdo);
$answerModel = new Answer($pdo);
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_text = $_POST['question_text'];
    $answers = $_POST['answers'];
    $correct = $_POST['correct'];

    $question_id = $questionModel->addQuestion($quiz_id, $question_text);
    if ($question_id) {
        foreach ($answers as $i => $answer_text) {
            $is_correct = in_array($i, $correct) ? 1 : 0;
            $answerModel->addAnswer($question_id, $answer_text, $is_correct);
        }
        logMessage("Question added successfully by User {$_SESSION['user_id']}");
        $message = "Question added successfully.";
    } else {
        logMessage("Failed to delete question", "ERROR");
        $message = "Failed to add question.";
    }
}
?>

<?php include '../../../includes/header.php'; ?>

<h2>Add Questions to Quiz</h2>
<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Question Text:</label><br>
    <textarea name="question_text" rows="3" cols="60" required></textarea><br><br>

    <label>Answers:</label><br>
    <?php for ($i = 0; $i < 4; $i++): ?>
        <input type="text" name="answers[]" placeholder="Answer <?php echo $i + 1; ?>" required>
        <label>
            <input type="checkbox" name="correct[]" value="<?php echo $i; ?>"> Correct
        </label><br>
    <?php endfor; ?>

    <button type="submit" style="margin-top: 1rem;">Add Question</button>
</form>

<p style="margin-top: 1rem;"><a href="../../quiz.php">Done Adding Questions</a></p>

<?php include '../../../includes/footer.php'; ?>
