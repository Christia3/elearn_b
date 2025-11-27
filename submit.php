<?php
session_start();
require 'config.php';
include 'navbar.php';

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['submit_answers'])){
    $user_id = $_SESSION['user_id'];
    $course_id = intval($_POST['course_id']);
    $answers = $_POST['answer'];
    $score = 0;

    foreach($answers as $exercise_id => $user_answer){
        $exercise_stmt = $mysqli->prepare("SELECT correct_answer FROM exercises WHERE id=?");
        $exercise_stmt->bind_param("i", $exercise_id);
        $exercise_stmt->execute();
        $exercise_stmt->bind_result($correct_answer);
        $exercise_stmt->fetch();
        $exercise_stmt->close();

        if($user_answer === $correct_answer){
            $score++;
        }
    }

    // Store score
    $insert_stmt = $mysqli->prepare("INSERT INTO grades(user_id, course_id, score) VALUES(?,?,?)");
    $insert_stmt->bind_param("iii", $user_id, $course_id, $score);
    $insert_stmt->execute();
    $insert_stmt->close();

    // Show results
    echo "<div class='container'>
            <h2>Results</h2>
            <p>Your score: <strong>$score</strong></p>
            <a href='home.php' class='btn'>Back to Dashboard</a>
          </div>";
}
?>
