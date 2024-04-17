<?php 
$metaRobots = '<meta name="robots" content="index, follow">';
$title = "Plan";
$metaDescription = "Voici les moyens d'accéder facilement au cabinet dentaire en cas d'handicap ou limitation de transports";
require_once ('Include/Menu/header.php'); 
?>

<!-- Header -->
<header class="pistache-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Plan</h1>
    </div>
</header>

<section id="plan" class="richblack-background pt-4 pb-3">
    <h2 class="fw-bold container text-center text-light">Des bus du réseau <a class="link-success" href="https://www.orizo.fr/">Orizo</a> desservent le cabinet dentaire, se situant au 84800 Avignon, au 26 Rue Rudolph Serkin (à l'arrière de la pharmacie).</p>
    <p class="classic-text text-center">Un ascenseur est accessible pour les personnes en situation d'handicap.</p>
</section>

<section id="avignon_centre" class="grey-background">
    <h4 class="text-center pt-4">Pour <b>Avignon Centre</b>, les bus <b class="text-danger">09</b> et <b class="text-primary">11</b> desservent jusqu'à <b>l'arrêt Carpeaux.</b></h4>
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-6 text-center">
                <img class="rounded border border-dark" style="width:320px;" src=images/09.png>
                <p class="fw-bold display-6 text-danger">Ligne 09</p>
            </div>
            <div class="col-lg-6 text-center">
                <img class="rounded border border-dark" style="width:320px;" src=images/11.png>
                <p class="fw-bold display-6 text-primary">Ligne 11</p>
            </div>
        <hr class="border-top border-dark">
        </div>
    </div>
</section>

<section id="pontet_centre" class="grey-background">
    <h4 class="text-center pt-3">Pour <b>Le Pontet Centre</b>, le bus <b class="text-success">14</b> dessert jusqu'à <b>l'arrêt Renoir.</b></h4>
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-12 text-center">
                <img class="rounded border border-dark" style="width:320px;" src=images/14.png>
                <p class="fw-bold display-6 text-success">Ligne 14</p>
            </div>
        </div>
    </div>
</section>

<section id="moriere_avignon" class="grey-background">
    <div class="container pt-4">
        <hr class="border-top border-dark">
        <h4 class="text-center pt-3">Pour <b>Morières-lès-Avignon</b>, le bus <b class="text-danger">09</b> dessert jusqu'à <b>l'arrêt Renoir.</b></h4>
        <div class="row">
            <div class="col-lg-12 text-center">
                <img class="rounded border border-dark" style="width:320px;" src=images/09-2.png>
                <p class="fw-bold display-6 text-danger">Ligne 09</p>
            </div>
        </div>
    </div>
</section>

<?php 
require_once ('Include/Menu/footer.php'); 
?>