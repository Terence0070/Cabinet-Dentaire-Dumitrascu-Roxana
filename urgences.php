<?php 
$metaRobots = '<meta name="robots" content="index, follow">';
$title = "Urgences";
$metaDescription = "Que faire en cas d'urgence ?";
require_once ('Include/Menu/header.php'); 
?>

<!-- Header -->
<header class="pistache-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Urgences</h1>
    </div>
</header>



<section id="urgences" class="grey-background">
        <div class="col-12 pt-5">
            <img src="images/urgences.jpg" class="mx-auto rounded-pill border border-dark d-block" style="max-height:250px;">
        </div>
    <div class="container pb-4 pt-5">
        <div class="row">
            <p class="display-6 text-uppercase text-center fw-bold">Un service de garde est organisé <span class="text-danger">les dimanches et jours fériés</span> par le Conseil de l'Ordre Départemental des Chirurgiens-Dentistes.</p>
            <p class="display-6 mt-5 text-uppercase text-center fw-bold">En cas d'urgence, appelez le <span class="text-danger">04 90 31 43 43</span> dentiste de garde les week-end et jours fériés uniquement</p>
        </div>
    </div>
</section>

<?php 
require_once ('Include/Menu/footer.php'); 
?>