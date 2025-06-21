<?php
/** @var PDO $pdo */
require_once '../../classes/Quiz.php';
require_once '../../classes/Question.php';
require_once '../../classes/Answer.php';
require_once '../../config/db.php';
require_once '../../includes/logger.php';
require_once '../../classes/User.php';
require_once '../../includes/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../accounts/login.php");
    exit;
}

$quizObj = new Quiz($pdo);
$questionObj = new Question($pdo);
$answerObj = new Answer($pdo);
$userObj = new User($pdo);
$user = $userObj->getUserById($_SESSION['user_id']);
if (!isset($_SESSION['arcade_score'])) {
    $_SESSION['arcade_score'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quiz_id'])) {
    $quiz_id = (int)$_POST['quiz_id'];
    $questions = $questionObj->getQuestionsByQuiz($quiz_id);
    $all_correct = true;

    foreach ($questions as $q) {
        $qid = $q['id'];
        if($q['question_type'] === 'text'){
            $correctAnswers = (array)$answerObj->getCorrectAnswerTextByQuestionId($qid);
            $userInput = trim($_POST['answers'][$qid] ?? '');
            $userAnswers[$qid] = $userInput;
            if (!(in_array(strtolower($userInput), array_map('strtolower', $correctAnswers)))) {
                $all_correct = false;
                break;
            }
        }else{
            $correctAnswers = $answerObj->getCorrectAnswersByQuestionId($qid);
            $submitted = $_POST['answers'][$qid] ?? [];
            if (!is_array($submitted)) {
                $submitted = [$submitted];
            }
            $submitted = array_map('intval', $submitted);
            $correctAnswers = array_map('intval', $answerObj->getCorrectAnswersByQuestionId($qid));

            sort($submitted);
            sort($correctAnswers);

            if ($submitted != $correctAnswers) {
                $all_correct = false;
                break;
            }
        }
    }

    if ($all_correct) {
        $_SESSION['arcade_score']++;
        logMessage("User {$_SESSION['user_id']} passed quiz $quiz_id in arcade mode", "INFO");
    } else {
        $quiz = $quizObj->getQuizById($quiz_id);
        $final_score = $_SESSION['arcade_score'];
        $stmt = $pdo->prepare("SELECT arcade_record FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $current_record = $stmt->fetchColumn();
        if ($final_score > $current_record) {
            $update = $pdo->prepare("UPDATE USERS SET arcade_record = ? WHERE id = ?");
            $update->execute([$final_score, $_SESSION['user_id']]);
            logMessage("User {$_SESSION['user_id']} set new arcade record: $final_score", "INFO");
        }
        logMessage("User {$_SESSION['user_id']} failed arcade on quiz $quiz_id after score $final_score", "INFO");
        $_SESSION['arcade_score'] = 0;
        $quizTitle = htmlspecialchars($quiz['title']);
        $questionCount = count($questions);
        include '../../includes/header.php'; ?>

        <div style="background: #1a1a1a; color: #fff; padding: 2rem; text-align: center; border-radius: 8px; max-width: 600px; margin: 3rem auto; box-shadow: 0 0 10px #000;">
            <h2 style="color: #ff4c4c;">🛑 Game Over</h2>

            <p style="font-size: 1rem; margin-top: 1rem;">You just failed:</p>
            <h3 style="margin: 0.5rem 0; color: #ccc;"><?= $quizTitle ?> (<?= $questionCount ?> questions)</h3>

            <p style="font-size: 1.2rem; margin-top: 2rem;">Your final score:</p>
            <h1 style="font-size: 3rem; color: #0f0; margin: 0.5rem 0;"><?= $final_score ?></h1>

            <p style="margin: 1.5rem 0;">Can you go further next time?</p>

            <a href="arcade.php" style="display: inline-block; background: #333; color: #fff; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none; transition: 0.2s;">🔁 Play Again</a>
        </div>

        <?php include '../../includes/footer.php';
        exit;

    }
}

$quiz_id = $quizObj->getRandomQuizId();
if (!$quiz_id) {
    echo "<p>No quizzes available.</p>";
    exit;
}
$quiz = $quizObj->getQuizById($quiz_id);
$questions = $questionObj->getQuestionsByQuiz($quiz_id);
?>

<?php include '../../includes/header.php'; ?>

<h2>Arcade Mode</h2>
<p>Score: <?= $_SESSION['arcade_score'] ?></p>

<form method="POST">
    <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
    <h3><?= htmlspecialchars($quiz['title']) ?></h3>

    <?php foreach ($questions as $q): ?>
        <div style="margin-bottom: 2rem; padding: 1rem; background: #2a2a2a; border-radius: 6px;">
            <?php if (!empty($q['image_path'])): ?>
                <img src="../../assets/uploads/<?= htmlspecialchars($q['image_path']) ?>" alt="Question Image"
                     style="max-width: 100%; height: auto; border: 1px solid #444; margin-bottom: 1rem;">
            <?php endif; ?>

            <?php
            $type = $q['question_type'];
            $answers = $answerObj->getAnswersByQuestionId($q['id']);
            $questionText = htmlspecialchars($q['question_text']);
            ?>

            <?php if ($type === 'text'): ?>
                <p><?= str_replace('___', '<u style="color:#ccc;">__________</u>', $questionText) ?></p>
                <input type="text" name="answers[<?= $q['id'] ?>]" required>
            <?php else: ?>
                <p><strong><?= $questionText ?></strong></p>
                <?php foreach ($answers as $ans): ?>
                    <label>
                        <input
                                type="<?= ($type === 'multiple') ? 'checkbox' : 'radio' ?>"
                                name="answers[<?= $q['id'] ?>]<?= ($type === 'multiple') ? '[]' : '' ?>"
                                value="<?= $ans['id'] ?>">
                        <?= htmlspecialchars($ans['answer_text']) ?>
                    </label><br>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <button type="submit">Submit Quiz</button>
</form>

<?php include '../../includes/footer.php'; ?>

