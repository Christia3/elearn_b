<?php
session_start();
require 'config.php';
include 'navbar.php';

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

// Fetch all courses from database
$courses = $mysqli->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | E-Learn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
    <h3>Available Courses</h3>

    <div class="courses">
        <?php if($courses->num_rows > 0): ?>
            <?php while($course = $courses->fetch_assoc()): ?>
                <div class="course-card">
                    <h4><?php echo $course['title']; ?></h4>
                    <p><?php echo $course['description']; ?></p>
                    <a href="course.php?id=<?php echo $course['id']; ?>" class="btn">Open Course</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No courses available. Admin will add them soon!</p>
        <?php endif; ?>
    </div>

    <a href="logout.php" class="btn-logout">Logout</a>
</div>
</body>
</html>
