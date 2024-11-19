<?php
session_start();
require_once 'const.php';

try {
    
    $mysqlClient = new PDO(sprintf('mysql:host=%s;port=%s;charset=utf8', HOST, PORT), USER, PASSWORD);
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $mysqlClient->exec('CREATE DATABASE IF NOT EXISTS ' . NAME);
    
    
    $mysqlClient->exec('USE ' . NAME);


    $_SESSION['bddReponse'] = 'Base de données créée avec succès et connexion réussie.';
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}
