<?php 
$metaRobots = '<meta name="robots" content="index, follow">';
$title = "Contact";
$metaDescription = "Truc";
require_once ('Include/Menu/header.php'); 
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'ressources/PHPMailer-6.6.5/src/Exception.php';
require 'ressources/PHPMailer-6.6.5/src/PHPMailer.php';
require 'ressources/PHPMailer-6.6.5/src/SMTP.php';

$errors = array('nom' => '', 'prenom' => '', 'email' => '', 'sujet' =>'', 'telephone' =>'', 'message' => '');
$avertissement['non_envoie'] = "";
$correct['envoie'] = "";

function myMail($dest, $subject, $body) {
    $mail = new PHPMailer(true);
  
    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; // Remplacez par l'adresse de votre serveur SMTP
      $mail->SMTPAuth = true;
      $mail->Username = 'XXXXX'; // Remplacez par votre nom d'utilisateur SMTP
      $mail->Password = 'XXXXX'; // Remplacez par votre mot de passe SMTP
      $mail->SMTPSecure = 'ssl'; // Ne surtout pas mettre en majuscule... genre vraiment.
      $mail->Port = 465; // Généralement 587, mais ça peut varier
  
      // Récupérer les informations du formulaire
      $nom = htmlspecialchars($_POST['nom']);
      $prenom = htmlspecialchars($_POST['prenom']);
      $email = htmlspecialchars($_POST['email']);
      $telephone = htmlspecialchars($_POST['telephone']);
      $motif = htmlspecialchars($_POST['motif']);
      $message = htmlspecialchars($_POST['message']);

      // Vérifier si 'age' est défini dans le formulaire
      if (isset($_POST['age'])) {
        $age = htmlspecialchars($_POST['age']);
      } else {
        // Sinon, chaîne vide
        $age = '';
      }
  
      // Inclure les informations du formulaire dans l'objet `full_message`
      $full_message = "<b>Nom :</b> " . $nom . "<br>" .
                "<b>Prénom :</b> " . $prenom . "<br>" .
                "<b>Email :</b> " . $email . "<br>";
      // Ajouter l'âge s'il est renseigné
      if (!empty($age)) {
          $full_message .= "<b>Âge :</b> " . $age . " ans<br>";
      }
      $full_message .= "<b>Téléphone :</b> " . $telephone . "<br>" .
                      "<b>Motif :</b> " . $motif . "<br>" .
                      "<b>Message :</b> " . $message;
  
      $mail->CharSet = 'UTF-8'; // Définir l'encodage des caractères
  
      // Ajouter le destinataire par défaut
      $mail->addAddress("XXXXX");
  
      // Ajouter le destinataire saisi par l'utilisateur
      $mail->addAddress($dest);
  
      $mail->addReplyTo("XXXXX", $nom . ' ' . $prenom);
      $mail->Subject = $subject;
      $mail->isHTML(true); // Définir le contenu du message comme HTML
      $mail->MsgHTML($full_message); // Utiliser la méthode MsgHTML pour conserver les caractères spéciaux et les sauts de ligne
  
      $mail->send();
      // echo 'Le message a été envoyé avec succès.';
    } catch (Exception $e) {
      // echo 'Une erreur est survenue lors de l'envoi du message : ' . $mail->ErrorInfo;
    }
  }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=XXXXX&response=' . $_POST['recaptchaResponse']));

  if ($response->success) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $sujet = trim($_POST['sujet']);
    $motif = trim($_POST['motif']);
    $message = trim($_POST['message']);

    // Vérifier si 'age' est défini dans le formulaire
    if (isset($_POST['age'])) {
      $age = htmlspecialchars($_POST['age']);
    } else {
      // Sinon, chaîne vide
      $age = '';
    }

    // Validation des champs
    // Nom : Autorise les lettres, les tirets et les espaces, entre 2 et 50 caractères
    if (!preg_match('/^[A-Za-zÀ-ÿ\- ]{2,50}$/', trim($nom))) {
        $errors['nom'] = "<span style='color:red;'>Le nom doit contenir entre 2 et 50 caractères.</span>";
    }
  
    // Prénom : Autorise les lettres, les tirets et les espaces, entre 2 et 50 caractères
    if (!preg_match('/^[A-Za-zÀ-ÿ\- ]{2,50}$/', trim($prenom))) {
        $errors['prenom'] = "<span style='color:red;'>Le prénom doit contenir entre 2 et 50 caractères.</span>";
    }
  
    // Email : Doit être une adresse email valide
    if (!empty($email) && !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', trim($email))) {
        $errors['email'] = "<span style='color:red;'>Veuillez saisir une adresse email valide.</span>";
    }
  
    // Téléphone : Autorise les chiffres, les tirets et les espaces, entre 7 et 20 caractères, autorise à ce que le champ soit vide
    if (!empty($telephone) && !preg_match('/^[0-9\- ]{7,20}$/', trim($telephone))) {
        $errors['telephone'] = "<span style='color:red;'>Le téléphone n'est pas valide.</span>";
    }
  
    // Sujet : Autorise les lettres, les chiffres, les tirets, les guillemets et les espaces, entre 2 et 100 caractères
    if (!preg_match('/^[A-Za-zÀ-ÿ0-9\- "\']{2,150}$/', trim($sujet))) {
        $errors['sujet'] = "<span style='color:red;'>Le sujet doit contenir entre 2 et 100 caractères.</span>";
    }  
    

    // Vérifier si des erreurs ont été détectées
    $hasErrors = false;
    foreach ($errors as $error) {
      if (!empty($error)) {
        $hasErrors = true;
        break;
      }
    }

    if (!$hasErrors) {
        $consentement = "INSERT INTO consentement (consent, email, prenom, nom, date_enregistrement) VALUES ('Oui', ?, ?, ?, NOW())";
        $stmt = $connexion->prepare($consentement);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $connexion->error);
        }

        $stmt->bind_param("sss", $email, $prenom, $nom);
        $stmt->execute();
        $stmt->close();

        $full_message = "";
        myMail('XXXXX', $sujet, $full_message);
        $correct['envoie'] = "<h1 style='text-align:center; color:green;'>Votre message a été envoyé avec succès.</h1>";
    } else {
        $avertissement['non_envoie'] = "<h1 style='text-align:center; color:red;'>Veuillez corriger les erreurs dans le formulaire.</h1>";
    }
  } else {
     $avertissement['non_envoie'] = "<h1 style='text-align:center; color:red;'>La vérification reCAPTCHA a échoué. Veuillez réessayer.</h1>";
  }
   // var_dump($response, $nom, $prenom, $email, $telephone, $sujet, $message, $full_message);
}
?>

<!-- Header -->
<header class="pistache-background pt-4 pb-2">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Formulaire de contact</h1>
    </div>
</header>

<div class="grey-background pt-2 pb-2">
    <div class="container mt-3">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-8">
            <p class="lead fw-bold text-center">Pour toute information, veuillez compléter ce formulaire afin de prendre contact avec le cabinet dentaire Dumitrascu Roxana !</p>
            <form action="" method="POST" onsubmit="onClick(event)">
                <?php if(isset($correct['envoie'])) { echo $correct['envoie']; } ?>
                <?php if(isset($avertissement['non_envoie'])) { echo $avertissement['non_envoie']; } ?>
                <div class="row">
                  <div class="form-group col-12 col-lg-6">
                    <label for="nom"><b>Nom<span style="color:red;">*</span> :</b></label>
                    <input type="text" class="form-control" required id="nom" name="nom" required>
                    <span class=error><?php echo $errors['nom']; ?></span>
                  </div>

                  <div class="form-group col-12 col-lg-6">
                    <label for="prenom"><b>Prénom<span style="color:red;">*</span> :</b></label>
                    <input type="text" class="form-control" required id="prenom" name="prenom" required>
                    <span class=error><?php echo $errors['prenom']; ?></span>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-12 col-lg-6">
                    <label for="email"><b>Email :</b></label>
                    <input type="email" class="form-control" id="email" name="email">
                    <span class=error><?php echo $errors['email']; ?></span>
                  </div>

                  <div class="form-group col-12 col-lg-6">
                    <label for="telephone"><b>Téléphone :</b></label>
                    <input type="tel" class="form-control" id="telephone" name="telephone">
                    <span class=error><?php echo $errors['telephone']; ?></span>
                  </div>
                </div>

                <div class="form-group">
                    <label for="ageInput"><b>Âge :</b></label>
                    <div class="d-flex align-items-center">
                        <input type="range" class="form-control me-2" name="age" id="ageInput" value="25" min="12" max="80">
                        <b><span id="ageValue"></span>&nbsp;<span>ans</span></b>
                    </div>
                    <input type="checkbox" class="form-check-input" id="noAge" onchange="toggleAgeField()">
                    <label class="form-check-label" for="noAge">Ne pas renseigner</label>
                </div>

                <div class="form-group">
                  <label for="sujet"><b>Sujet<span style="color:red;">*</span> :</b></label>
                  <input type="text" class="form-control" required id="sujet" name="sujet" required>
                  <span class=error><?php echo $errors['sujet']; ?></span>
                </div>

                <div class="form-group">
                  <label for="motif"><b>Motif :</b></label>
                  <select class="form-select" id="motif" name="motif">
                    <option value="">(Non applicable)</option>
                    <option value="Consultation">Consultation</option>
                    <option value="Douleurs">Douleurs</option>
                    <option value="Devis">Devis</option>
                    <option value="Contrôle">Contrôle</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="message"><b>Message<span style="color:red;">*</span> :</b></label>
                  <textarea class="form-control" id="message" name="message" style="height: 250px;" required maxlength="1500" placeholder="Maximum de 1500 caractères."><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                  <span class=error><?php echo $errors['message']; ?></span>
                </div>

                <div class="form-group">
                  <input type="hidden" id="recaptchaResponse" name="recaptchaResponse">
                </div>

                <div class="form-check">
                  <input required class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                      En envoyant ce formulaire, vous acceptez qu'on recueille les données envoyées afin de vous identifier et vous répondre.
                  </label>
                </div>

                <div class="form-group">
                  <input type="submit" class="btn w-100 fw-bold pistache-background pistache-background-hover" value="Envoyer">
                  <p><b><span style="color:red;">*</span> = Champ obligatoire à remplir</b></p>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
        <script src="https://www.google.com/recaptcha/api.js?render=6LeBOlgpAAAAAGqyC_7DKnq182rewcM6_IEo71dy"></script>
        <script>
          function onClick(e) {
            e.preventDefault();
            grecaptcha.ready(function() {
              grecaptcha.execute('6LeBOlgpAAAAAGqyC_7DKnq182rewcM6_IEo71dy', {action: 'submit'}).then(function(token) {
                document.getElementById("recaptchaResponse").value = token;
                document.querySelector("form").submit();
              });
            });
          }
        </script>
        <script>
                // Récupérer les références des champs de texte
        var nomField = document.getElementById('nom');
        var prenomField = document.getElementById('prenom');
        var emailField = document.getElementById('email');
        var telephoneField = document.getElementById('telephone');
        var sujetField = document.getElementById('sujet');

        // Ajouter des écouteurs d'événements d'entrée aux champs de texte
        nomField.addEventListener('input', validateNom);
        prenomField.addEventListener('input', validatePrenom);
        emailField.addEventListener('input', validateEmail);
        telephoneField.addEventListener('input', validateTelephone);
        sujetField.addEventListener('input', validateSujet);

        // Fonction de validation pour le champ de nom
        function validateNom() {
          var nomValue = nomField.value;
          var regex = /^[A-Za-zÀ-ÿ\- ]{2,50}$/;
          if (!regex.test(nomValue)) {
            nomField.classList.add('error');
          } else {
            nomField.classList.remove('error');
          }
        }

        // Fonction de validation pour le champ de prénom
        function validatePrenom() {
          var prenomValue = prenomField.value;
          var regex = /^[A-Za-zÀ-ÿ\- ]{2,50}$/;
          if (!regex.test(prenomValue)) {
            prenomField.classList.add('error');
          } else {
            prenomField.classList.remove('error');
          }
        }

        // Fonction de validation pour le champ d'email
        function validateEmail() {
          var emailValue = emailField.value;
          var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
          if (!regex.test(emailValue)) {
            emailField.classList.add('error');
          } else {
            emailField.classList.remove('error');
          }
          
          if (emailValue === "") {
            emailField.classList.remove('error');
          }
        }

        // Fonction de validation pour le champ de téléphone
        function validateTelephone() {
          var telephoneValue = telephoneField.value;
          var regex = /^[0-9\- ]{7,20}$/;
          if (!regex.test(telephoneValue)) {
            telephoneField.classList.add('error');
          } else {
            telephoneField.classList.remove('error');
          }
          
          if (telephoneValue === "") {
            telephoneField.classList.remove('error');
          }
        }

        // Fonction pour obtenir le nombre du curseur (entre 12 et 80)
        var ageField = document.getElementById('ageInput');
        var ageValueSpan = document.getElementById('ageValue');

        ageField.addEventListener('input', updateAgeValue);

        function updateAgeValue() {
            var ageValue = ageField.value;
            ageValueSpan.textContent = ageValue;
        }

        // Appel initial pour afficher la valeur de l'âge dès le chargement de la page
        updateAgeValue();

        // Gérer la case pour cocher/décocher le curseur de l'âge
        function toggleAgeField() {
            var ageField = document.getElementById('ageInput'); // Utilisez 'ageInput' ici
            var noAgeCheckbox = document.getElementById('noAge');
            var ageValueSpan = document.getElementById('ageValue');

            if (noAgeCheckbox.checked) {
                ageField.disabled = true;
                ageValueSpan.textContent = ''; // Effacer la valeur si la case est cochée
            } else {
                ageField.disabled = false;
                updateAgeValue(); // Mettre à jour la valeur si la case est décochée
            }
        }

        // Écouter l'événement 'input' pour mettre à jour la valeur de l'âge en temps réel
        ageField.addEventListener('input', updateAgeValue);

        // Fonction de validation pour le champ de l'âge
        ageField.addEventListener('input', validateAge);

        function validateAge() {
            var ageValue = parseInt(ageField.value);

            if (isNaN(ageValue) || ageValue < 12 || ageValue > 80) {
                ageField.classList.add('error');
            } else {
                ageField.classList.remove('error');
            }
        }


        // Fonction de validation pour le champ de sujet
        function validateSujet() {
          var sujetValue = sujetField.value;
          var regex = /^[A-Za-zÀ-ÿ0-9\- "\']{2,150}$/;
          if (!regex.test(sujetValue)) {
            sujetField.classList.add('error');
          } else {
            sujetField.classList.remove('error');
          }
        }
        </script>
      </div>
    </div>
  </div>
</section>

<style>
    .error {
        border-color: red; /* Gestion des erreurs dans un formulaire */
        color:red;
    }
</style>

<?php 
require_once ('Include/Menu/footer.php'); 
?>
