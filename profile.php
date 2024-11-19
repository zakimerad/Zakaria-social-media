<?php
session_start();
require_once __DIR__ . '/functions/imageUrl.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zakariia - Social Posts</title>
    <link rel="stylesheet" href="CSS/profile.css">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<header class="header">
    <a href="#logo" class="logo">Zakariia.</a>
    <nav class="navbar">
        <ul>
            <li><a href="home.php">Home</a></li>
        </ul>
    </nav>
    <div class="buttons">
        <?php if (isset($_SESSION['user']['profilePic'])): ?>
            <img id="imgh" src="<?php echo getImageUrl($_SESSION['user']['profilePic'] ?? 'default.png'); ?>" >
        <?php else: ?>
            <a href="profile.php" class="log-in"><i class='bx bx-user'></i></a>
        <?php endif; ?>
    </div>
</header>

<section class="main-container">
    <div class="settings-container">
        <h3 id="users">Settings</h3>
        
        <?php if (isset($_SESSION['update_message'])): ?>
            <p class="update-message"><?php echo htmlspecialchars($_SESSION['update_message']); ?></p>
            <?php unset($_SESSION['update_message']); ?>
        <?php endif; ?>
        
        <div class="settings-option">
            <h4>Change Username</h4>
            <form action="actions/changeUsername.php" method="POST">
                <input type="text" name="Username" placeholder="Enter new username" required>
                <input type="submit" value="Update Username">
            </form>
        </div>
        
        <div class="settings-option">
            <h4>Change Profile Picture</h4>
            <form action="actions/changerpdp.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" accept="image/*" required>
                <input type="submit" name='submit' value="Update Profile Picture">
            </form>
        </div>
    </div>
    
    <div class="illustration">
        <img src="images/Preferences-amico (2).png" alt="Settings Illustration">
    </div>
</section>

<footer class="footer">
    <div class="footer-container">
        <p>&copy; 2024 Zakariia. All rights reserved.</p>
        <ul class="social-media">
            <li><a href="#facebook"><i class='bx bxl-facebook'></i></a></li>
            <li><a href="#twitter"><i class='bx bxl-twitter'></i></a></li>
            <li><a href="#instagram"><i class='bx bxl-instagram'></i></a></li>
        </ul>
        <nav class="footer-nav">
            <ul>
                <li><a href="#about">About Me</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#privacy">Privacy Policy</a></li>
            </ul>
        </nav>
    </div>
</footer>
</body>
</html>
