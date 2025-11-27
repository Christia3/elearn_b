<?php
session_start();
require 'config.php';
include 'navbar.php';

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

// Get course ID from URL
if(!isset($_GET['id'])){
    header("Location: home.php");
    exit();
}

$course_id = intval($_GET['id']);

// Fetch course info
$course_stmt = $mysqli->prepare("SELECT * FROM courses WHERE id=?");
$course_stmt->bind_param("i", $course_id);
$course_stmt->execute();
$course_result = $course_stmt->get_result();
$course = $course_result->fetch_assoc();

// Fetch exercises
$exercises_stmt = $mysqli->prepare("SELECT * FROM exercises WHERE course_id=?");
$exercises_stmt->bind_param("i", $course_id);
$exercises_stmt->execute();
$exercises_result = $exercises_stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $course['title']; ?> | E-Learn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2><?php echo $course['title']; ?></h2>
    <p><?php echo $course['description']; ?></p>

    <h3>Exercises</h3>

    <?php if($exercises_result->num_rows > 0): ?>
        <form method="POST" action="submit.php">
            <?php while($exercise = $exercises_result->fetch_assoc()): ?>
                <div class="exercise-card">
                    <p><strong><?php echo $exercise['question']; ?></strong></p>
                    <label><input type="radio" name="answer[<?php echo $exercise['id']; ?>]" value="a" required> <?php echo $exercise['option_a']; ?></label><br>
                    <label><input type="radio" name="answer[<?php echo $exercise['id']; ?>]" value="b"> <?php echo $exercise['option_b']; ?></label><br>
                    <label><input type="radio" name="answer[<?php echo $exercise['id']; ?>]" value="c"> <?php echo $exercise['option_c']; ?></label><br>
                    <label><input type="radio" name="answer[<?php echo $exercise['id']; ?>]" value="d"> <?php echo $exercise['option_d']; ?></label>
                </div>
            <?php endwhile; ?>
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <button type="submit" name="submit_answers">Submit Answers</button>
        </form>
    <?php else: ?>
        <p>No exercises available for this course.</p>
    <?php endif; ?>

    <a href="home.php" class="btn">Back to Dashboard</a>
</div>
</body>
</html>
