create table recepies (id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(255),
                       instructions TEXT
);
CREATE TABLE ingredients_recepies (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             recepie_id INT NOT NULL,
                             ingredient VARCHAR(255),
                             FOREIGN KEY (recepie_id) REFERENCES recepies(id) ON DELETE CASCADE
);