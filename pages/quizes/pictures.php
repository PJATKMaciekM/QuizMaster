<?php
/** @var PDO $pdo */
require_once '../../includes/session.php';
require_once '../../config/db.php';
require_once '../../classes/Quiz.php';
require_once '../../classes/Question.php';
require_once '../../classes/Answer.php';
require_once '../../includes/logger.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$quiz_id = $_GET['quiz_id'] ?? null;
if (!$quiz_id) {
    echo "<p>Invalid quiz ID.</p>";
    exit;
}

$quizObj = new Quiz($pdo);
$questionObj = new Question($pdo);
$answerObj = new Answer($pdo);

$quiz = $quizObj->getQuizById($quiz_id);
$questions = $questionObj->getQuestionsByQuiz($quiz_id);

$userAnswers = [];
$score = 0;
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    foreach ($questions as $q) {
        $qid = $q['id'];
        $correct = $answerObj->getCorrectAnswersByQuestionId($qid);
        $selected = $_POST['answers'][$qid] ?? null;

        if ($selected) {
            $userAnswers[$qid] = $selected;
            if (in_array($selected, $correct)) {
                $score++;
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO RESULTS (user_id, quiz_id, score, total_questions,date_taken) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $quiz_id, $score, count($questions)]);

    logMessage("User {$_SESSION['user_id']} completed image quiz $quiz_id with score $score/" . count($questions), "INFO");
}
?>

<?php include '../../includes/header.php'; ?>

<h2><?= htmlspecialchars($quiz['title']) ?></h2>
<?php if ($submitted): ?>
    <div style="background: #1a1a1a; color: #0f0; padding: 1rem; margin-bottom: 1.5rem; border-radius: 5px;">
        <h3>✅ You scored <?= $score ?> out of <?= count($questions) ?></h3>
    </div>
<?php endif; ?>

<form method="POST">
    <?php foreach ($questions as $q): ?>
        <div style="margin-bottom: 2rem; padding: 1rem; background: #2a2a2a; border-radius: 6px;">
            <?php if (!empty($q['image_path'])): ?>
                <img src="../../../assets/uploads/<?= htmlspecialchars($q['image_path']) ?>" alt="Question Image"
                     style="max-width: 100%; height: auto; border: 1px solid #444; margin-bottom: 1rem;">
            <?php endif; ?>
            <p><strong><?= htmlspecialchars($q['question_text']) ?></strong></p>

            <?php
            $answers = $answerObj->getAnswersByQuestionId($q['id']);
            $correctAnswerIds = $answerObj->getCorrectAnswersByQuestionId($q['id']);
            ?>

            <?php foreach ($answers as $ans):
                $isChecked = isset($userAnswers[$q['id']]) && $userAnswers[$q['id']] == $ans['id'];
                $isCorrect = in_array($ans['id'], $correctAnswerIds);
                ?>
                <label style="display: block; margin-bottom: 5px;
                <?= $submitted ? ($isCorrect ? 'color: #0f0;' : ($isChecked ? 'color: red;' : '')) : '' ?>">
                    <input type="radio" name="answers[<?= $q['id'] ?>]" value="<?= $ans['id'] ?>"
                        <?= $isChecked ? 'checked' : '' ?> <?= $submitted ? 'disabled' : '' ?>>
                    <?= htmlspecialchars($ans['answer_text']) ?>
                    <?php if ($submitted && $isCorrect): ?>
                        <strong> ✔</strong>
                    <?php endif; ?>
                </label>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <?php if (!$submitted): ?>
        <button type="submit">Submit</button>
    <?php endif; ?>
</form>

<?php include '../../includes/footer.php'; ?>
