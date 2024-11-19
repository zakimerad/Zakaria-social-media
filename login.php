<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Zakariia platforme</title>
    <link rel="stylesheet" href="CSS/signIn.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
</head>
<body>
    <section class="login">
        <div class="login-container">
            <h1>Zakariia.</h1>
            <h3>Connect, share your moments, </h3>
            <h3>and explore new connections</h3>
        </div>
        <div class="container">
            <form class="form" action='actions/log.php' method='POST'>
                <p class="title">Log In </p>
                <p class="message">Signup now and get full access to our app. </p>
                    <div class="flex">
                <label>
                    <input required="" placeholder="" type="text" class="input" name='Username'>
                        <span>Username</span>
                </label> 
                <label>
                    <input required="" placeholder="" type="password" class="input" name='password'>
                    <span>Password</span>
                </label>
                <div class="button">
                    <button class="submit">Submit</button>
                </div>
                <p class="signin">Already have an acount ? <a href="signUp.php" id="change">Sign In</a> </p>
            </form>
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
    <script src="SCRIPT/script.js"></script>
</body>