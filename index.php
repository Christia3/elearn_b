<?php
session_start();
require 'config.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check users table
    $stmt = $mysqli->prepare("SELECT id, name, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    if(isset($hashed_password) && password_verify($password, $hashed_password)){
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = 'user';
        header("Location: home.php");
        exit();
    } else {
        // Check admins table
        $stmt = $mysqli->prepare("SELECT id, name, password FROM admins WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($admin_id, $admin_name, $admin_password);
        $stmt->fetch();
        $stmt->close();

        if(isset($admin_password) && password_verify($password, $admin_password)){
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['name'] = $admin_name;
            $_SESSION['role'] = 'admin';
            header("Location: admin.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | E-Learn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
</div>
</body>
</html>
