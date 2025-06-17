<?php
require_once '../../includes/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit;
}

$logFile = __DIR__ . '/../../logs/site.log';

if (isset($_POST['clear_logs'])) {
    file_put_contents($logFile, '');
    $logs = [];
    $message = "Logs cleared successfully.";
} else {
    $logs = file_exists($logFile)
        ? array_reverse(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES))
        : [];
}
?>

<?php include '../../includes/header.php'; ?>

<h2>Site Logs</h2>

<?php if (!empty($message)): ?>
    <p style="color: lime;"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" onsubmit="return confirm('Are you sure you want to clear the logs?');">
    <button type="submit" name="clear_logs" style="background: darkred; color: white; padding: 0.5rem 1rem;">🧹 Clear Logs</button>
</form>

<?php if (empty($logs)): ?>
    <p>No logs found.</p>
<?php else: ?>
    <pre style="background-color: #111; color: #0f0; padding: 1rem; max-height: 500px; overflow-y: scroll; border: 1px solid #444;">
<?php foreach ($logs as $line): ?>
    <?= htmlspecialchars($line) . "
" ?>
<?php endforeach; ?>
    </pre>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>
