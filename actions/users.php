<?php

require_once __DIR__ . '/../config/const.php';
require_once __DIR__ . '/../config/conect.php';
$tableUser = 'CREATE TABLE IF NOT EXISTS user (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);';

if ($mysqlClient->exec($tableUser) !== false) {
    $_SESSION['reponsebdd'] = "Table 'user' créée ou existe déjà.<br>";
} else {
    $_SESSION['reponsebdd'] = "Erreur lors de la création de la table 'user'.<br>";
}

// Création de la table 'post' si elle n'existe pas
$tablePost = 'CREATE TABLE IF NOT EXISTS post (
    postId INT AUTO_INCREMENT PRIMARY KEY, 
    userId INT NOT NULL, 
    content TEXT,
    image VARCHAR(255), 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (userId) REFERENCES user(userId)
);';



$requet = 'SELECT username FROM user';

$result = $mysqlClient->query($requet);

if ($result) {
    $users = $result->fetchAll();
    if (!empty($users)) {
        $_SESSION['1'] = 'Utilisateurs récupérés avec succès.';
    } else {
        $_SESSION['1'] = 'Aucun utilisateur trouvé dans la table.';
    }
} else {
    $_SESSION['1'] = 'Erreur dans la requête SQL.';
}
?>
