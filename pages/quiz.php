<?php
/** @var PDO $pdo */
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../classes/Quiz.php';

$quiz = new Quiz($pdo);

// Collect distinct categories for dropdown
$categories = $quiz->getDistinctCategories();

// Get filter inputs
$difficulty = $_GET['difficulty'] ?? '';
$category = $_GET['category'] ?? '';

// Get filtered quizzes
$filteredQuizzes = $quiz->getFilteredQuizzes($difficulty, $category);
?>

<?php include '../includes/header.php'; ?>

<h2>All Quizzes</h2>

<form method="GET" style="margin-bottom: 1rem;">
    <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div style="display: flex; flex-direction: column;">
            <label for="difficulty">Difficulty:</label>
            <select name="difficulty" id="difficulty" onchange="this.form.submit()">
                <option value="">-- All --</option>
                <option value="easy" <?= $difficulty === 'easy' ? 'selected' : '' ?>>Easy</option>
                <option value="medium" <?= $difficulty === 'medium' ? 'selected' : '' ?>>Medium</option>
                <option value="hard" <?= $difficulty === 'hard' ? 'selected' : '' ?>>Hard</option>
            </select>
        </div>

        <div style="display: flex; flex-direction: column;">
            <label for="category">Category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">-- All --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['category']) ?>" <?= $cat['category'] === $category ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</form>



<?php if (count($filteredQuizzes) > 0): ?>
    <ul>
        <?php foreach ($filteredQuizzes as $q): ?>
            <li>
                <?php if ($q['type'] === 'image'): ?>
                <a href="quizes/pictures.php?quiz_id=<?= $q['id'] ?>">
                    <?= htmlspecialchars($q['title']) ?> (<?= ucfirst($q['difficulty']) ?> | <?= htmlspecialchars($q['category']) ?>)
                </a>
                <?php else: ?>
                <a href="take_quiz.php?quiz_id=<?= $q['id'] ?>">
                    <?= htmlspecialchars($q['title']) ?> (<?= ucfirst($q['difficulty']) ?> | <?= htmlspecialchars($q['category']) ?>)
                </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No quizzes found for the selected filters.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
