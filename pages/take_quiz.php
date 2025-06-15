<?php
require_once '../includes/init.php';

/** @var PDO $pdo */
$quiz = new Quiz($pdo);
$questionModel = new Question($pdo);
$answerModel = new Answer($pdo);

if (!isset($_GET['quiz_id'])) {
    die("No quiz selected.");
}

$quiz_id = (int) $_GET['quiz_id'];
$quizData = $quiz->getQuizById($quiz_id);
$questions = $questionModel->getQuestionsByQuiz($quiz_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $total = count($questions);

    foreach ($questions as $q) {
        $qid = $q['id'];
        $correctAnswers = array_filter($answerModel->getAnswersByQuestion($qid), fn($a) => $a['is_correct']);
        $submitted = $_POST['answer'][$qid] ?? [];

        if (!is_array($submitted)) {
            $submitted = [$submitted];
        }

        $correctIds = array_column($correctAnswers, 'id');
        sort($correctIds);
        sort($submitted);

        if ($correctIds == $submitted) {
            $score++;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO RESULTS (user_id, quiz_id, score, date_taken) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$_SESSION['user_id'], $quiz_id, $score]);

    $_SESSION['quiz_results'] = $_POST['answer'];
    $_SESSION['quiz_score'] = $score;

    header("Location: results.php?quiz_id=$quiz_id");
    exit;
}
?>

<?php include '../includes/header.php'; ?>

<h2><?php echo htmlspecialchars($quizData['title']); ?></h2>

<form method="POST">
    <?php foreach ($questions as $q): ?>
        <fieldset style="margin-bottom: 1.5rem;">
            <legend><?php echo htmlspecialchars($q['question_text']); ?></legend>
            <?php
            $answers = $answerModel->getAnswersByQuestion($q['id']);
            foreach ($answers as $a):
                ?>
                <label style="display:block;">
                    <input type="<?php echo $q['question_type'] === 'multiple' ? 'checkbox' : 'radio'; ?>"
                           name="answer[<?php echo $q['id']; ?>]<?php echo $q['question_type'] === 'multiple' ? '[]' : ''; ?>"
                           value="<?php echo $a['id']; ?>">
                    <?php echo htmlspecialchars($a['answer_text']); ?>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endforeach; ?>
    <button type="submit">Submit Quiz</button>
</form>

<?php include '../includes/footer.php'; ?>
