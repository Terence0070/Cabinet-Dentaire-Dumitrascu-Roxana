<?php
class Authentification {
    private $connexion;
    private $recaptchaSecret;

    public function __construct($connexion, $recaptchaSecret) {
        $this->connexion = $connexion;
        $this->recaptchaSecret = $recaptchaSecret;
    }

    public function checkSessionAndAuthenticate() {
        // Vérifier si la session est déjà active
        if (isset($_SESSION['pseudo'])) {
            header('Location: index.php');
            exit();
        }

        // Initialiser la réponse
        $authResult = '';

        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier la réponse reCAPTCHA
            $recaptchaResponse = $_POST['recaptchaResponse'];
            $response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $this->recaptchaSecret . '&response=' . $recaptchaResponse));
            
            // Envoyer un message d'erreur en cas de vérification reCAPTCHA échoué (robot)
            if (!$response->success) {
                $authResult = "<p class='text-danger display-6 text-center'>La vérification reCAPTCHA a échoué. Veuillez réessayer.</p>";
                return $authResult;
            }

            // Voir si la vérification reCAPTCHA est fonctionnelle
            /* if (isset($response)) {
                var_dump($response);
            } (Retirez ce commentaire et les codes de commentaires si vous souhaitez voir les retours de reCAPTCHA */

            // Traiter l'authentification de l'utilisateur
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $authResult = $this->authenticateUser($pseudo, $mdp);
        }

        // Retourner l'erreur
        return $authResult;
    }

    private function authenticateUser($pseudo, $mdp) {
        // Préparer et exécuter la requête SQL sécurisée
        $query = "SELECT id, email, pseudo, mdp, idRole FROM user WHERE pseudo = ? OR email = ?";
        $statement = mysqli_prepare($this->connexion, $query);
        
        // Vérifier si la préparation de la requête a réussi
        if (!$statement) {
            exit("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
        }

        mysqli_stmt_bind_param($statement, "ss", $pseudo, $pseudo);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);

        // Vérifier le résultat de la requête
        if (mysqli_stmt_num_rows($statement) > 0) {
            // Associer les colonnes du résultat à des variables
            mysqli_stmt_bind_result($statement, $id, $pseudo, $pseudo, $hashedPassword, $idRole);

            // Récupérer les valeurs
            mysqli_stmt_fetch($statement);

            // Vérifier le mot de passe haché
            if (password_verify($mdp, $hashedPassword)) {
                // Mot de passe correct, connecter l'utilisateur
                $_SESSION['id'] = $id;
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['idRole'] = $idRole;

                // Récupérer l'action de l'administrateur ainsi que son IP
                $action = "Connexion réussie";
                $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);

                // Rediriger l'utilisateur vers la page d'accueil
                header('Location: index.php');
                exit();
            } else {
                // Mot de passe incorrect
                $authResult = "<p class='text-danger display-6 text-center'>Votre identifiant ou votre mot de passe sont erronés.</p>";
            }
        } else {
            // Aucun utilisateur trouvé avec cet identifiant
            $authResult = "<p class='text-danger display-6 text-center'>Votre identifiant ou votre mot de passe sont erronés.</p>";
        }

        // Fermez le statement
        mysqli_stmt_close($statement);

        // Fermez la connexion
        mysqli_close($this->connexion);

        // Retournez l'erreur
        return $authResult;
    }

    private function ipRecup($ip, $action) {
        // Préparer et exécuter la requête SQL pour insérer l'action
        $query = "INSERT INTO action (action, date, ip, utilisateur_id) VALUES (?, NOW(), ?, ?)";
        $statement = mysqli_prepare($this->connexion, $query);
    
        // Vérifier si la préparation de la requête a réussi
        if (!$statement) {
            exit("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
        }
    
        // Liaison des paramètres et exécution de la requête
        $utilisateur_id = $_SESSION['id'];
        mysqli_stmt_bind_param($statement, "sss", $action, $ip, $utilisateur_id);
        mysqli_stmt_execute($statement);
    
        // Fermeture du statement
        mysqli_stmt_close($statement);
    }
    
}
?>
