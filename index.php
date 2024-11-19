<?php 

require_once 'config/const.php';
require_once 'config/conect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Zakariia platforme</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
</head>
<body>
    <header class="header">
        <a href="#logo" class="logo">Zakariia.</a>
        <nav class="navbar">
            <ul>
            
            </ul>
        </nav>
        <div class="buttons">
            <div class="btn1"><a href="signUp.php" class="sign-in">Sign up</a></div>
            
            <div class="btn2"><a class="log-in" href="login.php">Log in</a></div>
        </div>
    </header>
    <section class="home" id="home">
        <div class="home-container">
            <h3>Welcome to <span>My web site</span></h3>
            <h1>Share Your Moments with the World</h1>
            <h3>Connect, Share, <span>and Discover</span></h3>
            <p>Join our vibrant community where you can post your photos, share your thoughts, and discover what your friends and other users love. Create connections, express yourself, and find inspiration every day.</p>
            <br>
            <div class="buttons">
            <div class="btn1"><a class="sign-in" href="login.html">Sign in</a></div>
            </div>
        </div>
        <div class="home-img">
            <img src="images/young-people-waving-hand-together.png" alt="">
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