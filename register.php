<?php
session_start();
require 'config.php';

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $account_type = $_POST['account_type']; // user or admin

    if($account_type === 'user'){
        // Check email in users table
        $check = $mysqli->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $error = "Email already registered!";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO users(name,email,password,gender) VALUES(?,?,?,?)");
            $gender = $_POST['gender'];
            $stmt->bind_param("ssss", $name, $email, $password, $gender);
            if($stmt->execute()){
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = 'user';
                header("Location: home.php");
            }
        }
    } elseif($account_type === 'admin'){
        // Check email in admins table
        $check = $mysqli->prepare("SELECT id FROM admins WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            $error = "Admin email already exists!";
        } else {
            $stmt = $mysqli->prepare("INSERT INTO admins(name,email,password) VALUES(?,?,?)");
            $stmt->bind_param("sss", $name, $email, $password);
            if($stmt->execute()){
                $_SESSION['admin_id'] = $stmt->insert_id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = 'admin';
                header("Location: admin.php");
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | E-Learn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Sign Up</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <select name="account_type" required>
            <option value="">Select Account Type</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <!-- Gender only for user accounts -->
        <select name="gender">
            <option value="">Select Gender (User only)</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">Login</a></p>
</div>
</body>
</html>
