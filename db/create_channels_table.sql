CREATE TABLE channels(id INT AUTO_INCREMENT KEY,channel_name VARCHAR(150),
channel_id VARCHAR(50), access_token VARCHAR(100), status TINYINT(1),
history VARCHAR(500), brand VARCHAR(50), history_started_date TIMESTAMP, INDEX channel_id USING BTREE (channel_id));
