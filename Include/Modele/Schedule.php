<?php
class Schedule {
    private $connexion;

    /**
     * @param __construct $connexion
     * Permet une connexion à la base de données
     * $connexion -> Toutes les données nécessaires pour se connecter à la BDD
     */
    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    /**
     * @param checkAdmin
     * Vérifie que l'utilisateur est bien un administrateur
     */
    public function checkAdmin() {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }
    }

    /**
     * @param addSchedule $nom, $date_complet, $heure_debut, $heure_fin
     * Permet d'ajouter une horaire qui sera traité dans le tableau (avec la librairie JS "FullCalendar)
     * $nom -> Le nom de l'horaire (string)
     * $date_complet -> Le jour précis de l'horaire (string)
     * $heure_debut -> Quand est-ce que commence l'horaire (string)
     * $heure_fin -> Quand est-ce que termine l'horaire (string)
     */
    public function addSchedule($nom, $date_complet, $heure_debut, $heure_fin) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        $query = "INSERT INTO horaires (nom, date_complet, heure_debut, heure_fin) VALUES (?, ?, ?, ?)";
        if ($heure_debut >= $heure_fin) {
            return false;
        } else {
            $statement = $this->connexion->prepare($query);
            $statement->bind_param("ssss", $nom, $date_complet, $heure_debut, $heure_fin);
            if ($statement->execute()) {
                // Récupérer l'action de l'administrateur ainsi que son IP
                $action = "Ajout d'une horaire réussie";
                $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);

                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @param addMultipleSchedule
     * Permet d'ajouter plusieurs horaires qui seront ainsi traités dans le tableau
     */
    function addMultipleSchedule($type, $heure_debut_lundi, $heure_debut_mardi, $heure_debut_mercredi, $heure_debut_jeudi, $heure_debut_vendredi, $heure_fin_lundi, $heure_fin_mardi, $heure_fin_mercredi, $heure_fin_jeudi, $heure_fin_vendredi, $date_debut, $date_fin) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        // Requête SQL pour insérer les horaires
        $query = "
        INSERT INTO horaires (nom, date_complet, heure_debut, heure_fin)
        SELECT ?, dates.date_complet,
            CASE 
                WHEN DAYOFWEEK(dates.date_complet) = 2 THEN ? -- Lundi
                WHEN DAYOFWEEK(dates.date_complet) = 3 THEN ? -- Mardi
                WHEN DAYOFWEEK(dates.date_complet) = 4 THEN ? -- Mercredi
                WHEN DAYOFWEEK(dates.date_complet) = 5 THEN ? -- Jeudi
                WHEN DAYOFWEEK(dates.date_complet) = 6 THEN ? -- Vendredi
            END AS heure_debut,
            CASE 
                WHEN DAYOFWEEK(dates.date_complet) = 2 THEN ? -- Lundi
                WHEN DAYOFWEEK(dates.date_complet) = 3 THEN ? -- Mardi
                WHEN DAYOFWEEK(dates.date_complet) = 4 THEN ? -- Mercredi
                WHEN DAYOFWEEK(dates.date_complet) = 5 THEN ? -- Jeudi
                WHEN DAYOFWEEK(dates.date_complet) = 6 THEN ? -- Vendredi
            END AS heure_fin
        FROM (
            SELECT DATE_ADD(?, INTERVAL (t4*10000 + t3*1000 + t2*100 + t1*10 + t0) DAY) AS date_complet
            FROM
                (SELECT 0 t0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t0,
                (SELECT 0 t1 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t1,
                (SELECT 0 t2 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t2,
                (SELECT 0 t3 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t3,
                (SELECT 0 t4 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) t4
        ) dates
        WHERE dates.date_complet BETWEEN ? AND ?";
            
        // Préparer la requête
        $statement = mysqli_prepare($this->connexion, $query);

        // Vérifier si la préparation de la requête a réussi
        if (!$statement) {
            die("Erreur de préparation de la requête : " . mysqli_error($connexion));
        }

        // Binder les valeurs
        mysqli_stmt_bind_param($statement, "ssssssssssssss", $type, $heure_debut_lundi, $heure_debut_mardi, $heure_debut_mercredi, $heure_debut_jeudi, $heure_debut_vendredi, $heure_fin_lundi, $heure_fin_mardi, $heure_fin_mercredi, $heure_fin_jeudi, $heure_fin_vendredi, $date_debut, $date_debut, $date_fin);
        
        // Exécuter la requête
        mysqli_stmt_execute($statement);

        if ($statement->execute()) {
            // Récupérer l'action de l'administrateur ainsi que son IP
            $action = "Ajout de plusieurs horaires réussies";
            $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);

            return true;
        } else {
            return false;
        }
        
        // Fermeture du statement
        mysqli_stmt_close($statement);
    }

    /**
     * @param deleteSchedule $id
     * Effacer une horaire avec son identifiant (elles sont toutes identifiables grâce à une id en clé primaire)
     * $id = l'identifiant unique de l'horaire (int)
     */
    public function deleteSchedule($id) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        $query = "DELETE FROM horaires WHERE id=?";
        $statement = $this->connexion->prepare($query);
        $statement->bind_param("i", $id);
        if ($statement->execute()) {
            // Récupérer l'action de l'administrateur ainsi que son IP
            $action = "Suppression d'une horaire réussie";
            $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param deleteMultipleSchedules
     * Supprimer plusieurs horaires entre telle date et telle date
     */
    public function deleteMultipleSchedule($date_debut, $date_fin) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        $query = "DELETE FROM horaires WHERE date_complet BETWEEN ? AND ?";
        $statement = $this->connexion->prepare($query);
        $statement->bind_param("ss", $date_debut, $date_fin);

        if ($statement->execute()) {
            // Récupérer l'action de l'administrateur ainsi que son IP
            $action = "Suppression de plusieurs horaires réussies";
            $this->ipRecup($_SERVER['REMOTE_ADDR'], $action);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param getAllSchedules
     * Récupérer toutes les horaires pour les afficher dans un joli tableau (merci FullCalendar ❤️)
     */
    public function getAllSchedules() {
        $query = "SELECT * FROM horaires";
        $result = $this->connexion->query($query);
    
        $schedules = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $schedules[] = $row;
            }
        }
    
        return $schedules;
    }

    /**
     * @param ipRecup $ip $action
     * Permet de récupérer l'action, la date précise et l'ip de l'individu procédant à une modification (normalement réservé à un administrateur)
     * ce qui est pratique pour surveiller qu'il n'y ait pas de piratage
     * $ip -> l'ip de l'utilisateur (string)
     * $action -> l'action de l'utilisateur (string)
     */
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
    /* NON UTILISE DANS LE CADRE DE CE SITE (à voir si un autre dev' veut prendre la relève s'il en juge pertinent)
    public function updateSchedule($id, $nom, $date_complet, $heure_debut, $heure_fin) {
        // Vérifier si l'utilisateur a le rôle nécessaire
        if (!isset($_SESSION['idRole']) || $_SESSION['idRole'] != 1) {
            header('Location: index.php');
            exit();
        }

        $query = "UPDATE horaires SET nom=?, date_complet=?, heure_debut=?, heure_fin=? WHERE id=?";
        $statement = $this->connexion->prepare($query);
        $statement->bind_param("ssssi", $nom, $date_complet, $heure_debut, $heure_fin, $id);
        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }
    */
?>
