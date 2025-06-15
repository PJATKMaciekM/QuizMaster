<?php
class Question {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addQuestion($quiz_id, $text, $type) {
        $stmt = $this->pdo->prepare("INSERT INTO QUESTIONS (quiz_id, question_text, question_type) VALUES (?, ?, ?)");
        return $stmt->execute([$quiz_id, $text, $type]);
    }

    public function getQuestionsByQuiz($quiz_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM QUESTIONS WHERE quiz_id = ?");
        $stmt->execute([$quiz_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
