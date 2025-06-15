<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($name, $email, $password) {
        // Check if email already exists
        $check = $this->pdo->prepare("SELECT id FROM USERS WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            return 'email_exists'; // signal duplicate email
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        $stmt = $this->pdo->prepare("
        INSERT INTO USERS (name, email, password_hash, role, verify_token, verified, created_at)
        VALUES (?, ?, ?, 'user', ?, 0, NOW())
    ");
        $result = $stmt->execute([$name, $email, $hash, $token]);

        if ($result) {
            require_once __DIR__ . '/../includes/mailer.php';
            sendVerificationEmail($email, $token);
        }

        return $result;
    }


    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM USERS WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            if (!$user['verified']) {
                // Re-send verification email
                require_once __DIR__ . '/../includes/mailer.php';

                // regenerate token and update DB
                $token = bin2hex(random_bytes(32));
                $update = $this->pdo->prepare("UPDATE USERS SET verify_token = ? WHERE id = ?");
                $update->execute([$token, $user['id']]);

                sendVerificationEmail($email, $token);
                return 'resent_verification';
            }
            return $user;
        }

        return false;
    }



    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM USERS WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $avatar, $bio) {
        $stmt = $this->pdo->prepare("UPDATE USERS SET avatar = ?, bio = ? WHERE id = ?");
        return $stmt->execute([$avatar, $bio, $id]);
    }


}
?>
