<?php
class Quiz {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createQuiz($title, $category, $user_id, $type, $difficulty) {
        $stmt = $this->pdo->prepare("INSERT INTO QUIZZES (title, category, created_by, type, difficulty) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $category, $user_id, $type, $difficulty])) {
            return $this->pdo->lastInsertId();
        }
        return false;
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

    public function getQuizzesByDifficulty($difficulty) {
        $stmt = $this->pdo->prepare("SELECT * FROM QUIZZES WHERE difficulty = ?");
        $stmt->execute([$difficulty]);
        return $stmt->fetchAll();
    }

    public function getDistinctCategories() {
        $stmt = $this->pdo->query("SELECT DISTINCT category FROM QUIZZES");
        return $stmt->fetchAll();
    }

    public function getFilteredQuizzes($difficulty, $category) {
        $sql = "SELECT * FROM QUIZZES WHERE 1=1";
        $params = [];

        if (!empty($difficulty)) {
            $sql .= " AND difficulty = ?";
            $params[] = $difficulty;
        }
        if (!empty($category)) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function deleteQuiz($quizId) {
        // delete answers
        $this->pdo->prepare("DELETE FROM ANSWERS WHERE question_id IN (SELECT id FROM QUESTIONS WHERE quiz_id = ?)")->execute([$quizId]);
        // delete questions
        $this->pdo->prepare("DELETE FROM QUESTIONS WHERE quiz_id = ?")->execute([$quizId]);
        // delete results
        $this->pdo->prepare("DELETE FROM RESULTS WHERE quiz_id = ?")->execute([$quizId]);

        // finally delete the quiz
        $stmt = $this->pdo->prepare("DELETE FROM QUIZZES WHERE id = ?");
        return $stmt->execute([$quizId]);
    }


    public function updateQuiz($quiz_id, $title, $category, $type, $difficulty) {
        $stmt = $this->pdo->prepare("UPDATE QUIZZES SET title = ?, category = ?, type = ?, difficulty = ? WHERE id = ?");
        return $stmt->execute([$title, $category, $type, $difficulty, $quiz_id]);
    }

    public function getRandomQuizId() {
        $stmt = $this->pdo->query("SELECT id FROM QUIZZES ORDER BY RAND() LIMIT 1");
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }

    public function getQuizByType($type) {
        $stmt = $this->pdo->prepare("SELECT * FROM QUIZZES WHERE type = ?");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRandomQuizIdByType($type) {
        $quiz_arr = $this->getQuizByType($type);
        $rand = rand(0, sizeof($quiz_arr)-1);
        return $quiz_arr[$rand]['id'];
    }
}
?>
