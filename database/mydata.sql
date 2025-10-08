
CREATE DATABASE IF NOT EXISTS mydata;
USE mydata;

CREATE TABLE IF NOT EXISTS trainers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  specialization VARCHAR(50) NOT NULL,
  experience_years INT DEFAULT NULL,
  email VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password_hash VARCHAR(255) DEFAULT NULL,
  age INT DEFAULT NULL,
  mobile VARCHAR(20) DEFAULT NULL,
  role VARCHAR(20) DEFAULT 'user',
  created_at DATETIME DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  submitted_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  date DATE NOT NULL,
  location VARCHAR(150) DEFAULT NULL
);

INSERT INTO trainers (name, specialization, experience_years, email) VALUES
('Hit Goyani', 'Strength Training', 3, 'hit.goyani@fitzone.com'),
('Dhruv Gajera', 'Yoga & Flexibility', 2, 'dhruv.gajera@fitzone.com'),
('Abhi Patel', 'Cardio & Weight Loss', 4, 'abhi.patel@fitzone.com'),
('Dev Savani', 'Zumba & Dance', 1, 'dev.savani@fitzone.com');


INSERT INTO users (name, email, password_hash, age, mobile, role, created_at) VALUES
('Admin User', 'admin@fitzone.com', '', 25, '9998887777', 'admin', NOW()),
('User One', 'user1@gmail.com', '', 20, '9876543210', 'user', NOW()),
('User Two', 'user2@gmail.com', '', 22, '9898989898', 'user', NOW());

INSERT INTO contacts (name, email, message, submitted_at) VALUES
('Test User', 'test@gmail.com', 'Great gym!', NOW()),
('Demo User', 'demo1@gmail.com', 'I love the classes', NOW());

INSERT INTO events (title, description, date, location) VALUES
('Yoga Workshop', 'Morning wellness session', '2025-10-20', 'Main Hall'),
('Fitness Challenge', '7-day transformation event', '2025-11-05', 'Outdoor Arena'),
('Nutrition Talk', 'Healthy diets and meal plans', '2025-11-20', 'Conference Room');

COMMIT;


