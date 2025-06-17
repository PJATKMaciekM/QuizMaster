<link rel="stylesheet" href="../assets/css/style.css">
<?php include '../includes/header.php'; ?>
<?php
require_once '../includes/init.php';
/** @var PDO $pdo */
$quiz = new Quiz($pdo);
$questionModel = new Question($pdo);
$answerModel = new Answer($pdo);

if (!isset($_GET['quiz_id']) || !isset($_SESSION['quiz_results'])) {
    header("Location: index.php");
    exit;
}

$quiz_id = (int) $_GET['quiz_id'];
$quizData = $quiz->getQuizById($quiz_id);
$questions = $questionModel->getQuestionsByQuiz($quiz_id);
$userAnswers = $_SESSION['quiz_results'];
$score = $_SESSION['quiz_score'];
$total = count($questions);

// Clean up session
unset($_SESSION['quiz_results'], $_SESSION['quiz_score']);

include '../includes/header.php';
?>

<h2>Quiz Results: <?php echo htmlspecialchars($quizData['title']); ?></h2>
<p>You scored <strong><?php echo $score . ' / ' . $total; ?></strong> (<?php echo round(($score / $total) * 100); ?>%)</p>
<hr>

<?php foreach ($questions as $q): ?>
    <?php
    $qid = $q['id'];
    $answers = $answerModel->getAnswersByQuestion($qid);
    $correctIds = array_column(array_filter($answers, fn($a) => $a['is_correct']), 'id');
    $selected = $userAnswers[$qid] ?? [];
    if (!is_array($selected)) $selected = [$selected];
    ?>
    <div style="margin-bottom:1.5rem;">
        <p><strong>Q:</strong> <?php echo htmlspecialchars($q['question_text']); ?></p>
        <?php foreach ($answers as $a):
            $aid = $a['id'];
            $isCorrect = in_array($aid, $correctIds);
            $isSelected = in_array($aid, $selected);

            $class = 'result-answer ';
            if ($isCorrect && $isSelected) $class .= 'correct';
            elseif ($isCorrect) $class .= 'partial';
            elseif ($isSelected) $class .= 'wrong';
            else $class .= 'neutral';

            echo "<div class='$class'>";
            echo ($isSelected ? "☑️ " : "⬜ ") . htmlspecialchars($a['answer_text']);
            if ($isCorrect) echo " <small>(correct)</small>";
            echo "</div>";
        endforeach; ?>
    </div>
    <hr>
<?php endforeach; ?>

<p><a href="../index.php">🔙 Back to main page</a></p>

<?php include '../includes/footer.php'; ?>