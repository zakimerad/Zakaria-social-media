<?php


require_once __DIR__ . '/../config/const.php';
require_once __DIR__ . '/../config/conect.php';
require_once __DIR__ . '/../config/tables.php';

$data = $_POST;

if (isset($data['Username']) && !empty($data['Username'])) {
    $username2 = $data['Username']; 

    if (isset($_SESSION['user']['username']) && isset($_SESSION['user']['userId'])) {
        $_SESSION['user']['username'] = $username2;

        
        $requete = 'UPDATE user SET username = :username WHERE userId = :userId';
        $stmt = $mysqlClient->prepare($requete);

        
        $stmt->execute([
            ':username' => $username2,
            ':userId' => $_SESSION['user']['userId']
        ]);
        header('Location: ../profile.php');
        exit();
    } else {
        echo "Erreur : Session utilisateur non définie.";
    }
}
?>
