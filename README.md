# E-Learn Platform

## Project Description
**E-Learn** is a web-based learning platform built using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**.  
It allows students to:

- Register and log in
- Access organized course notes
- Attempt exercises and quizzes
- Receive immediate grading
- Track performance on a personal dashboard

Admins can manage courses, add notes, create exercises, and view student performance.

This project is designed for **primary & secondary students, self-learners, and teachers** who want a simple online learning environment.

---

## Features

### User Features
- User registration and login
- View available courses
- Access course notes
- Take quizzes and exercises
- Receive immediate feedback
- Track progress and grades

### Admin Features
- Add new courses
- Add notes to courses
- Add exercises to courses
- View all student performance

---

## Technologies Used
- **Backend:** PHP (MySQLi)  
- **Frontend:** HTML, CSS, JavaScript  
- **Database:** MySQL  
- **Server:** XAMPP (Apache + MySQL)  

---

## Folder Structure

elearn_b/
│
├─ index.php # Login page
├─ register.php # Registration page
├─ home.php # User dashboard
├─ course.php # Course details and exercises
├─ submit.php # Exercise submission
├─ profile.php # User profile page
├─ admin.php # Admin panel
├─ add_note.php # Admin add notes page
├─ config.php # Database connection
├─ style.css # Styles for all pages
├─ elearn_db.sql # SQL database file
└─ README.md # Project documentation


---

## Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/Christia3/e-learn-platform.git

2. Move to XAMPP htdocs

Copy the elearn_b folder to:

C:\xampp\htdocs\elearn_b

3. Create MySQL Database

Open phpMyAdmin (http://localhost/phpmyadmin) and:

Click Databases → Create Database → Name it elearn.

Go to the Import tab → choose elearn_db.sql from the project folder → click Go.

4. Configure config.php

Open config.php and set your MySQL credentials:

<?php
$mysqli = new mysqli("localhost", "root", "", "elearn_b");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

5. Start XAMPP

Start Apache and MySQL services from the XAMPP control panel.

6. Access the Project

Open your browser and navigate to:

http://localhost/elearn_b

Database Setup (SQL)
-- Create Database
CREATE DATABASE IF NOT EXISTS elearn_b;
USE elearn_b;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    gender VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Exercises table
CREATE TABLE exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    question TEXT NOT NULL,
    options TEXT NOT NULL,
    answer VARCHAR(255) NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Grades table
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    score INT NOT NULL,
    date_attempted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Notes table
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(100),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Default Admin Account
-- Password: admin123
INSERT INTO admins (name, email, password) VALUES
('Admin', 'admin@example.com', '$2y$10$V1O3RrKX/N1R2iXKbr5zYe6L7V59g5/3pO5e2K1FkaDkrz.ZpMk1K');

Default Login Credentials

Admin

Email: admin@example.com
Password: admin123


User

Users can register using the signup page.

Usage
As a User

Register → Login

Select a course

Read notes and complete exercises

View your progress on the dashboard

Edit profile if needed

As an Admin

Login as admin

Add courses

Add notes to courses

Add exercises to courses

View student grades and performance

Author:

Christian Ishimwe Ntwali
GitHub: https://github.com/Christia3
