<?php
class Answer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addAnswer($question_id, $text, $is_correct) {
        $stmt = $this->pdo->prepare("INSERT INTO ANSWERS (question_id, answer_text, is_correct) VALUES (?, ?, ?)");
        return $stmt->execute([$question_id, $text, $is_correct]);
    }

    public function getAnswersByQuestion($question_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ANSWERS WHERE question_id = ?");
        $stmt->execute([$question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
