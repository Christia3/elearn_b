<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isUser = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['admin_id']);
?>

<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">
            <a href="<?php echo $isAdmin ? 'admin.php' : 'home.php'; ?>">E-Learn</a>
        </div>
        <ul class="nav-links">
            <?php if($isUser): ?>
                <li><a href="home.php">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="btn-logout-small">Logout</a></li>
            <?php elseif($isAdmin): ?>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="add_notes.php">Add Notes</a></li>
                <li><a href="logout.php" class="btn-logout-small">Logout</a></li>
            <?php else: ?>
                <li><a href="index.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
