<link rel="stylesheet" href="../../assets/css/style.css">
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /** @var PDO $pdo */
    require_once '../../config/db.php';
    require_once '../../classes/Quiz.php';
    $quiz = new Quiz($pdo);
    $quiz->createQuiz($_POST['title'], $_POST['category'], $_SESSION['user_id'], $_POST['type']);
    echo "Quiz created!";
}
?>
<?php include '../../includes/header.php'; ?>
<form method="POST">
    Title: <input type="text" name="title" required>
    Category: <input type="text" name="category" required>
    Type:
    <select name="type">
        <option value="single">Single Choice</option>
        <option value="multiple">Multiple Choice</option>
        <option value="text">Text Answer</option>
    </select>
    <button type="submit">Create Quiz</button>
</form>
<?php include '../../includes/footer.php'; ?>