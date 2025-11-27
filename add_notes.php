<?php
session_start();
require 'config.php';
include 'navbar.php';

// Only admin can access
if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['add_note'])){
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $mysqli->prepare("INSERT INTO notes(course_id, title, content) VALUES(?,?,?)");
    $stmt->bind_param("iss", $course_id, $title, $content);
    if($stmt->execute()){
        $success = "Note added successfully!";
    } else {
        $error = "Failed to add note.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Notes | E-Learn Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add Notes to a Course</h2>

    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

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

        <input type="text" name="title" placeholder="Note Title" required>
        <textarea name="content" placeholder="Note Content" rows="6" required></textarea>

        <button type="submit" name="add_note" class="btn-submit">Add Note</button>
    </form>

    <a href="admin.php" class="btn">Back to Admin Panel</a>
</div>
</body>
</html>
