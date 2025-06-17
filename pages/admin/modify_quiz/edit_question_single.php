<?php
/** @var PDO $pdo */
require_once '../../../includes/session.php';
require_once '../../../config/db.php';
require_once '../../../classes/Question.php';
require_once '../../../classes/Answer.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator']) || !isset($_GET['question_id'])) {
    $url = 'http://localhost:8000';
    $url = $url . '/pages/login.php';
    echo "<script>window.location.href='$url';</script>";
    exit;
}

$question_id = (int) $_GET['question_id'];
$questionObj = new Question($pdo);
$answerObj = new Answer($pdo);

$question = $questionObj->getQuestionById($question_id);
$answers = $answerObj->getAnswersByQuestionId($question_id);

if (!$question) {
    echo "Question not found.";
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['question_text'];
    $newAnswers = $_POST['answers'];
    $correct = $_POST['correct'];

    $questionObj->updateQuestionText($question_id, $text);
    $answerObj->deleteAnswersByQuestionId($question_id);
    foreach ($newAnswers as $i => $answer) {
        $is_correct = in_array($i, $correct) ? 1 : 0;
        $answerObj->addAnswer($question_id, $answer, $is_correct);
    }

    $message = "Question updated successfully.";
}
?>

<?php include '../../../includes/header.php'; ?>

<h2>Edit Question</h2>
<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Question Text:</label><br>
    <textarea name="question_text" rows="3" cols="60" required><?php echo htmlspecialchars($question['question_text']); ?></textarea><br><br>

    <label>Answers:</label><br>
    <?php foreach ($answers as $i => $ans): ?>
        <input type="text" name="answers[]" value="<?= htmlspecialchars($ans['answer_text']) ?>" required>
        <label>
            <input type="radio" name="correct[]" value="<?= $i ?>" <?= $ans['is_correct'] ? 'checked' : '' ?>> Correct
        </label><br>
    <?php endforeach; ?>

    <button type="submit" style="margin-top: 1rem;">Save Changes</button>
</form>

<p><a href="manage_questions.php?quiz_id=<?= $question['quiz_id'] ?>">← Back to Question List</a></p>

<?php include '../../../includes/footer.php'; ?>
