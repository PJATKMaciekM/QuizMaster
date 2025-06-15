INSERT INTO QUIZZES (id, title, category, created_by, type, created_at)
VALUES (1, 'General Knowledge', 'Trivia', 1, 'single', '2025-06-15 18:33:05');
INSERT INTO QUIZZES (id, title, category, created_by, type, created_at)
VALUES (2, 'Math Basics', 'Math', 1, 'multiple', '2025-06-15 18:33:05');
INSERT INTO QUIZZES (id, title, category, created_by, type, created_at)
VALUES (3, 'Programming', 'Technology', 1, 'single', '2025-06-15 18:33:05');
INSERT INTO QUESTIONS (id, quiz_id, question_text, question_type)
VALUES (1, 1, 'What is the capital of France?', 'single');
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (1, 1, 'Paris', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (2, 1, 'Berlin', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (3, 1, 'Rome', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (4, 1, 'Madrid', 0);
INSERT INTO QUESTIONS (id, quiz_id, question_text, question_type)
VALUES (2, 1, 'Which ocean is the largest?', 'single');
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (5, 2, 'Atlantic', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (6, 2, 'Indian', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (7, 2, 'Pacific', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (8, 2, 'Arctic', 0);
INSERT INTO QUESTIONS (id, quiz_id, question_text, question_type)
VALUES (3, 2, 'Select all prime numbers:', 'multiple');
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (9, 3, '2', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (10, 3, '3', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (11, 3, '4', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (12, 3, '5', 1);
INSERT INTO QUESTIONS (id, quiz_id, question_text, question_type)
VALUES (4, 2, 'Which are even numbers?', 'multiple');
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (13, 4, '1', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (14, 4, '2', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (15, 4, '3', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (16, 4, '4', 1);
INSERT INTO QUESTIONS (id, quiz_id, question_text, question_type)
VALUES (5, 3, 'What language is primarily used for web development?', 'single');
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (17, 5, 'Python', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (18, 5, 'PHP', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (19, 5, 'C++', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (20, 5, 'Swift', 0);
INSERT INTO QUESTIONS (id, quiz_id, question_text, question_type)
VALUES (6, 3, 'Which is not a programming language?', 'single');
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (21, 6, 'JavaScript', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (22, 6, 'Ruby', 0);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (23, 6, 'HTML', 1);
INSERT INTO ANSWERS (id, question_id, answer_text, is_correct)
VALUES (24, 6, 'Kotlin', 0);