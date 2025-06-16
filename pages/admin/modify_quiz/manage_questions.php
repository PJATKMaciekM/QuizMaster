<?php
/** @var PDO $pdo */
require_once '../../../includes/session.php';
require_once '../../../config/db.php';
require_once '../../../classes/Question.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' || !isset($_GET['quiz_id'])) {
    $url = 'http://localhost:8000';
    $url = $url . '/pages/login.php';
    echo "<script>window.location.href='$url';</script>";
    exit;
}

$quiz_id = (int) $_GET['quiz_id'];
$questionObj = new Question($pdo);
$questions = $questionObj->getQuestionsByQuiz($quiz_id);
?>

<?php include '../../../includes/header.php'; ?>

<h2>Manage Questions (Quiz ID: <?= $quiz_id ?>)</h2>

<p><a href="add_questions_single.php?quiz_id=<?= $quiz_id ?>">➕ Add New Question</a></p>

<table style="width: 100%; background-color: #1a1a1a; color: #fff;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($questions as $q): ?>
        <tr>
            <td><?= $q['id']; ?></td>
            <td><?= htmlspecialchars($q['question_text']); ?></td>
            <td>
                <a href="edit_question_single.php?question_id=<?= $q['id'] ?>">Edit</a> |
                <a href="delete_question.php?question_id=<?= $q['id'] ?>&quiz_id=<?= $quiz_id ?>"
                   onclick="return confirm('Are you sure you want to delete this question?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p><a href="../admin_manage_quizzes.php">← Back to Quiz List</a></p>

<?php include '../../../includes/footer.php'; ?>
