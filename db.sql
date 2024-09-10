CREATE DATABASE `school`;

CREATE TABLE teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  -- photo VARCAR(255),
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  email VARCHAR(100),
  -- department VARCHAR(50),
  hire_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE classes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  course_id INT,
  teacher_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id)
    ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id)
    ON DELETE SET NULL
);

CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  -- photo VARCAR(255),
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  email VARCHAR(100),
  enrollment_date DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  class_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id)
    ON DELETE CASCADE,
  FOREIGN KEY (class_id) REFERENCES classes(id)
    ON DELETE CASCADE
);

-- add start_date and end_date to classes table
ALTER TABLE classes
ADD start_date TIMESTAMP NULL
AFTER teacher_id;
ADD end_date TIMESTAMP NULL
AFTER start_date;

-- CL001
ALTER TABLE classes
ADD class_id VARCHAR(5)
AFTER id;

-- C0001
ALTER TABLE courses
ADD course_id VARCHAR(5)
AFTER id;

-- S0000001
ALTER TABLE students
ADD student_id VARCHAR(8)
AFTER id;

-- T0001
ALTER TABLE teachers
ADD teacher_id VARCHAR(5)
AFTER id;

-- Make table with unique key (_0001)
ALTER TABLE classes
ADD UNIQUE (class_id);

ALTER TABLE courses
ADD UNIQUE (course_id);

ALTER TABLE students
ADD UNIQUE (student_id);

ALTER TABLE teachers
ADD UNIQUE (teacher_id);