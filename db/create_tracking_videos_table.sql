CREATE TABLE tracking_videos
(id INT AUTO_INCREMENT KEY,title VARCHAR(150),channel_title VARCHAR(150), video_id VARCHAR(50), channel_id VARCHAR(50), privacy_status VARCHAR(10), history VARCHAR(500), brand VARCHAR(50), created_at TIMESTAMP,
INDEX video_id USING BTREE (video_id));
