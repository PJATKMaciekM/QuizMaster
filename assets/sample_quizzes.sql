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

-- Single Choice Quizzes
INSERT INTO quizzes (id, title, type, category, difficulty, created_by, created_at)
VALUES (5, 'Capital Cities', 'single', 'Geography', 'easy', 1, NOW()),
       (6, 'Basic Science', 'single', 'Science', 'easy', 1, NOW()),
       (7, 'Famous Authors', 'single', 'Literature', 'medium', 1, NOW()),
       (8, 'Math Basics', 'single', 'Math', 'easy', 1, NOW()),
       (9, 'Human Body', 'single', 'Biology', 'easy', 1, NOW());

-- Multiple Choice Quizzes
INSERT INTO quizzes (id, title, type, category, difficulty, created_by, created_at)
VALUES (10, 'Programming Languages', 'multiple', 'Tech', 'medium', 1, NOW()),
       (11, 'Planet Facts', 'multiple', 'Astronomy', 'medium', 1, NOW()),
       (12, 'Inventions', 'multiple', 'History', 'medium', 1, NOW()),
       (13, 'Animal Traits', 'multiple', 'Biology', 'easy', 1, NOW()),
       (14, 'Nutrition', 'multiple', 'Health', 'easy', 1, NOW());

-- Questions
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (9, 5, 'What is the capital of Poland?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (10, 5, 'What is the capital of Japan?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (11, 6, 'Water freezes at what temperature?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (12, 6, 'The sun is a...', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (13, 7, 'Who wrote ''1984''?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (14, 7, 'Who wrote ''Harry Potter''?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (15, 8, 'What is 9 + 6?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (16, 8, 'What is the square root of 64?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (17, 9, 'How many lungs does a human have?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (18, 9, 'Which organ pumps blood?', 'single');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (19, 10, 'Which of the following are programming languages?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (20, 10, 'Which are strongly typed languages?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (21, 11, 'Which planets are gas giants?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (22, 11, 'Which planets have rings?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (23, 12, 'Who invented the light bulb?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (24, 12, 'Who invented AC motor?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (25, 13, 'Which animals are mammals?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (26, 13, 'Which animals can fly?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (27, 14, 'Which foods are high in protein?', 'multiple');
INSERT INTO questions (id, quiz_id, question_text, question_type) VALUES (28, 14, 'Which foods are carbs?', 'multiple');
-- Answers
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (27, 9, 'Warsaw', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (28, 9, 'Berlin', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (29, 9, 'Madrid', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (30, 9, 'Rome', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (31, 10, 'Tokyo', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (32, 10, 'Kyoto', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (33, 10, 'Osaka', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (34, 10, 'Nagoya', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (35, 11, '0°C', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (36, 11, '100°C', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (37, 11, '50°C', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (38, 12, 'Star', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (39, 12, 'Planet', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (40, 12, 'Comet', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (41, 13, 'George Orwell', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (42, 13, 'Aldous Huxley', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (43, 13, 'Ray Bradbury', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (44, 14, 'J.K Rowling', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (45, 14, 'Emily Brontë', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (46, 14, 'Mary Shelley', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (47, 15, '15', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (48, 15, '16', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (49, 15, '18', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (50, 16, '8', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (51, 16, '9', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (52, 16, '10', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (53, 17, '2', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (54, 17, '1', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (55, 17, '4', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (56, 18, 'Heart', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (57, 18, 'Liver', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (58, 18, 'Brain', 0);
-- Quiz 6: Programming Languages
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (59, 19, 'Python', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (60, 19, 'HTML', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (61, 19, 'Java', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (62, 19, 'C++', 1);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (63, 20, 'Java', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (64, 20, 'JavaScript', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (65, 20, 'C#', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (66, 20, 'Python', 1);

-- Quiz 7: Planet Facts
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (67, 21, 'Jupiter', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (68, 21, 'Saturn', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (69, 21, 'Mars', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (70, 21, 'Venus', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (71, 22, 'Saturn', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (72, 22, 'Jupiter', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (73, 22, 'Earth', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (74, 22, 'Neptune', 1);

-- Quiz 8: Inventions
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (75, 23, 'Thomas Edison', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (76, 23, 'Nikola Tesla', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (77, 23, 'Albert Einstein', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (78, 23, 'Alexander Bell', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (79, 24, 'Nikola Tesla', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (80, 24, 'Edison', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (81, 24, 'Newton', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (82, 24, 'Einstein', 0);

-- Quiz 9: Animal Traits
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (83, 25, 'Dog', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (84, 25, 'Cat', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (85, 25, 'Frog', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (86, 25, 'Shark', 0);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (87, 26, 'Eagle', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (88, 26, 'Penguin', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (89, 26, 'Bat', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (90, 26, 'Ostrich', 0);

-- Quiz 10: Nutrition
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (91, 27, 'Chicken', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (92, 27, 'Eggs', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (93, 27, 'Rice', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (94, 27, 'Almonds', 1);

INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (95, 28, 'Bread', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (96, 28, 'Pasta', 1);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (97, 28, 'Butter', 0);
INSERT INTO answers (id, question_id, answer_text, is_correct) VALUES (98, 28, 'Rice', 1);
