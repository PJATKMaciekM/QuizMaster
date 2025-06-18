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
        $correctAnswers = $answerObj->getCorrectAnswerTextByQuestionId($qid);
        $userInput = trim($_POST['answers'][$qid] ?? '');
        $userAnswers[$qid] = $userInput;
        if (in_array(strtolower($userInput), array_map('strtolower', $correctAnswers))) {
            $score++;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO RESULTS (user_id, quiz_id, score, total_questions,date_taken) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $quiz_id, $score, count($questions)]);
    logMessage("User {$_SESSION['user_id']} completed fill-blank quiz $quiz_id with score $score/" . count($questions), "INFO");
}
?>

<?php include '../../includes/header.php'; ?>

<h2><?= htmlspecialchars($quiz['title']) ?> — Fill-in-the-Blank Quiz</h2>

<?php if ($submitted): ?>
    <div style="background: #1a1a1a; color: #0f0; padding: 1rem; margin-bottom: 1.5rem; border-radius: 5px;">
        <h3>✅ You scored <?= $score ?> out of <?= count($questions) ?></h3>
    </div>
<?php endif; ?>

<form method="POST">
    <?php foreach ($questions as $q): 
        $qid = $q['id'];
        $text = htmlspecialchars($q['question_text']);
        $correct = $answerObj->getCorrectAnswerTextByQuestionId($qid);
        $user_input = $userAnswers[$qid] ?? '';
        $is_correct = in_array(strtolower($user_input), array_map('strtolower', $correct));
    ?>
    <div style="margin-bottom: 2rem; padding: 1rem; background: #2a2a2a; border-radius: 6px;">
        <p>
            <?= str_replace('___', '<u style="color:#ccc;">__________</u>', $text) ?>
        </p>

        <?php if ($submitted): ?>
            <p>
                <strong>Your answer:</strong>
                <span style="color: <?= $is_correct ? '#0f0' : 'red' ?>;">
                    <?= htmlspecialchars($user_input) ?>
                </span>
                <?php if (!$is_correct): ?>
                    <br><strong>Correct:</strong> <?= htmlspecialchars($correct[0]) ?>
                <?php endif; ?>
            </p>
        <?php else: ?>
            <input type="text" name="answers[<?= $qid ?>]" required>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <?php if (!$submitted): ?>
        <button type="submit">Submit</button>
    <?php endif; ?>
</form>

<?php include '../../includes/footer.php'; ?>
