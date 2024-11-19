<?php
// Supprimer la table 'post' si elle existe
$requete = 'DROP TABLE IF EXISTS post';
$mysqlClient->exec($requete);

// Création de la table 'user' si elle n'existe pas
$tableUser = "CREATE TABLE IF NOT EXISTS user (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profilePic VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($mysqlClient->exec($tableUser) !== false) {
    $_SESSION['reponsebdd'] = "Table 'user' créée ou existe déjà.<br>";
} else {
    $_SESSION['reponsebdd'] = "Erreur lors de la création de la table 'user'.<br>";
}

// Création de la table 'post' après suppression
$tablePost = "CREATE TABLE IF NOT EXISTS post(
    postId INT(11) NOT NULL AUTO_INCREMENT,
    text TEXT NOT NULL,
    postImage VARCHAR(256),
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    personId INT(11),
    PRIMARY KEY (postId),
    FOREIGN KEY (personId) REFERENCES user(userId)
);";

if ($mysqlClient->exec($tablePost) !== false) {
    $_SESSION['reponsebdd'] .= "Table 'post' créée ou existe déjà.<br>";
} else {
    $_SESSION['reponsebdd'] .= "Erreur lors de la création de la table 'post'.<br>";
}
?>
