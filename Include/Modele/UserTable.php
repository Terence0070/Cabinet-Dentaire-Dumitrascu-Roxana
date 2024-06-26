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

        // Préparer et exécuter la requête SQL pour compter le nombre total d'utilisateurs administrateurs
    $countQuery = "SELECT COUNT(*) AS total_admins FROM user WHERE idRole = 1";
    $countStatement = mysqli_prepare($this->connexion, $countQuery);

    // Vérifier si la préparation de la requête a réussi
    if (!$countStatement) {
        die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
    }

    mysqli_stmt_execute($countStatement);
    mysqli_stmt_store_result($countStatement);

    // Lier le résultat à une variable
    mysqli_stmt_bind_result($countStatement, $totalAdmins);

    // Récupérer le nombre total d'admins
    mysqli_stmt_fetch($countStatement);

    // Afficher le nombre total d'admins juste après la balise d'ouverture <div class='container mt-3'>
    echo "<section class='grey-background pt-2 pb-3'>
            <div class='container mt-3'>
                <h2 class='text-center'>Total des administrateurs : $totalAdmins</h2>";

    // Fermer le statement de comptage
    mysqli_stmt_close($countStatement);

    // Préparer et exécuter la requête SQL pour compter le nombre total d'actions réalisées
    $totalActionsQuery = "SELECT COUNT(*) AS total_actions FROM action";
    $totalActionsStatement = mysqli_prepare($this->connexion, $totalActionsQuery);

    // Vérifier si la préparation de la requête a réussi
    if (!$totalActionsStatement) {
        die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
    }

    mysqli_stmt_execute($totalActionsStatement);
    mysqli_stmt_store_result($totalActionsStatement);

    // Lier le résultat à une variable
    mysqli_stmt_bind_result($totalActionsStatement, $totalActions);

    // Récupérer le nombre total d'actions
    mysqli_stmt_fetch($totalActionsStatement);

    // Afficher le nombre total d'actions
    echo "<h4 class='text-center'>Total des actions réalisées : $totalActions</h4>";

    // Fermer le statement de comptage des actions totales
    mysqli_stmt_close($totalActionsStatement);

    // Préparer et exécuter la requête SQL pour compter le nombre d'actions réalisées ce mois-ci
    $thisMonthActionsQuery = "SELECT COUNT(*) AS actions_this_month FROM action WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')";
    $thisMonthActionsStatement = mysqli_prepare($this->connexion, $thisMonthActionsQuery);

    // Vérifier si la préparation de la requête a réussi
    if (!$thisMonthActionsStatement) {
        die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
    }

    mysqli_stmt_execute($thisMonthActionsStatement);
    mysqli_stmt_store_result($thisMonthActionsStatement);

    // Lier le résultat à une variable
    mysqli_stmt_bind_result($thisMonthActionsStatement, $actionsThisMonth);

    // Récupérer le nombre d'actions réalisées ce mois-ci
    mysqli_stmt_fetch($thisMonthActionsStatement);

    // Afficher le nombre d'actions réalisées ce mois-ci
    echo "<h4 class='text-center'>Actions réalisées ce mois-ci : $actionsThisMonth</h4>";

    // Fermer le statement de comptage des actions ce mois-ci
    mysqli_stmt_close($thisMonthActionsStatement);

    // Préparer et exécuter la requête SQL pour compter le nombre d'actions réalisées cette semaine
    $thisWeekActionsQuery = "SELECT COUNT(*) AS actions_this_week FROM action WHERE YEARWEEK(date) = YEARWEEK(CURRENT_DATE())";
    $thisWeekActionsStatement = mysqli_prepare($this->connexion, $thisWeekActionsQuery);

    // Vérifier si la préparation de la requête a réussi
    if (!$thisWeekActionsStatement) {
        die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
    }

    mysqli_stmt_execute($thisWeekActionsStatement);
    mysqli_stmt_store_result($thisWeekActionsStatement);

    // Lier le résultat à une variable
    mysqli_stmt_bind_result($thisWeekActionsStatement, $actionsThisWeek);

    // Récupérer le nombre d'actions réalisées cette semaine
    mysqli_stmt_fetch($thisWeekActionsStatement);

    // Afficher le nombre d'actions réalisées cette semaine
    echo "<h4 class='text-center'>Actions réalisées cette semaine : $actionsThisWeek</h4>";

    // Fermer le statement de comptage des actions cette semaine
    mysqli_stmt_close($thisWeekActionsStatement);

    // Préparer et exécuter la requête SQL pour compter le nombre d'actions réalisées aujourd'hui
    $todayActionsQuery = "SELECT COUNT(*) AS actions_today FROM action WHERE DATE(date) = CURRENT_DATE()";
    $todayActionsStatement = mysqli_prepare($this->connexion, $todayActionsQuery);

    // Vérifier si la préparation de la requête a réussi
    if (!$todayActionsStatement) {
        die("Erreur de préparation de la requête : " . mysqli_error($this->connexion));
    }

    mysqli_stmt_execute($todayActionsStatement);
    mysqli_stmt_store_result($todayActionsStatement);

    // Lier le résultat à une variable
    mysqli_stmt_bind_result($todayActionsStatement, $actionsToday);

    // Récupérer le nombre d'actions réalisées aujourd'hui
    mysqli_stmt_fetch($todayActionsStatement);

    // Afficher le nombre d'actions réalisées aujourd'hui
    echo "<h4 class='text-center'>Actions réalisées aujourd'hui : $actionsToday</h4>";

    // Fermer le statement de comptage des actions aujourd'hui
    mysqli_stmt_close($todayActionsStatement);

    // Préparer et exécuter la requête SQL sécurisée pour afficher les détails des administrateurs
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
    echo "<div class='table table-responsive'>
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
                } elseif ($this->isPasswordUsedBefore($id, $nouveauMdp)) {
                    $errors_update['verifmdpdifferent'] = "<span style='color:red;'>Ce mot de passe a déjà été utilisé par le passé.</span>";
                    return;
                } else {
                    // Hacher le mot de passe s'il est fourni
                    $hashedPassword = password_hash($nouveauMdp, PASSWORD_DEFAULT);
    
                    // Insérer l'ancien mot de passe dans la table vieux_mdps
                    $this->insertOldPassword($id, $nouveauMdp);
    
                    // Préparer et exécuter la requête de mise à jour avec changement de mot de passe
                    $query = "UPDATE user SET pseudo=?, email=?, nom=?, prenom=?, idRole=?, mdp=? WHERE id=?";
                }
            } else {
                // Préparer et exécuter la requête de mise à jour sans changer le mot de passe
                $query = "UPDATE user SET pseudo=?, email=?, nom=?, prenom=?, idRole=? WHERE id=?";
            }
    
            $statement = $this->connexion->prepare($query);
    
            // Vérifier si la préparation de la requête a réussi
            if ($statement) {
                // Lier les paramètres
                if (!empty($nouveauMdp)) {
                    $statement->bind_param("ssssisi", $nouveauPseudo, $nouvelEmail, $nouveauNom, $nouveauPrenom, $nouveauIdRole, $hashedPassword, $id);
                } else {
                    $statement->bind_param("ssssii", $nouveauPseudo, $nouvelEmail, $nouveauNom, $nouveauPrenom, $nouveauIdRole, $id);
                }
    
                // Exécuter la requête
                $statement->execute();
    
                // Vérifier si l'exécution a réussi
                if ($statement->affected_rows > 0) {
                    if ($_SESSION['id'] == $id) {
                        // Mettre à jour les informations dans la session si l'utilisateur modifie son propre profil
                        $_SESSION['pseudo'] = $nouveauPseudo;
                        $_SESSION['idRole'] = $nouveauIdRole;
                    }
                    // Récupérer l'action et l'IP de l'utilisateur qui fait une "action d'administrateur"
                    $action = "Modification réussie d'un administrateur";
                    $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);
    
                    // Rediriger vers la page admin.php
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
            // Si le formulaire n'a pas été soumis, afficher erreur
            echo "Le formulaire n'a pas été soumis.";
        }
    }
    
    // Méthode pour insérer l'ancien mot de passe dans la table vieux_mdps
    public function insertOldPassword($userId, $oldPassword) {
        // Hacher le mot de passe
        $hashedPassword = password_hash($oldPassword, PASSWORD_DEFAULT);
    
        // Préparer et exécuter la requête d'insertion
        $query = "INSERT INTO vieux_mdps (user_id, vieux_mdp) VALUES (?, ?)";
        $statement = $this->connexion->prepare($query);
    
        // Vérifier si la préparation de la requête a réussi
        if ($statement) {
            // Lier les paramètres et exécuter la requête
            $statement->bind_param("is", $userId, $hashedPassword);
            $statement->execute();
    
            // Vérifier si l'insertion a réussi
            if ($statement->affected_rows > 0) {
                // Succès de l'insertion
                echo "Ancien mot de passe haché inséré avec succès dans la table vieux_mdps.";
            } else {
                // Erreur lors de l'insertion
                echo "Erreur lors de l'insertion de l'ancien mot de passe haché dans la table vieux_mdps : " . $this->connexion->error;
            }
    
            // Fermer le statement
            $statement->close();
        } else {
            // Erreur de préparation de la requête
            echo "Erreur de préparation de la requête d'insertion dans la table vieux_mdps : " . $this->connexion->error;
        }
    }
    
    // Méthode pour vérifier si un mot de passe a déjà été utilisé par le passé
public function isPasswordUsedBefore($userId, $password) {
    // Préparer la requête pour récupérer les anciens mots de passe de l'utilisateur
    $query = "SELECT vieux_mdp FROM vieux_mdps WHERE user_id = ?";
    $statement = $this->connexion->prepare($query);

    // Vérifier si la préparation de la requête a réussi
    if ($statement) {
        // Lier le paramètre et exécuter la requête
        $statement->bind_param("i", $userId);
        $statement->execute();

        // Récupérer le résultat de la requête
        $result = $statement->get_result();

        // Parcourir les résultats pour vérifier si le mot de passe a été utilisé auparavant
        while ($row = $result->fetch_assoc()) {
            // Récupérer l'ancien mot de passe stocké dans la base de données
            $oldPasswordHash = $row['vieux_mdp'];

            // Vérifier si le mot de passe fourni correspond à l'ancien mot de passe
            if (password_verify($password, $oldPasswordHash)) {
                // Le mot de passe a été utilisé précédemment
                return true;
            }
        }

        // Aucun ancien mot de passe correspondant trouvé
        return false;

        // Fermer le statement
        $statement->close();
    } else {
        // Erreur de préparation de la requête
        echo "Erreur de préparation de la requête pour vérifier si le mot de passe a été utilisé avant : " . $this->connexion->error;
    }
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