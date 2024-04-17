<head>
    <meta name="robots" content="noindex, nofollow">
</head>
<?php
// Démarrage de la session (sait-on jamais)
session_start();

// Détruire toutes les données de la session
session_destroy();

// Redirigez l'utilisateur vers la page de confirmation de déconnexion
header('Location: deconnexion.php');
exit();
?>