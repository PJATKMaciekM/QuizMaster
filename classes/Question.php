<?php
class Question {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addQuestion($quiz_id, $text) {
        $stmt = $this->pdo->prepare("INSERT INTO QUESTIONS (quiz_id, question_text) VALUES (?, ?)");
        $stmt->execute([$quiz_id, $text]);
        return $this->pdo->lastInsertId();
    }

    public function addQuestionImage($quiz_id, $text, $image_path) {
        $stmt = $this->pdo->prepare("INSERT INTO QUESTIONS (quiz_id, question_text, image_path) VALUES (?, ?, ?)");
        $stmt->execute([$quiz_id, $text, $image_path]);
        return $this->pdo->lastInsertId();
    }

    public function getQuestionsByQuiz($quiz_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM QUESTIONS WHERE quiz_id = ?");
        $stmt->execute([$quiz_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getQuestionById($question_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM QUESTIONS WHERE id = ?");
        $stmt->execute([$question_id]);
        return $stmt->fetch();
    }

    public function updateQuestionText($question_id, $text) {
        $stmt = $this->pdo->prepare("UPDATE QUESTIONS SET question_text = ? WHERE id = ?");
        return $stmt->execute([$text, $question_id]);
    }

    public function deleteQuestion($question_id) {
        $stmt = $this->pdo->prepare("DELETE FROM QUESTIONS WHERE id = ?");
        return $stmt->execute([$question_id]);
    }


}
?>
