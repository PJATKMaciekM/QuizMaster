<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav style="background-color: #1c1c1c; padding: 1rem; border-bottom: 1px solid #333;">
    <div style="max-width: 800px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1rem;">
        <div><a href="/index.php" style="font-weight: bold;">🏆 QuizMaster</a></div>
        <div style="display: flex; gap: 1rem;">
            <a href="/pages/quiz.php">Quizzes</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/pages/accounts/profile.php">Profile</a>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'moderator'): ?>
                    <a href="/pages/admin/panel.php">Admin</a>
                <?php endif; ?>
                <a href="/pages/accounts/logout.php">Logout</a>
            <?php else: ?>
                <a href="/pages/accounts/login.php">Login</a>
                <a href="/pages/accounts/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
