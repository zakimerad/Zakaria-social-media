<?php


require_once __DIR__ . '/../config/const.php';
require_once __DIR__ . '/../config/conect.php';
require_once __DIR__ . '/../config/tables.php';
require_once __DIR__ . '/../functions/imageUrl.php';

echo "<pre>";
print_r($_SESSION['user']);
echo "</pre>";

$data = $_POST;
$_SESSION['upload'] = "";
$directory = __DIR__ . "/../actions/uploads/";


if (!isset($data['submit'])) {
    echo "Le formulaire n'a pas été soumis.<br>";
}

if (empty($_FILES['file']['name'])) {
    echo "Aucune image n'a été sélectionnée pour le téléchargement.<br>";
}

if (!isset($_SESSION['user']['userId'])) {
    echo "L'utilisateur n'est pas connecté.<br>";
}


if (isset($data['submit']) && !empty($_FILES['file']['name']) && isset($_SESSION['user']['userId'])) {
    $file = basename($_FILES['file']['name']);
    $path = $directory . $file;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $tempName = $_FILES['file']['tmp_name'];
    
    if (!is_dir($directory) || !is_writable($directory)) {
        $_SESSION['upload'] = "Le dossier n'existe pas ou les droits d'écriture sont restreints";
    } else {
        if (!in_array(strtolower($type), $allowTypes)) { 
            echo $_SESSION['upload'] = "Type de fichier non pris en charge";
        } else {
            if (move_uploaded_file($tempName, $path)) {
                $insert = $mysqlClient->prepare("UPDATE user SET profilePic = :imageUrl WHERE userId = :userId");
                $result = $insert->execute([
                    "imageUrl" => $file,
                    "userId" => $_SESSION['user']['userId']
                ]);
                
                if ($result) {
                    $_SESSION["user"]["profilePic"] = $file; 
                    echo $_SESSION['upload'] = "Image téléchargée avec succès";
                } else {
                    echo $_SESSION['upload'] = "Nous n'avons pas pu enregistrer la photo";
                }
            } else {
                echo $_SESSION['upload'] = "Oups, nous avons eu un problème lors du téléchargement de l'image";
            }
        }
    }
} else {
    echo $_SESSION['upload'] = "Aucune image n'a été envoyée ou l'utilisateur n'est pas connecté";
}


header("Location: ../profile.php");
exit();
