-- Create database school if it does not exist
CREATE DATABASE IF NOT EXISTS school;

USE school;

-- Table to store student information
CREATE TABLE `students` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL,
    `last_name` varchar(255) NOT NULL,
    `date_of_birth` DATE NOT NULL,
    `email` varchar(255) NOT NULL
);

-- Table to store student to subjects relationships in different semesters
CREATE TABLE `student_subjects` (
    `id_student` int NOT NULL,
    `subject` enum ('mathematics', 'english', 'science', 'art') NOT NULL,
    `semester` int NOT NULL
);

-- Insert sample data into the students table
INSERT INTO students (name, last_name, date_of_birth, email) VALUES
('John', 'Doe', '2000-05-15', 'john.doe@example.com'),
('Alice', 'Smith', '1999-10-20', 'alice.smith@example.com'),
('Bob', 'Johnson', '2001-03-08', 'bob.johnson@example.com'),
('Emily', 'Brown', '2002-08-25', 'emily.brown@example.com'),
('Michael', 'Davis', '2000-11-12', 'michael.davis@example.com');

-- Insert sample data into the student_subjects table
INSERT INTO student_subjects (id_student, subject, semester) VALUES
(1, 'mathematics', 1),
(1, 'english', 1),
(2, 'science', 1),
(3, 'art', 2),
(3, 'english', 2),
(2, 'mathematics', 2),
(4, 'english', 1),
(4, 'science', 1);