<?php
ob_start();
$metaRobots = '<meta name="robots" content="noindex, nofollow">';
$title = "Modification du calendrier";
$metaDescription = "";
require_once ('Include/Menu/header.php'); 

// Inclure la classe Schedule
require_once ('Include/Modele/Schedule.php');

// Créer une instance de la classe Schedule avec la connexion à la base de données
$schedule = new Schedule($connexion);

// Vérifier si l'utilisateur est bien un administrateur
$schedule->checkAdmin();
?>

<!-- TOUT EN DESSOUS EST CE QUI CONCERNE LE BACKEND DU CALENDRIER --> 
<?php
// Vérifier s'il y a une action à effectuer (?action=)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // En fonction de l'action demandée, effectuer les opérations appropriées
    switch ($action) {
        case 'ajouter':
            // Traitement de l'ajout d'un nouvel événement
            if (isset($_POST['nom'], $_POST['date_complet'], $_POST['heure_debut'], $_POST['heure_fin'])) {
                $nom = htmlspecialchars($_POST['nom']);
                $date_complet = htmlspecialchars($_POST['date_complet']);
                $heure_debut = htmlspecialchars($_POST['heure_debut']);
                $heure_fin = htmlspecialchars($_POST['heure_fin']);

                $schedule->addSchedule($nom, $date_complet, $heure_debut, $heure_fin); // Appel de la méthode addSchedule
                header("Location: calendrier-modif.php");
            }
            break;

        case 'supprimer':
            // Traitement de la suppression d'un événement existant
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $schedule->deleteSchedule($id); // Appel de la méthode deleteSchedule
                header("Location: calendrier-modif.php");
            }
            break;
        
        case 'ajouter_plein':
            // Traitement de l'ajout de plusieurs horaires
            if (isset($_POST['type'], $_POST['heure_debut_lundi'], $_POST['heure_debut_mardi'], $_POST['heure_debut_mercredi'], $_POST['heure_debut_jeudi'], $_POST['heure_debut_vendredi'], $_POST['heure_fin_lundi'], $_POST['heure_fin_mardi'], $_POST['heure_fin_mercredi'], $_POST['heure_fin_jeudi'], $_POST['heure_fin_vendredi'], $_POST['date_debut'], $_POST['date_fin'])) {
                $type = htmlspecialchars($_POST['type']);
                $heure_debut_lundi = htmlspecialchars($_POST['heure_debut_lundi']);
                $heure_debut_mardi = htmlspecialchars($_POST['heure_debut_mardi']);
                $heure_debut_mercredi = htmlspecialchars($_POST['heure_debut_mercredi']);
                $heure_debut_jeudi = htmlspecialchars($_POST['heure_debut_jeudi']);
                $heure_debut_vendredi = htmlspecialchars($_POST['heure_debut_vendredi']);
                $heure_fin_lundi = htmlspecialchars($_POST['heure_fin_lundi']);
                $heure_fin_mardi = htmlspecialchars($_POST['heure_fin_mardi']);
                $heure_fin_mercredi = htmlspecialchars($_POST['heure_fin_mercredi']);
                $heure_fin_jeudi = htmlspecialchars($_POST['heure_fin_jeudi']);
                $heure_fin_vendredi = htmlspecialchars($_POST['heure_fin_vendredi']);
                $date_debut = htmlspecialchars($_POST['date_debut']);
                $date_fin = htmlspecialchars($_POST['date_fin']);
    
                $schedule->addMultipleSchedule($type, $heure_debut_lundi, $heure_debut_mardi, $heure_debut_mercredi, $heure_debut_jeudi, $heure_debut_vendredi, $heure_fin_lundi, $heure_fin_mardi, $heure_fin_mercredi, $heure_fin_jeudi, $heure_fin_vendredi, $date_debut, $date_fin);
                header("Location: calendrier-modif.php");
            }
            break;
        
        case 'explosion':
            // Traitement de la suppression de plsuieurs horaires
            if (isset($_POST['date_debut'], $_POST['date_fin'])) {
                $date_debut = htmlspecialchars($_POST['date_debut']);
                $date_fin = htmlspecialchars($_POST['date_fin']);

                $schedule->deleteMultipleSchedule($date_debut, $date_fin);
                header("Location: calendrier-modif.php");
            }

        default:
            // Redirection vers la page par défaut si l'action n'est pas reconnue
            header("Location: calendrier-modif.php");
            exit();
    }
}
?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    // JavaScript pour gérer les interactions avec la fenêtre modale
    $(document).ready(function() {
        // Attachement du gestionnaire d'événements à tous les boutons de classe delete-event
        $(document).on('click', '.delete-event', function() {
            var eventId = $(this).data('event-id'); // Récupérer l'ID de l'événement à supprimer
            deleteEvent(eventId); // Appeler la fonction pour supprimer l'événement
        });
    });

    // Fonction pour supprimer un événement
    function deleteEvent(eventId) {
        fetch('calendrier-modif.php?action=supprimer&id=' + eventId, {
            method: 'GET',
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la suppression de l\'événement');
            }
            return response.text();
        })
        .then(data => {
            console.log(data);
            $('#event-modal').modal('hide'); // Cacher la fenêtre modale après la suppression
            window.location.reload(); // Recharger la page pour mettre à jour le calendrier après la suppression
        })
        .catch(error => console.error(error));
    }

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
                firstDay: 1 // Définir le premier jour de la semaine comme Lundi
            }
        },
        buttonText: {
            today: 'Semaine actuelle' // Changer le texte du bouton "today" par "Semaine actuelle"
        },
        weekends: false, // Permettre de cacher le Samedi & Dimanche
        editable: false, // Permettre l'édition des événements sur le calendrier
        selectable: true, // Permettre de sélectionner des plages horaires pour ajouter des événements
        allDaySlot: false, // Désactiver le all-day qui ne sert à rien
        nowIndicator: true, // Montre la ligne rouge afin de montrer le moment actuel
        slotMinTime: "07:00:00", // Visibilité du calendrier qui commence à 7 heures
        slotMaxTime: "19:00:00", // Visibilité du calendrier qui termine à 19 heures
        events: [
            <?php
            // Récupérer tous les événements depuis la base de données
            $events = $schedule->getAllSchedules();

            // Générer les événements pour le calendrier à partir des données de la base de données
            foreach ($events as $event) {
                echo '{';
                echo 'title: "' . $event['nom'] . '",'; // Nom de l'événement
                echo 'start: "' . $event['date_complet'] . 'T' . $event['heure_debut'] . '",'; // Heure de début
                echo 'end: "' . $event['date_complet'] . 'T' . $event['heure_fin'] . '",'; // Heure de fin
                echo 'id: "' . $event['id'] . '",'; // ID de l'événement
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
        eventClick: function(info) {
            // Ouvrir une fenêtre modale pour afficher les détails de l'événement
            $('#modal-title').text(info.event.title);
            $('#modal-date').text(info.event.start.toLocaleDateString());
            $('#modal-time').text(info.event.start.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'}) + ' - ' + info.event.end.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'}));
            $('.delete-event').data('event-id', info.event.id); // Définir l'ID de l'événement à supprimer dans tous les boutons de classe delete-event
            $('#event-modal').modal('show');
        }
    });
    calendar.render();
});

// Changer la couleur du champ "nom" selon le choix qu'on fait
function changeCouleur(select) {
    var couleur;
    switch (select.value) {
        case "Ouverture":
            couleur = "green";
            break;
        case "Ouverture exceptionnelle":
            couleur = "#2794e1";
            break;
        case "Fermeture exceptionnelle":
            couleur = "#dc0000";
            break;
        case "Congés":
            couleur = "purple";
            break;
        default:
            couleur = "white";
    }
    select.style.backgroundColor = couleur;
}

// Appeler la fonction changeCouleur une fois que la page est complètement chargée (sinon c'est blanc de base et ça m'attriste)
window.addEventListener('load', function() {
    var select = document.getElementById('nom');
    changeCouleur(select);
});
</script>

<!-- TOUT EN DESSOUS EST CE QUI CONCERNE LE FRONTEND DU CALENDRIER --> 
<!-- Header -->
    <header class="pistache-background pt-4 pb-2">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Modification du calendrier</h1>
        </div>
    </header>

<!-- Calendrier -->
<section class="mb-2 pb-3 grey-background" id="calendrier-vue">
    <div class="container-fluid">
        <div class="row">
            <!-- Aperçu du calendrier -->
            <div class="col-xl-8 col-12 mt-4">
                <div id='calendar'></div>
            </div>

            <!-- Formulaire d'ajout d'horaires dans le calendrier -->
            <div class="col-xl-4 col-12 mt-4 border pb-2 align-items-center">
                <h2 class="mb-3 text-center text-uppercase fw-bold">Ajouter une horaire</h2>
                <form action="calendrier-modif.php?action=ajouter" class="fw-bold" method="POST">
                    <div class="form-group">
                        <label style="font-size:20px;" for="nom">Nom :</label>
                        <select class="form-select fw-bold text-white" style="font-size:20px;" id="nom" name="nom" required onchange="changeCouleur(this)">
                            <option style="background-color:green; font-size:20px;" class="fw-bold" value="Ouverture">Ouverture</option>
                            <option style="background-color:#2794e1; font-size:20px;" class="fw-bold" value="Ouverture exceptionnelle">Ouverture exceptionnelle</option>
                            <option style="background-color:#dc0000; font-size:20px;" class="fw-bold" value="Fermeture exceptionnelle">Fermeture exceptionnelle</option>
                            <option style="background-color:purple; font-size:20px;" class="fw-bold" value="Congés">Congés</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size:20px;" for="date_complet">Date :</label>
                        <input type="date" name="date_complet" id="date" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label style="font-size:20px;" for="heure_debut">Heure de début :</label>
                            <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
                        </div>
                        <div class="form-group col-6">
                            <label style="font-size:20px;" for="heure_fin">Heure de fin :</label>
                            <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" style="font-size:20px;" class="btn w-100 mt-2 fw-bold pistache-background pistache-background-hover">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

<hr style="height:50px;">

<!-- Formulaire d'ajout de plusieurs horaires dans le calendrier -->
<h2 class="text-center fw-bold text-danger">ATTENTION ! Les formulaires en-dessous doivent être remplies sérieusement car pouvant potentiellement affecter de nombreuses horaires !</h2>

<div class="col-12 container mt-5 border pb-2 align-items-center">
    <h2 class="mb-3 text-center text-uppercase fw-bold">Ajouter plusieurs horaires</h2>
    <form action="calendrier-modif.php?action=ajouter_plein" method="POST" class="fw-bold">
        <div class="form-group mb-4">
            <label style="font-size:20px;" for="type">Nom :</label>
            <select class="form-select fw-bold text-white" style="font-size:20px;" id="type" name="type" required onchange="changeCouleur(this)">
                <option style="background-color:green; font-size:20px;" class="fw-bold" value="Ouverture">Ouverture</option>
                <option style="background-color:#2794e1; font-size:20px;" class="fw-bold" value="Ouverture exceptionnelle">Ouverture exceptionnelle</option>
                <option style="background-color:#dc0000; font-size:20px;" class="fw-bold" value="Fermeture exceptionnelle">Fermeture exceptionnelle</option>
                <option style="background-color:purple; font-size:20px;" class="fw-bold" value="Congés">Congés</option>
            </select>
        </div>
            <div class="row">
                <div class="form-group col-6 col-md-4 mb-4">
                    <label for="heure_debut_lundi">Heure de début (Lundi) :</label>
                    <input type="time" name="heure_debut_lundi" class="form-control">

                    <label for="heure_fin_lundi">Heure de fin (Lundi) :</label>
                    <input type="time" name="heure_fin_lundi" class="form-control">
                </div>
                <div class="form-group col-6 col-md-4 mb-4">
                    <label for="heure_debut_mardi">Heure de début (Mardi) :</label>
                    <input type="time" name="heure_debut_mardi" class="form-control">

                    <label for="heure_fin_mardi">Heure de fin (Mardi) :</label>
                    <input type="time" name="heure_fin_mardi" class="form-control">
                </div>
                <div class="form-group col-6 col-md-4 mb-4">
                    <label for="heure_debut_mercredi">Heure de début (Mercredi) :</label>
                    <input type="time" name="heure_debut_mercredi" class="form-control">

                    <label for="heure_fin_mercredi">Heure de fin (Mercredi) :</label>
                    <input type="time" name="heure_fin_mercredi" class="form-control">
                </div>
                <div class="form-group col-6 col-md-4 mb-4">
                    <label for="heure_debut_jeudi">Heure de début (Jeudi) :</label>
                    <input type="time" name="heure_debut_jeudi" class="form-control">

                    <label for="heure_fin_jeudi">Heure de fin (Jeudi) :</label>
                    <input type="time" name="heure_fin_jeudi" class="form-control">
                </div>
                <div class="form-group col-6 col-md-4 mb-4">
                    <label for="heure_debut_vendredi">Heure de début (Vendredi) :</label>
                    <input type="time" name="heure_debut_vendredi" class="form-control">

                    <label for="heure_fin_vendredi">Heure de fin (Vendredi) :</label>
                    <input type="time" name="heure_fin_vendredi" class="form-control">
                </div>

                <div class="form-group col-6 col-md-4 mb-4">
                    <label for="date_debut">Date de début :</label>
                    <input type="date" name="date_debut" class="form-control" required>

                    <label for="date_fin">Date de fin :</label>
                    <input type="date" name="date_fin" class="form-control" required>
                </div>
            </div>
        <button type="submit" class="btn w-100 mt-2 fw-bold pistache-background pistache-background-hover">Ajouter</button>
    </form>
</div>

<hr style="height:10px;">

<div class="col-12 container mt-2 border pb-2 align-items-center">
    <h2 class="mb-3 text-center text-uppercase fw-bold">Supprimer toutes les horaires entre deux dates</span></h2>
    <form action="calendrier-modif.php?action=explosion" method="POST" class="fw-bold">
        <div class="row">
            <div class="form-group col-6">
                <label style="font-size:20px;" for="date_debut">Supprimer les horaires du... :</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control" required>
            </div>
            <div class="form-group col-6">
                <label style="font-size:20px;" for="date_fin">au :</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn w-100 mt-2 fw-bold pistache-background pistache-background-hover">Supprimer les horaires entre ces dates</button>
    </form>
</div>
</section>



<!-- Fenêtre modale pour afficher les détails de l'événement et permettre la suppression -->
<div class="modal fade" id="event-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
            </div>
            <div class="modal-body">
                <p>Date : <span id="modal-date"></span></p>
                <p>Heure : <span id="modal-time"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button class="btn btn-danger delete-event">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<?php 
require_once ('Include/Menu/footer.php'); 
ob_end_flush();
?>