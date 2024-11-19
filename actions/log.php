<?php


require_once __DIR__ . '/../config/const.php';
require_once __DIR__ . '/../config/conect.php';
require_once __DIR__ . '/../config/tables.php';

$data = $_POST;

if (isset($data['Username']) && isset($data['password'])) {
    $username = $data['Username'];
    $password = $data['password'];
    
    $stmt = $mysqlClient->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->execute(['username' => $username]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = [
            'userId' => $user['userId'],
            'username' => $user['username'],
            'profilePic' => $user['profilePic'] ?? 'default.png' 
        ];  
        
        
        header('Location: ../home.php');
        exit();
    } else {
        $_SESSION['error'] = 'Nom d\'utilisateur ou mot de passe incorrect';
        header('Location: ../login.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Veuillez remplir tous les champs pour continuer.';
    header('Location: ../login.php');
    exit();
}
