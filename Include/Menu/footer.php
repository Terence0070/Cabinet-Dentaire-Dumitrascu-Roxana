


<div class="p-3">
    <div class="container-fluid text-dark text-center">
        <div class="row align-items-center">
            <div class="col-sm-4 mb-5 mb-lg-0">
                <h6 class="text-uppercase fw-bold mb-2">Localisation</h6>
                <p class="lead mb-0">
                    26 Rue Rudolph Serkin<br>84000 Avignon
                </p>
            </div>

            <div class="col-sm-4 mb-5 mb-lg-0">
                <h6 class="text-uppercase fw-bold mb-2">Plan du site</h6>
                    <button type="button" class="btn pistache-background pistache-background-hover btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#planModal">
                        Voir le plan du site
                    </button>
            </div>

            <div class="col-sm-4 mb-3 mb-lg-0">
                <h6 class="text-uppercase fw-bold mb-2">Divers</h6>
                <div class="justify-content-center align-items-center">
                    <div>
                        <a href="mentions-legales" target="_blank" class="lead divers small">Mentions légales</a>
                    </div>
                    <div>
                        <a href="politique" target="_blank" class="lead divers small">Politique de confidentialité</a>
                    </div>
                    <div>
                        <a href="cookies" target="_blank" class="lead divers small">Cookies</a>
                    </div>
                    <div>
                        <a href="credits" target="_blank" class="lead divers small">Crédits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="planModalLabel">Plan du site</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <ul class="text-decoration-none">
                <h5>Principal</h5>
                    <li><a href="index">Accueil</a></li>
                    <li><a href="cabinet">Cabinet</a></li>
                        <ul>
                            <li><a href="cabinet#conseils">Conseils</a></li>
                            <li><a href="cabinet#traitements">Traitements</a></li>
                            <li><a href="cabinet#equipements">Equipements</a></li>
                        </ul>
                    <li><a href="urgences">Urgences</a></li>
                    <li><a href="plan">Plan</a></li>
                    <li><a href="contact">Contact</a></li>
                <hr>
                <?php if (isset($_SESSION['idRole'])) { ?>
                <?php } else { ?>
                <h5 class=>Fonctionnalité de connexion</h5>
                    <li><a href="login">Login (se connecter)</a></li>
                <hr>
                <?php } ?>
              <?php if (isset($_SESSION['idRole']) == 1) { ?>
                <h5 class=>Fonctionnalités d'administrateur</h5>
                    <li><a href="admin">Gestion des administrateurs</a></li>
                    <li><a href="calendrier-modif">Gestion du calendrier</a></li>
                    <li><a href="logout">Se déconnecter</a></li>
                <hr>
              <?php } ?>
                <h5 class=>Divers</h5>
                    <li><a href="mentions-legales">Mention Légales</a></li>
                    <li><a href="politique">Politique de confidentialité</a></li>
                    <li><a href="cookies">Cookies</a></li>
                    <li><a href="credits">Crédits</a></li>
            </ul>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<footer class="py-2 bg-dark">
    <div class="container bg-dark px-4">
        <p class="m-0 text-center text-white"><i>Copyright &copy; <?php echo date("Y"); ?> Cabinet Dentaire Dumitrascu Roxana
          Tous droits réservés. Site réalisé par <a class="fw-bold text-decoration-none" href="https://www.linkedin.com/in/terence-renard" target="_blank"><span class="terence">Terence Renard</span></a></i>
        </p>
    </div>
</footer>


<!-- Script -->
<script src="https://kit.fontawesome.com/4e8a26577c.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>AOS.init();</script>

<script> 
    // Script permettant que le menu "sticky" ne bouffe pas une partie du texte en cas d'ancrage
    document.addEventListener('DOMContentLoaded', function() {
        // Obtient la hauteur du menu sticky
        var stickyHeight = document.querySelector('header').offsetHeight;

        // Sélectionne tout ce qui peut faire appel à des ancrages
        var links = document.querySelectorAll('.list-group-item');

        // Pour chaque lien, ajoute un gestionnaire d'événements de clic
        links.forEach(function(link) {
            // Ajoute un écouteur d'événements de clic
            link.addEventListener('click', function(event) {
                // Empêche le comportement par défaut du lien
                event.preventDefault();

                // Obtient l'ID de l'ancre cible depuis l'attribut href du lien
                var targetId = this.getAttribute('href').substring(1);

                // Obtient l'élément cible par son ID
                var targetElement = document.getElementById(targetId);

                // Calcule la position de l'élément cible
                var offsetPosition = targetElement.offsetTop - stickyHeight;

                // Fait défiler la page jusqu'à la position de l'élément cible avec un décalage pour tenir compte du menu sticky
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth' // Fait défiler en douceur
                });
            });
        });
    });
</script>
</body>