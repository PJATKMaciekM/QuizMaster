<?php
class Admin {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM USERS");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteQuiz($quiz_id) {
        $stmt = $this->pdo->prepare("DELETE FROM QUIZZES WHERE id = ?");
        return $stmt->execute([$quiz_id]);
    }

    public function exportQuizData() {
        $stmt = $this->pdo->query("SELECT * FROM QUIZZES");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function logAction($user_id, $action) {
        $stmt = $this->pdo->prepare("INSERT INTO LOGS (user_id, action, timestamp) VALUES (?, ?, NOW())");
        $stmt->execute([$user_id, $action]);
    }
}
?>
