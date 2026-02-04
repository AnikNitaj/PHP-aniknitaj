

CREATE DATABASE IF NOT EXISTS `db personal project`;
USE `db personal project`;


CREATE TABLE IF NOT EXISTS photos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    filename VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO photos (title, description, filename) VALUES
('Sample Photo 1', 'This is a sample photo description', 'sample1.jpg'),
('Sample Photo 2', 'Another beautiful sample photo', 'sample2.jpg');
