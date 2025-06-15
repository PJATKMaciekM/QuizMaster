<?php
class Quiz {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createQuiz($title, $category, $created_by, $type, $image_path = null) {
        $stmt = $this->pdo->prepare("INSERT INTO QUIZZES (title, category, created_by, type, image_path, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$title, $category, $created_by, $type, $image_path]);
    }

    public function getQuizById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM QUIZZES WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllQuizzes() {
        $stmt = $this->pdo->query("SELECT * FROM QUIZZES");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
