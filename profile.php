<?php
session_start();
require 'config.php';



if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_stmt = $mysqli->prepare("SELECT * FROM users WHERE id=?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch user grades
$grades_stmt = $mysqli->prepare("
    SELECT g.score, g.date_attempted, c.title AS course_name
    FROM grades g
    JOIN courses c ON g.course_id = c.id
    WHERE g.user_id=?
    ORDER BY g.date_attempted DESC
");
$grades_stmt->bind_param("i", $user_id);
$grades_stmt->execute();
$grades_result = $grades_stmt->get_result();
?>

<?php include 'navbar.php'; ?>

<div class="container profile-container">
    <h2>Profile</h2>

    <div class="profile-info">
        <h3>User Information</h3>
        <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Gender:</strong> <?php echo ucfirst($user['gender']); ?></p>
    </div>

    <div class="profile-grades">
        <h3>Progress & Scores</h3>
        <?php if($grades_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Score</th>
                        <th>Date Attempted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($grade = $grades_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $grade['course_name']; ?></td>
                            <td><?php echo $grade['score']; ?>%</td>
                            <td><?php echo date("d M Y", strtotime($grade['date_attempted'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No attempts yet. Start practicing to see your scores here!</p>
        <?php endif; ?>
    </div>

    <a href="home.php" class="btn">Back to Dashboard</a>
</div>
