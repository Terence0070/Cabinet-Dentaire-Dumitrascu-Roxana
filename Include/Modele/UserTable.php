<?php
class UserTable {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function checkAdmin() {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }
    }

    public function displayAdminUsers() {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        // Préparer et exécuter la requête SQL sécurisée
        $query = "SELECT id, email, pseudo, nom, prenom, idRole FROM user WHERE idRole = '1'";
        $statement = mysqli_prepare($this->connexion, $query);

        // Vérifier si la préparation de la requête a réussi
        if (!$statement) {
            die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
        }

        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);

        // Lié les résultats à des variables
        mysqli_stmt_bind_result($statement, $id, $email, $pseudo, $nom, $prenom, $idRole);

        // Afficher le tableau
        echo "<section class='grey-background pt-2 pb-3'>
                <div class='container mt-3'>
                    <div class='table table-responsive'>
                        <table class='table text-center table-bordered bg-white'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th scope='col'>Pseudo</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col'>Nom</th>
                                    <th scope='col'>Prénom</th>
                                    <th scope='col'>ID du Rôle</th>
                                    <th scope='col'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";

        // Parcourir les résultats et afficher chaque ligne dans le tableau
        while (mysqli_stmt_fetch($statement)) {
            echo "<tr>
                    <td>$pseudo</td>
                    <td>$email</td>
                    <td>$nom</td>
                    <td>$prenom</td>
                    <td>$idRole</td>
                    <td>
                        <a href='admin-modifier.php?id=$id' class='btn btn-primary'>Modifier</a>
                        <a href='?action=delete&id=$id' class='btn btn-danger'>Supprimer</a>
                    </td>
                  </tr>";
        }

        echo "</table></div></div>";

        // Fermer la requête
        mysqli_stmt_close($statement);
    }

    public function deleteUser($id) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }
    
        // Préparer et exécuter la requête SQL sécurisée pour supprimer l'utilisateur
        $query = "DELETE FROM user WHERE id = ?";
        $statement = $this->connexion->prepare($query);
    
        // Vérifier si la préparation de la requête a réussi
        if ($statement) {
            // Lier le paramètre de l'ID de l'utilisateur
            $statement->bind_param('i', $id);
    
            // Exécuter la requête
            $statement->execute();
    
            // Vérifier si l'exécution a réussi
            if ($statement->affected_rows > 0) {
                echo "<p class='text-success display-6 text-center'>Utilisateur supprimé avec succès !</p>";
            } else {
                echo "Aucun utilisateur trouvé avec cet ID.";
            }

            // Récupérer l'action et l'IP de l'utilisateur qui fait une "action d'administrateur"
            $action = "Suppression réussie d'un administrateur";
            $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);
    
            // Fermer le statement
            $statement->close();
        } else {
            echo "Erreur de préparation de la requête : " . $this->connexion->error;
        }
    }

    public function addUser($email, $mdp, $pseudo, $prenom, $nom, $idRole) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        // Vérifier si l'utilisateur a un mot de passe suffisamment puissant (min. 12 caractères + caractères spéciaux)
        if (strlen($mdp) < 12 || !preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])[\S]{12,}$/', $mdp)) {
            echo "<p class='text-danger display-6 text-center'>Votre mot de passe doit contenir au moins 12 caractères et des caractères spéciaux (exemple : _-/ etc.), un chiffre et une majuscule.</span>";
            return;
        }
    
        // Insérer un nouveau utilisateur
        $query = "INSERT INTO user (email, mdp, pseudo, nom, prenom, idRole) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Me demandez pas pourquoi avec mysqli_prepare ça ne fonctionne pas, j'en ai aucune idée, donc j'ai fait un truc différent.
        $statement = $this->connexion->prepare($query);
    
        // Vérifie si la préparation de la requête a réussi
        if ($statement) {

            // Hasher le mot de passe avec la fonction password_hash de PHP pour plus de sécurité
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

            // Lie les paramètres
            $statement->bind_param("sssssi", $email, $hashedPassword, $pseudo, $nom, $prenom, $idRole);
    
            // Exécute la requête
            $statement->execute();
    
            // Vérifie si l'exécution a réussi
            if ($statement->affected_rows > 0) {
                echo "<p class='text-success display-6 text-center'>Enregistrement réussi du nouvel utilisateur.</span>";
            } else {
                echo "<p class='text-danger display-6 text-center'>Échec de l'enregistrement du nouvel utilisateur.</span>";
            }
    
            // Ferme le statement
            $statement->close();

            // Récupérer l'action et l'IP de l'utilisateur qui fait une "action d'administrateur"
            $action = "Ajout réussi d'un administrateur";
            $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);
        } else {
            echo "Erreur de préparation de la requête : " . $this->connexion->error;
        }
    }

    // SE PASSE DANS modifier.php
    public function updateUser($id, $nouveauPseudo, $nouvelEmail, $nouveauNom, $nouveauPrenom, $nouveauIdRole, $nouveauMdp, $confirmerMdp) {
        global $errors_update;
        
        // Vérifiez si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }
    
        // Vérifiez si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifiez si l'utilisateur souhaite modifier le mot de passe
            if (!empty($nouveauMdp) || !empty($confirmerMdp)) {
                // Vérifiez la confirmation du mot de passe
                if ($nouveauMdp !== $confirmerMdp) {
                    $errors_update['verifmdptropcourt']= "<span style='color:red;'>Vos mots de passe sont différents.</span>";
                    return;
                } elseif (strlen($nouveauMdp) < 12 ) {
                    $errors_update['verifmdpdifferent'] = "<span style='color:red;'>Votre mot de passe est très court.</span>";
                    return;
                } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d])[\S]{12,}$/', $nouveauMdp)) {
                    $errors_update['verifmdpdifferent'] = "<span style='color:red;'>Votre mot de passe ne satisfait pas la politique de robustesse (12 caractères minimum, un caractère spécial minimum, un chiffre minimum et une majuscule minimum).</span>";
                    return;
                } else {
                    // Hacher le mot de passe s'il est fourni
                    $hashedPassword = password_hash($nouveauMdp, PASSWORD_DEFAULT);
    
                    // Préparez et exécutez la requête de mise à jour avec changement de mot de passe
                    $query = "UPDATE user SET pseudo=?, email=?, nom=?, prenom=?, idRole=?, mdp=? WHERE id=?";
                }
            } else {
                // Préparez et exécutez la requête de mise à jour sans changer le mot de passe
                $query = "UPDATE user SET pseudo=?, email=?, nom=?, prenom=?, idRole=? WHERE id=?";
            }
    
            $statement = $this->connexion->prepare($query);
    
            // Vérifie si la préparation de la requête a réussi
            if ($statement) {
                // Lier les paramètres
                if (!empty($nouveauMdp)) {
                    $statement->bind_param("ssssisi", $nouveauPseudo, $nouvelEmail, $nouveauNom, $nouveauPrenom, $nouveauIdRole, $hashedPassword, $id);
                } else {
                    $statement->bind_param("ssssii", $nouveauPseudo, $nouvelEmail, $nouveauNom, $nouveauPrenom, $nouveauIdRole, $id);
                }
    
                // Exécute la requête
                $statement->execute();
    
                // Vérifie si l'exécution a réussi
                if ($statement->affected_rows > 0) {
                    if ($_SESSION['id'] == $id) {
                        // Mettez à jour les informations dans la session si l'utilisateur modifie son propre profil
                        $_SESSION['pseudo'] = $nouveauPseudo;
                        $_SESSION['idRole'] = $nouveauIdRole;
                    }
                    // Récupérer l'action et l'IP de l'utilisateur qui fait une "action d'administrateur"
                    $action = "Modification réussie d'un administrateur";
                    $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);

                    // Redirigez vers la page principale ou affichez un message de succès
                    header('Location: admin.php');
                    exit();
                } else {
                    echo "Erreur lors de la mise à jour : " . $this->connexion->error;
                }
    
                // Fermer le statement
                $statement->close();
            } else {
                echo "Erreur de préparation de la requête : " . $this->connexion->error;
            }
        } else {
            // Si le formulaire n'a pas été soumis, affichez un message approprié ou redirigez
            echo "Le formulaire n'a pas été soumis.";
        }
    }

    private function ipRecup($ip, $action) {
        // Préparer et exécuter la requête SQL pour insérer l'action
        $query = "INSERT INTO action (action, date, ip) VALUES (?, NOW(), ?)";
        $statement = mysqli_prepare($this->connexion, $query);
        
        // Vérifier si la préparation de la requête a réussi
        if (!$statement) {
            die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
        }

        // Liaison des paramètres et exécution de la requête
        mysqli_stmt_bind_param($statement, "ss", $action, $ip);
        mysqli_stmt_execute($statement);

        // Fermeture du statement
        mysqli_stmt_close($statement);
    }
}
?>