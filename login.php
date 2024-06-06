<?php
ob_start();
$metaRobots = '<meta name="robots" content="noindex, nofollow">';
$title = "Login";
$metaDescription = "";
require_once('Include/Menu/header.php');

// Inclure la classe Authentification
require_once('Include/Modele/Authentification.php');

// Clé secrète reCAPTCHA
$recaptchaSecret = "XXXXX";

// Utiliser le modèle "Authentification.php"
$authentification = new Authentification($connexion, $recaptchaSecret);
$authResult = $authentification->checkSessionAndAuthenticate();
?>

<!-- Header -->
<header class="pistache-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Se connecter</h1>
    </div>
</header>

<div class="grey-background pt-2 pb-2">
    <div class="container mt-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-6">
                <form method="POST" action="">
                    <?php echo $authResult; ?>
                    <div class="form-group">
                        <label for="pseudo"><b>Pseudo ou adresse email<span style="color:red;">*</span> :</b></label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" required><br>
                    </div>

                    <div class="form-group">
                        <label for="mdp"><b>Mot de passe<span style="color:red;">*</span> :</b></label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" class="form-control" id="mdp" name="mdp" required><br>
                            <div class="input-group-text">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" id="recaptchaResponse" name="recaptchaResponse">
                    </div>

                    <input type="submit" class="btn w-100 fw-bold pistache-background pistache-background-hover mt-2" value="Envoyer" onclick="onClick(event)">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6Ld7C-0pAAAAAFgbGBf_8ceOm6JxLpM0j2u_vYxo"></script>
<script>
    function onSubmit(token) {
        document.getElementById("recaptchaResponse").value = token;
        document.querySelector("form").submit();
    }

    function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('6Ld7C-0pAAAAAFgbGBf_8ceOm6JxLpM0j2u_vYxo', { action: 'submit' }).then(onSubmit);
        });
        // Validation des champs requis
        var pseudo = document.getElementById("pseudo").value;
        var mdp = document.getElementById("mdp").value;
        if (!pseudo || !mdp) {
            alert("Veuillez remplir tous les champs requis.");
            return false;
        }
    }
</script>
<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });
</script>

<?php 
require_once ('Include/Menu/footer.php'); 
ob_end_flush();
?>
