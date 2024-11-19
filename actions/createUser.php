<?php 
session_start();

require_once __DIR__ . '/../config/const.php';
require_once __DIR__ . '/../config/conect.php';
require_once __DIR__ . '/../config/tables.php';

$data = $_POST;

if (isset($data['email']) && isset($data['password']) && isset($data['Username'])) {
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'adresse mail n'est pas valide";
    } else {
        $username = $data['Username'];
        $email = $data['email'];
        $password = $data['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Insertion de l'utilisateur dans la table 'user'
            $requete = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $mysqlClient->prepare($requete);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();
            $_SESSION['success'] = 'Utilisateur enregistré avec succès';

            // Récupération des informations de l'utilisateur enregistré
            $recUser = 'SELECT * FROM user WHERE email = :email';
            $stmtt = $mysqlClient->prepare($recUser);
            $stmtt->bindParam(':email', $email);
            $stmtt->execute();
            $userSelected = $stmtt->fetch();

            if ($userSelected) {
                $_SESSION['success'] = 'Nous avons bien récupéré les données de l\'utilisateur';
                $_SESSION['user'] = [
                    "userId" => $userSelected['userId'],
                    "username" => $userSelected['username'],
                    "profilePic" => $userSelected['profilePic'] ?? 'default.png', // Utilisez 'profilePic' pour correspondre à la connexion
                ];
            } else {
                $_SESSION['error'] = 'Nous n\'avons pas pu récupérer les données de l\'utilisateur';
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Erreur lors de l\'enregistrement : ' . $e->getMessage();
        }
    }
} else {
    $_SESSION['error'] = "Veuillez entrer tous les champs pour continuer";
}

header('Location: ../home.php');
exit();
