<?php
/** @var PDO $pdo */
require_once '../../includes/session.php';
require_once '../../config/db.php';
require_once '../../includes/logger.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../accounts/login.php");
    exit;
}

$message = "";

// Handle role change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_role'])) {
    $stmt = $pdo->prepare("UPDATE USERS SET role = ? WHERE id = ?");
    if ($stmt->execute([$_POST['new_role'], $_POST['user_id']])) {
        $message = "Role updated successfully.";
        logMessage("Admin changed role for user ID {$_POST['user_id']} to {$_POST['new_role']}", "INFO");
    }
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM USERS WHERE id = ?");
    if ($stmt->execute([$delete_id])) {
        $message = "User deleted successfully.";
        logMessage("Admin deleted user ID $delete_id", "WARNING");
    }
}

// Fetch all users
$stmt = $pdo->query("SELECT id, email, role, created_at FROM USERS");
$users = $stmt->fetchAll();
?>

<?php include '../../includes/header.php'; ?>

    <h2>Manage Users</h2>

<?php if ($message): ?>
    <p style="color: lime;"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

    <table style="width: 100%; background-color: #1a1a1a; color: #fff;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Change Role</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <form method="POST" style="display: inline-flex; gap: 0.25rem;">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <select name="new_role" style="padding: 2px; font-size: 0.9em;">
                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                <option value="moderator" <?= $user['role'] === 'moderator' ? 'selected' : '' ?>>Moderator</option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <button type="submit" style="padding: 2px 6px; font-size: 0.9em;">✓</button>
                        </form>
                    <?php else: ?>
                        <em>Cannot change own role</em>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                        <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                    <?php else: ?>
                        <em>Current user</em>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php include '../../includes/footer.php'; ?>