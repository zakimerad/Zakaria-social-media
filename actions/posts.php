<?php

require_once __DIR__ . '/../config/conect.php';

$data = $_POST;
$_SESSION['error_post'] = "";

function setupImageUrl($img, $temp): string {
    if (empty($img)) { return ""; }
    $directory = '../actions/uploads/';
    $file = basename($img);
    $path = $directory . $file;
    $type = pathinfo($file, PATHINFO_EXTENSION);
    $allowTypes = array("jpg", "png", "gif", "jpeg");
    
    if (!is_dir($directory) || !is_writable($directory) || !in_array($type, $allowTypes) || !is_file($temp)) {
        return "";
    }
    if (!move_uploaded_file($temp, $path)) { return ""; }
    return $file;
}

function setupText($string): string {
    return htmlspecialchars(trim($string));
}

if (!empty($data['text']) && isset($_SESSION['user']['userId'])) {
    $personID = $_SESSION['user']['userId'];
    $image = setupImageUrl($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    $text = setupText($data['text']);
    
    if ($image === "") {
        $_SESSION['error_post'] = "Erreur de téléchargement de l'image.";
        return;
    }

    $newPost = $mysqlClient->prepare('INSERT INTO post (text, postImage, personId) VALUES (?, ?, ?)');
    
    // Débogage : vérifiez les valeurs avant l'exécution
    var_dump($text, $image, $personID); // Afficher les valeurs
    $result = $newPost->execute([$text, $image, $personID]);
    
    // Débogage : vérifiez si l'insertion a réussi
    if ($result) {
        $_SESSION['success_post'] = "Post créé avec succès.";
    } else {
        $_SESSION['error_post'] = "Échec de l'insertion dans la base de données.";
    }

    // Récupérer les posts
    // Récupérer les posts
$query = 'SELECT p.text, p.postImage, u.username, u.profilePic, p.date 
FROM post p 
JOIN user u ON p.personId = u.userId 
ORDER BY p.date DESC'; 

$stmt = $mysqlClient->query($query);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifiez si des posts ont été récupérés
if ($posts) {
echo '<section class="posts-container">';
foreach ($posts as $post) {
echo '<div class="post-card">';
echo '<div class="post-header">';
echo '<img src="' . htmlspecialchars($post['profilePic']) . '" alt="Photo de profil" class="profile-pic">';
echo '<div class="user-info">';
echo '<h3 class="user-name">' . htmlspecialchars($post['username']) . '</h3>';
echo '<p class="post-time">' . date('H \h i', strtotime($post['date'])) . '</p>';
echo '</div>';
echo '</div>'; // .post-header
echo '<div class="post-content">';
echo '<p>' . htmlspecialchars($post['text']) . '</p>';
if (!empty($post['postImage'])) {
  echo '<img src="../actions/uploads/' . htmlspecialchars($post['postImage']) . '" alt="Image du post" class="post-image">';
}
echo '</div>'; // .post-content
echo '<div class="post-footer">';
echo '<button class="like-btn">Like</button>';
echo '<button class="comment-btn">Commentaire</button>';
echo '<button class="share-btn">Partager</button>';
echo '</div>'; // .post-footer
echo '</div>'; // .post-card
}
echo '</section>'; // .posts-container
} else {
echo '<p>Aucun post trouvé.</p>';
}

} else {
    $_SESSION['error_post'] = "Données manquantes. Veuillez remplir le champ texte et télécharger une image.";
}



// Rediriger ou inclure le fichier qui affiche les posts
 header('Location: ../home.php'); // Assurez-vous de rediriger vers la bonne page
 exit();
