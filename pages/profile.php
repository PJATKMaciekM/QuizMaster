<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../classes/User.php';

/** @var PDO $pdo */
$userObj = new User($pdo);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user = $userObj->getUserById($_SESSION['user_id']);

// Fallback avatar if none set
$avatar = $user['avatar'] ? "/assets/uploads/" . $user['avatar'] : "/assets/uploads/default_avatar.png";

// Fetch statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as total, 
    SUM(score) as total_score, 
    SUM(score) / (COUNT(*) * 1.0) * 100 as accuracy 
    FROM RESULTS WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetch();

$created_at = date("F j, Y", strtotime($user['created_at']));
?>

<?php include '../includes/header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2><?php echo htmlspecialchars($user['name']); ?>'s Profile</h2>
    <img src="<?php echo $avatar; ?>" alt="Avatar" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
</div>

<p style="margin-top: 1rem;"><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>

<h3>📊 Stats</h3>
<ul>
    <li>Completed Quizzes: <strong><?php echo $stats['total'] ?? 0; ?></strong></li>
    <li>Accuracy: <strong><?php echo round($stats['accuracy'] ?? 0, 2); ?>%</strong></li>
    <li>Account Created: <strong><?php echo $created_at; ?></strong></li>
</ul>

<div style="margin-top: 2rem;">
    <a href="profile_updater.php" class="button">Update Profile</a>
    <a href="export_user_stats.php" class="button" style="margin-left: 1rem;">Export Stats</a>
</div>

<?php include '../includes/footer.php'; ?>
