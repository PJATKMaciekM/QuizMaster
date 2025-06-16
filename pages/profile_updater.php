<link rel="stylesheet" href="../assets/css/style.css">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/** @var PDO $pdo */
require_once '../includes/init.php';
$user = new User($pdo);
$currentUser = $user->getUserById($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $fileTmp = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileDest = "../assets/uploads/" . basename($fileName);
    move_uploaded_file($fileTmp, $fileDest);

    $bio = $_POST['bio'] ?? '';
    $user->updateProfile($_SESSION['user_id'], $fileName, $bio);
    echo "Profile updated!";
    $currentUser = $user->getUserById($_SESSION['user_id']);
}
?>
<?php include '../includes/header.php'; ?>
<h2>Update Profile</h2>
<form method="POST" enctype="multipart/form-data">
    Avatar: <input type="file" name="avatar"><br>
    Bio: <textarea name="bio"><?php echo htmlspecialchars($currentUser['bio'] ?? '') ?></textarea><br>
    <button type="submit">Save</button>
</form>

<?php if (!empty($currentUser['avatar'])): ?>
    <img src="../assets/uploads/<?php echo $currentUser['avatar']; ?>" width="100">
<?php endif; ?>
<?php include '../includes/footer.php'; ?>