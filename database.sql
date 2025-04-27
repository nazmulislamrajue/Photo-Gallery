CREATE DATABASE photo_gallery;

USE photo_gallery; 

-- Table to store user information
CREATE TABLE images(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    filename VARCHAR(255) NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);