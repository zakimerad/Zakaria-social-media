<?php

require_once __DIR__ . '/functions/imageUrl.php'; 
require_once __DIR__ . '/config/const.php';
require_once __DIR__ . '/config/conect.php';
require_once __DIR__ . '/config/tables.php';

$data = $_POST;

function setupImageUrl($img, $temp): string {
    if (empty($img)) { return ""; }
    
    $directory = '../actions/uploads/';
    $file = basename($img);
    $path = $directory . $file;
    $type = pathinfo($file, PATHINFO_EXTENSION);
    $allowTypes = array("jpg", "png", "gif", "jpeg");
    
    // Vérifications
    if (!is_dir($directory)) {
        return "The destination directory does not exist.";
    }
    
    if (!is_writable($directory)) {
        return "The destination directory is not writable.";
    }
    
    if (!in_array($type, $allowTypes)) {
        return "Unauthorized file type: $type. Allowed types are: " . implode(", ", $allowTypes);
    }
    
    if (!is_file($temp)) {
        return "Temporary file not found.";
    }
    
    if (!move_uploaded_file($temp, $path)) {
        return "Error while moving the file.";
    }
    
    return $file;
}


function setupText($string): string {
    return htmlspecialchars(trim($string));
}


function displayProfilePic($profilePic) {
    return "<img id='imgh' src='" . getImageUrl($profilePic ?? 'default.png') . "' alt='Profile Picture'>";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($data['text']) && isset($_SESSION['user']['userId'])) {
    $personID = $_SESSION['user']['userId'];
    


    
    $image = setupImageUrl($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    $text = setupText($data['text']);
    

    if ($image === "") {
        $_SESSION['error_post'] = "Image upload error.";
    } else {

        $newPost = $mysqlClient->prepare('INSERT INTO post (text, postImage, personId) VALUES (?, ?, ?)');
        $result = $newPost->execute([$text, $image, $personID]);


        if ($result) {
            $_SESSION['success_post'] = "Post created successfully.";
        } else {
            $_SESSION['error_post'] = "Failed to insert into the database.";
        }
    }
}


$query = 'SELECT p.text, p.postImage, u.username, u.profilePic, p.date 
        FROM post p 
        JOIN user u ON p.personId = u.userId 
        ORDER BY p.date DESC'; 

$stmt = $mysqlClient->query($query);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zakariia - Social Posts</title>
    <link rel="stylesheet" href="CSS/acceuille.css">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <a href="#logo" class="logo">Zakariia.</a>
        <nav class="navbar">
            <ul>
                <li><a href="actions/deconnexion.php">Logout</a></li>
            </ul>
        </nav>
        <div class="buttons">
            <?php if (isset($_SESSION['user']['profilePic'])): ?>
                <a href="profile.php">
                    <?= displayProfilePic($_SESSION['user']['profilePic']); ?>
                </a>
            <?php else: ?>
                <div class="buttons">
                    <a href="profile.php" class="log-in"><i class='bx bx-user'></i></a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <section class="couverture">
        <div class="photo-couverture">
            <img src="images/rb_2148361692.png" alt="Cover Image">
        </div>
        <div class="photo">
            <?php if (isset($_SESSION['user']['profilePic'])): ?>
                <?= displayProfilePic($_SESSION['user']['profilePic']); ?>
            <?php else: ?>
                <div class="buttons">
                    <a href="profile.php" class="log-in"><i class='bx bx-user'></i></a>
                </div>
            <?php endif; ?>
        </div>
    </section>
<br>
<br>
    <div class="sasie">
        <div class="Salutation">
            <?php if(isset($_SESSION['user']['username'])): ?>
                <h1 id="salut">Welcome <span><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>! What's new?</h1>
            <?php endif; ?>
        </div>

        <div class="champs-saisie">
            <form action="home.php" method='POST' enctype="multipart/form-data">
                <input type="text" id='message' name='text' placeholder="What's new?" required>
                <input type='file' id='post' name='file' accept="image/*">
                <input type='submit' value="Post">
            </form>
            <!-- <p><?php  $_SESSION['error_post'] ?? ""; ?></p>
            <p><?php  $_SESSION['success_post'] ?? ""; ?></p>  -->
        </div>
    </div>

    <main class="main-container">
        <aside class="comunauter">
            <h3 id="users">Users</h3>
            <?php 
            
            $stmt = $mysqlClient->query("SELECT username FROM user");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <div class="utilisateur">
                        <div class="user-item">
                            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </aside>

        <section class="posts-container">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <div class="post-header">
                            <?= displayProfilePic($post['profilePic']); ?>
                            <div class="user-info">
                                <h3 class="user-name"><?= htmlspecialchars($post['username']) ?></h3>
                                <p class="post-time"><?= date('H \h i', strtotime($post['date'])) ?></p> <!-- Format de l'heure -->
                            </div>
                        </div>
                        <div class="post-content">
                            <p><?= htmlspecialchars($post['text']) ?></p>
                            <?php if (!empty($post['postImage'])): ?>
                                <img src="../actions/uploads/<?= htmlspecialchars($post['postImage']) ?>" alt="Post Image" class="post-image">
                            <?php endif; ?>
                        </div>
                        <div class="post-footer">
                            <button class="like-btn">Like</button>
                            <button class="comment-btn">Comment</button>
                            <button class="share-btn">Share</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No posts to display.</p>
            <?php endif; ?>
        </section>

    </main>

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
