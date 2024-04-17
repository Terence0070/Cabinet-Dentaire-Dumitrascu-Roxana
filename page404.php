<?php 
$metaRobots = '<meta name="robots" content="noindex, nofollow">';
$title = "Erreur 404 !";
require_once ('Include/Menu/header.php'); 
?>

<!-- Header -->
<header class="richblack-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-danger">ERREUR 404 :(</h1>
    </div>
</header>

<section>
    <div class="container text-center d-flex flex-column justify-content-center vh-50">
        <h1>La page que vous recherchez n'existe pas, ou a été supprimée.</h1>
        <h2>Pas de panique, nous vous renvoyons à la page d'accueil dans <span class="text-danger" id="countdown"></span> seconde(s) !<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
</section>

<script>
    var countdown = 6; // Décompte initial en secondes
    var countdownElement = document.getElementById('countdown');

    function startCountdown() {
        countdownElement.innerHTML = countdown;

        if (countdown === 0) {
            window.location.href = '/';
        } else {
            countdown--;
            setTimeout(startCountdown, 1000); // Appeler la fonction toutes les 1 seconde (1000 millisecondes)
        }
    }

    startCountdown();
</script>

<?php 
require_once ('Include/Menu/footer.php'); 
?>