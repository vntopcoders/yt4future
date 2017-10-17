CREATE TABLE admin
(id INT AUTO_INCREMENT KEY,
username VARCHAR(50), passcode VARCHAR(50),
INDEX names USING BTREE (username(5), passcode(5) DESC));
