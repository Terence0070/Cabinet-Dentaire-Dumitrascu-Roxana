<?php
$metaRobots = '<meta name="robots" content="index, follow">';
$title = "Accueil";
$metaDescription = "Bienvenue sur le site web au cabinet dentaire d'Avignon Dumitrascu Roxana";
require_once ('Include/Menu/header.php');

// Inclure la classe Schedule
require_once ('Include/Modele/Schedule.php');

// Créer une instance de la classe Schedule avec la connexion à la base de données
$schedule = new Schedule($connexion);
?>

<header class="pistache-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Bienvenue au cabinet dentaire Dumitrascu Roxana</h1>
        <h2 class="display-6 fw-bold text-danger">SITE EN CONSTRUCTION !</h2>
    </div>
</header>

<?php
/* if (session_status() == PHP_SESSION_ACTIVE) {
    // Afficher le contenu de la session (pour déboguer)
    echo "La session est active. Contenu de la session : ";
    print_r($_SESSION);
} else {
    echo "La session n'est pas active.";
} */
?>

<section id="cabinet" class="grey-background">
    <div class="container pt-3">
        <p class="large classic-text text-justify"><span class="fw-bold pistache-text">Le cabinet dentaire</span> est situé à proximité du lycée René. <span class="fw-bold pistache-text">Le plateau technique</span> est composé de :</p>
        <ul class="classic-text">
            <li>2 salles de soins</li>
            <li>1 stérilisation centrale (thermodésinfecteur / ensachage / autoclaves)</li>
            <li>1 radio panoramique numérique 2D</li>
            <li>1 Caméra d’empreinte numérique</li>
        </ul>

        <p class="classic-text text-justify">Le Docteur Dumitrascu soigne les enfants à partir de 8 ans quand si possible dans le cas contraire nous vous adresserons chez des pédodontistes.</p>

        <p class="classic-text text-justify">Se rendre chez un chirurgien dentiste pour des soins dentaires peut être source d’appréhension chez de nombreuses personnes, inquiètes des actes à effectuer en elles-mêmes ou encore du prix.</p>

        <p class="classic-text text-justify">Un bilan complet effectué afin  de vous proposer un programme de soins sur mesure, 
        Cette approche globale nous permet non seulement de vous proposer des soins adaptés qui répondront à vos attentes, mais aussi de vous rassurer et de vous proposer, au besoin, une entente financière de type paiement en plusieurs fois pour que vous puissiez accéder aux soins dont vous avez besoin.
        Surtout, nous vous proposons un partenariat sur le long terme, avec un suivi régulier pour une santé buccodentaire durable. Loin des soins ponctuels réalisés au coup par coup, nous vous informons dès le début pour mieux vous conseiller et vous soigner. Votre capital santé représente un investissement pour l’avenir, et nous souhaitons vous accompagner pour que vous puissiez en devenir acteur.</p>

    </div>

  <div class="container-fluid mt-5" data-aos="zoom-in">
    <div class="row">

      <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="image-container">
          <a href="cabinet#conseils">
            <img class="img-presentation" src="images/cabinet03.jpg" alt="Image 1">
            <div class="overlay">
              <h3 class="pistache-text fw-bold text-uppercase richblack-background-presentation">conseils</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="image-container">
          <a href="cabinet#traitements">
            <img class="img-presentation" src="images/cabinet01.jpg" alt="Image 2">
            <div class="overlay">
              <h3 class="pistache-text fw-bold text-uppercase richblack-background-presentation">traitements</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="image-container">
          <a href="cabinet#equipements">
            <img class="img-presentation" src="images/cabinet05.jpg" alt="Image 3">
            <div class="overlay">
              <h3 class="pistache-text fw-bold text-uppercase richblack-background-presentation">équipements</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="image-container">
          <a href="urgences">
            <img class="img-presentation" src="images/urgence.jpeg" alt="Image 4">
            <div class="overlay">
              <h3 class="pistache-text fw-bold text-uppercase richblack-background-presentation">urgences</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="image-container">
          <a href="plan">
            <img class="img-presentation" src="images/cabinet02.jpg" alt="Image 5">
            <div class="overlay">
              <h3 class="pistache-text fw-bold text-uppercase richblack-background-presentation">plan</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-xl-4 col-md-6 col-12 mb-4">
        <div class="image-container">
          <a href="contact">
            <img class="img-presentation" src="images/contact_image.jpg" alt="Image 6">
            <div class="overlay">
              <h3 class="pistache-text fw-bold text-uppercase richblack-background-presentation">contact</p>
            </div>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<section id="equipe" class="richblack-background text-white pt-5 pb-5">
    <div class="container">
        <h2 class="display-6 fw-bold text-white text-center">Une <span class="fw-bold pistache-text">équipe du tonnerre</span> qui vous redonnera le sourire !</h2>
            <div class="row align-items-center" >
                <div class="col-lg-8 col-md-12">
                    <h2 class="text-center classic-text fw-bold display-5">Dumitrascu Roxana</h2>
                    <h4 class="text-center classic-text fw-bold">Chirurgienne Dentiste</h4>
                    <p class="classic-text text-justify">Le docteur Dumitrascu Roxana exerce depuis <span class="fw-bold pistache-text">11 ans en France en tant que chirurgien dentiste</span>. Elle est diplômée depuis 1993.<br>Le Docteur Dumitrascu est chirurgien dentiste conventionné et applique les honoraires réglementés par l’assurance maladie.</p>
                </div>
                <div class="col-lg-4 col-md-12">
                    <img src="images/dumitrascu.png" data-aos="zoom-in-left" style="max-width:250px; max-height:250px;" alt="Image carrée" class="img-fluid mx-auto d-block">
                </div>
            </div>
                <hr class="my-4 border-top border-dark">
            </div>
        <div class="container mt-5">
            <div class="row align-items-center">
              <div class="col-lg-4 col-md-12 order-lg-1 order-md-2 order-sm-2 order-2">
                <img src="images/justine.png" data-aos="zoom-in-right" style="max-width:250px; max-height:250px;" alt="Image carrée" class="img-fluid mx-auto d-block">
              </div>
              <div class="col-lg-8 col-md-12 order-lg-2 order-md-1 order-sm-1 order-1">
                <h2 class="text-center classic-text fw-bold display-5">Justine Garcin</h2>
                <h4 class="text-center classic-text fw-bold">Assistante Dentaire</h4>
                <p class="classic-text text-justify"><span class="fw-bold pistache-text">Depuis 2012, Justine Garcin est assistante dentaire au sein du cabinet dentaire.</span> Elle l'aide à ce que vos dents soient les plus saines possibles.</p>
              </div>
            </div>
        </div>
    </div>
</section>

<section class="horaire grey-background pb-5 pt-5">
    <div class="container-xl">
        <h2 class="display-6 fw-bold text-center mb-5">Horaire</h2>
        <div class="table-responsive">
            <table class="table">
                <div id='calendar' style="min-width:960px; max-height:700px;"></div>
            </table>
        </div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fr',
            initialView: 'timeGridWeek',

            headerToolbar: {
                start: '',
                center: 'title',
                end: 'today prev,next'
            },

            views: {
            timeGridWeek: {
                type: 'timeGrid',
                firstDay: 1, // Définir le premier jour de la semaine comme Lundi
                }
            },

            buttonText: {
                today: 'Semaine actuelle' // Changer le texte du bouton "today" par "Semaine actuelle"
            },

            weekends: false, // Permettre de cacher le Samedi & Dimanche
            editable: false, // Les événements ne sont pas éditables 
            selectable: false, // Les plages horaires ne sont pas sélectionnables
            allDaySlot: false, // Désactiver le all-day qui ne sert à rien
            nowIndicator: true, // Montre la ligne rouge afin de montrer le moment actuel
            slotMinTime: "07:00:00", // Visibilité du calendrier qui commence à 7 heures
            slotMaxTime: "19:00:00", // Visibilité du calendrier qui termine à 19 heures
            events: [
                <?php
                // Récupérer tous les événements depuis la base de données (VERSION UTILISATEUR -> Ne peut que voir les horaires)
                $events = $schedule->getAllSchedules();

                // Générer les événements pour le calendrier
                foreach ($events as $event) {
                    echo '{';
                    echo 'title: "' . $event['nom'] . '",'; // Nom en grand et en centre de l'événement
                    echo 'start: "' . $event['date_complet'] . 'T' . $event['heure_debut'] . '",'; // Heure de début
                    echo 'end: "' . $event['date_complet'] . 'T' . $event['heure_fin'] . '",'; // Heure de fin
                    echo 'id: "' . $event['id'] . '",'; // ID de l'événement en guise d'identifiant
                    if ($event['nom'] === "Ouverture") { // Gestion des couleurs selon le nom de l'événement
                      echo 'color: "green",';
                    } elseif ($event['nom'] === "Ouverture exceptionnelle") {
                        echo 'color: "#2794e1",';
                    } elseif ($event['nom'] === "Fermeture exceptionnelle") {
                        echo 'color: "#dc0000",';
                    } elseif ($event['nom'] === "Congés") {
                        echo 'color: "purple",';
                    }
                    echo '},';
                }
                ?>
            ],
        });
        calendar.render();
    });
</script>

</div>
</section>

<?php 
require_once ('Include/Menu/footer.php'); 
?>