<?php
// Commencer la session
session_start();
// Inclure le fichier de connexion à la base de données
require_once("Include/Database/database.php");
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <?php echo $metaRobots ."\n" ?>
    <meta name="description" content="<?php echo $metaDescription ?> "/>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="icon" type="image/x-icon" href="images/logo.png" />
    <?php $site = " - Cabinet Dentaire Dumitrascu Roxana" ?>
<title><?php echo $title . $site; ?></title>
    <link href="css/ajout.css" rel="stylesheet" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        /* On cache le nom du site avant le script ci-dessous soit bien chargé */
        .hidden-title {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Fonction pour vérifier la taille de l'écran
            function checkScreenWidth() {
                var smallScreen = window.matchMedia("(max-width: 460.02px)").matches;

                if (smallScreen) {
                    $("#roxanaText").text("D. Roxana");
                } else {
                    $("#roxanaText").text("Dumitrascu Roxana");
                }
                
                // Afficher l'élément une fois que le texte est mis à jour
                $("#roxanaText").removeClass("hidden-title");
            }

            // Vérifier la taille de l'écran lors du chargement de la page et lors du redimensionnement
            checkScreenWidth();
            $(window).resize(checkScreenWidth);
        });
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg caribbean-background fixed-top navbar-sm" id="mainNav">
    <div class="container">
        <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="images/logo.png" alt="Logo" class="logo-img img-fluid me-2" style="max-height: 64px; max-width: 80px;">
                <span class="text-white d-flex flex-column">
                    <span style="font-size:12px; margin-left:2px; margin-bottom:-8px">Cabinet Dentaire</span>
                    <h1 id="roxanaText" class="text-white align-self-center my-auto hidden-title">Dumitrascu Roxana</h1>
                </span>
            </a>
        </div>
        <button class="navbar-toggler custom-toggler custom-toggler-text" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">☰</button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul style="font-size:20px;" class="navbar-nav ms-auto text-center custom-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php"><i class="fa-solid fa-house"></i></a>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <span class="nav-bar-separator"></span>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cabinet
                </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-white haut-sous-menu" href="cabinet#conseils">Conseils</a></li>
                        <li><a class="dropdown-item text-white sous-menu" href="cabinet#traitements">Traitements</a></li>
                        <li><a class="dropdown-item text-white bas-sous-menu" href="cabinet#equipements">Equipements</a></li>
                    </ul>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <span class="nav-bar-separator"></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="urgences">Urgences</a>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <span class="nav-bar-separator"></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="plan">Plan</a>
                </li>
                <li class="nav-item d-none d-lg-inline">
                    <span class="nav-bar-separator"></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="contact">Contact</a>
                </li>
                <?php if (isset($_SESSION['idRole']) == 1) { 
                    // Vérifier si l'utilisateur est connecté et admin ?>
                <li class="nav-item d-none d-lg-inline">
                    <span class="nav-bar-separator"></span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-warning fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ADMIN
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item text-white haut-sous-menu" href="admin">Gestion Administrateur</a></li>
                        <li><a class="dropdown-item text-white sous-menu" href="calendrier-modif">Gestion du calendrier</a></li>
                        <li><a class="dropdown-item text-white bas-sous-menu" href="logout">Se déconnecter</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<div style="height:65px;"></div>