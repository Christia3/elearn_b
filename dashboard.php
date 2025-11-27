<?php
session_start();
require 'config.php';
include 'navbar.php';

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch grades with course names
$query = $mysqli->prepare("
    SELECT g.score, g.date_attempted, c.title 
    FROM grades g
    JOIN courses c ON g.course_id = c.id
    WHERE g.user_id = ?
    ORDER BY g.date_attempted DESC
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | E-Learn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Hi, <?php echo $_SESSION['name']; ?>! Here's your progress:</h2>

    <?php if($result->num_rows > 0): ?>
        <table class="grades-table">
            <tr>
                <th>Course</th>
                <th>Score</th>
                <th>Date Attempted</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['date_attempted']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>You haven't attempted any exercises yet.</p>
    <?php endif; ?>

    <a href="home.php" class="btn">Back to Courses</a>
    <a href="logout.php" class="btn-logout">Logout</a>
</div>
</body>
</html>
