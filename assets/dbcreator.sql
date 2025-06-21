CREATE DATABASE IF NOT EXISTS quizmaster CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quizmaster;

-- USERS table
CREATE TABLE USERS (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       password_hash VARCHAR(255) NOT NULL,
                       role ENUM('user', 'moderator', 'admin') DEFAULT 'user',
                       avatar VARCHAR(255),
                       bio TEXT,
                       verified TINYINT(1) DEFAULT 0,
                       verify_token VARCHAR(64),
                       reset_token VARCHAR(64),
                       reset_expires DATETIME,
                       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                       arcade_record int default 0
);

-- QUIZZES table
CREATE TABLE QUIZZES (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         title VARCHAR(255) NOT NULL,
                         category VARCHAR(100),
                         difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
                         created_by INT NOT NULL,
                         type ENUM('single', 'multiple', 'text', 'image') NOT NULL,
                         image_path VARCHAR(255),
                         created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (created_by) REFERENCES USERS(id) ON DELETE CASCADE
);

-- QUESTIONS table
CREATE TABLE QUESTIONS (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           quiz_id INT NOT NULL,
                           question_text TEXT NOT NULL,
                           question_type ENUM('single', 'multiple', 'text', 'image') NOT NULL,
                           image_path VARCHAR(255),
                           FOREIGN KEY (quiz_id) REFERENCES QUIZZES(id) ON DELETE CASCADE
);

-- ANSWERS table
CREATE TABLE ANSWERS (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         question_id INT NOT NULL,
                         answer_text TEXT NOT NULL,
                         is_correct TINYINT(1) DEFAULT 0,
                         FOREIGN KEY (question_id) REFERENCES QUESTIONS(id) ON DELETE CASCADE
);

-- RESULTS table (user quiz submissions)
CREATE TABLE RESULTS (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         user_id INT NOT NULL,
                         quiz_id INT NOT NULL,
                         score DECIMAL(5,2),
                         date_taken DATETIME DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
                         FOREIGN KEY (quiz_id) REFERENCES QUIZZES(id) ON DELETE CASCADE
);
