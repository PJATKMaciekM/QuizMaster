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
    $question_text = $_POST['question_text'];
    $correct = $_POST['correct'];
    $answers = $_POST['answers'];
    $image = $_FILES['image'];

    // Upload image
    $targetDir = "../../../assets/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageName = time() . "_" . basename($image["name"]);
    $targetFile = $targetDir . $imageName;
    move_uploaded_file($image["tmp_name"], $targetFile);

    // Insert question
    //$stmt = $pdo->prepare("INSERT INTO QUESTIONS (quiz_id, question_text, image_path) VALUES (?, ?, ?)");
    //$stmt->execute([$quiz_id, $question_text, $imageName]);
    //$question_id = $pdo->lastInsertId();
    $question_id = $questionModel->addQuestionImage($quiz_id,$question_text,$imageName);
    if($question_id){
        foreach ($answers as $i => $answer_text) {
            $is_correct = in_array($i, $correct)? 1 : 0;
            $answerModel->addAnswer($question_id, $answer_text, $is_correct);
        }
    }
    // Insert answers
//    foreach ($answers as $i => $answer) {
//        $is_correct = ($i == $correct_answer) ? 1 : 0;
//        $stmt = $pdo->prepare("INSERT INTO ANSWERS (question_id, answer_text, is_correct) VALUES (?, ?, ?)");
//        $stmt->execute([$question_id, $answer, $is_correct]);
//    }

    $message = "Image-based question added!";
    logMessage("User {$_SESSION['user_id']} added image quiz question to quiz ID $quiz_id", "INFO");
}
?>

<?php include '../../../includes/header.php'; ?>

<h2>Add Image-based Question</h2>
<?php if ($message): ?>
    <p style="color: lime;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Question:</label><br>
    <textarea name="question_text" required rows="2" cols="50"></textarea><br><br>

    <label>Upload Image:</label><br>
    <input type="file" name="image" accept="image/*" required><br><br>

    <label>Answers:</label><br>
    <?php for ($i = 0; $i < 4; $i++): ?>
        <input type="text" name="answers[]" placeholder="Answer <?php echo $i + 1; ?>" required>
        <label>
            <input type="radio" name="correct[]" value="<?php echo $i; ?>"> Correct
        </label><br>
    <?php endfor; ?>

    <button type="submit">Add Question</button>
</form>
<p style="margin-top: 1rem;"><a href="../../quiz.php">Done Adding Questions</a></p>
<?php include '../../../includes/footer.php'; ?>
