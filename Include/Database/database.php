<?php
require_once("config.php");

// Créer une connexion
$connexion = mysqli_connect($server, $user, $password, $dbname);

// Vérifier la connexion
if (!$connexion) {
    die("La connexion à la base de données a échoué. Veuillez contacter l'administrateur du site.");
    header('Location: index.php');
}

// Définir l'encodage en UTF-8
mysqli_set_charset($connexion, "utf8");
?>