-- FitZone Database SQL Dump

CREATE DATABASE IF NOT EXISTS mydata;
USE mydata;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    age INT DEFAULT NULL,
    mobile VARCHAR(20) DEFAULT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at DATETIME DEFAULT NULL
);

INSERT INTO users (username, email, password, role) VALUES
('adminfit', 'admin@fitzone.com', 'admin123', 'admin'),
('john_doe', 'john@example.com', 'john123', 'user'),
('emma_fitness', 'emma@example.com', 'emma123', 'user');
