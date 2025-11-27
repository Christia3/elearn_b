<?php
session_start();
require 'config.php';
include 'navbar.php';

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

// Add Course
if(isset($_POST['add_course'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $stmt = $mysqli->prepare("INSERT INTO courses(title, description) VALUES(?, ?)");
    $stmt->bind_param("ss", $title, $description);
    $stmt->execute();
}

// Add Exercise
if(isset($_POST['add_exercise'])){
    $course_id = $_POST['course_id'];
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];

    $stmt = $mysqli->prepare("INSERT INTO exercises(course_id, question, option_a, option_b, option_c, option_d, correct_answer) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("issssss", $course_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel | E-Learn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Admin Panel</h2>

    <!-- Add Course -->
    <h3>Add New Course</h3>
    <form method="POST">
        <input type="text" name="title" placeholder="Course Title" required>
        <textarea name="description" placeholder="Course Description" required></textarea>
        <button type="submit" name="add_course">Add Course</button>
    </form>

    <!-- Add Exercise -->
    <h3>Add Exercise</h3>
    <form method="POST">
        <select name="course_id" required>
            <option value="">Select Course</option>
            <?php
            $courses = $mysqli->query("SELECT * FROM courses");
            while($c = $courses->fetch_assoc()){
                echo "<option value='".$c['id']."'>".$c['title']."</option>";
            }
            ?>
        </select>
        <input type="text" name="question" placeholder="Question" required>
        <input type="text" name="option_a" placeholder="Option A" required>
        <input type="text" name="option_b" placeholder="Option B" required>
        <input type="text" name="option_c" placeholder="Option C" required>
        <input type="text" name="option_d" placeholder="Option D" required>
        <select name="correct_answer" required>
            <option value="">Correct Answer</option>
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
        </select>
        <button type="submit" name="add_exercise">Add Exercise</button>
    </form>

    <a href="logout.php" class="btn-logout">Logout Admin</a>
</div>
</body>
</html>
