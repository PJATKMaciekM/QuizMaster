<?php
/** @var PDO $pdo */
require_once '../../includes/session.php';
require_once '../../config/db.php';
require_once '../../classes/Quiz.php';
require_once '../../includes/logger.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
    $url = 'http://localhost:8000';
    $url = $url . '/pages/login.php';
    echo "<script>window.location.href='$url';</script>";
    exit;
}
$quizObj = new Quiz($pdo);
$message = "";

// Handle deletion
if (isset($_GET['delete'])) {
    $quizId = (int) $_GET['delete'];
    if ($quizObj->deleteQuiz($quizId)) {
        logMessage("Quiz deleted successfully by User {$_SESSION['user_id']}", "WARNING");
        $message = "Quiz deleted successfully.";
    } else {
        logMessage("Failed to delete quiz", "ERROR");
        $message = "Failed to delete quiz.";
    }
}

$quizzes = $quizObj->getAllQuizzes();
?>

<?php include '../../includes/header.php'; ?>

<h2>Manage Quizzes</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<table style="width: 100%; background-color: #1a1a1a; color: #fff;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Difficulty</th>
            <th>Type</th>
            <th>Created By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($quizzes as $quiz): ?>
        <tr>
            <td><?php echo $quiz['id']; ?></td>
            <td><?php echo htmlspecialchars($quiz['title']); ?></td>
            <td><?php echo htmlspecialchars($quiz['category']); ?></td>
            <td><?php echo htmlspecialchars($quiz['difficulty']); ?></td>
            <td><?php echo htmlspecialchars($quiz['type']); ?></td>
            <td><?php echo htmlspecialchars($quiz['created_by']); ?></td>
            <td>
                <a href="modify_quiz/edit_quiz.php?quiz_id=<?php echo $quiz['id']; ?>">Edit</a> |
                <a href="modify_quiz/manage_questions.php?quiz_id=<?php echo $quiz['id']; ?>">Manage Questions</a> |
                <a href="?delete=<?php echo $quiz['id']; ?>" onclick="return confirm('Are you sure you want to delete this quiz?');">Delete</a>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
