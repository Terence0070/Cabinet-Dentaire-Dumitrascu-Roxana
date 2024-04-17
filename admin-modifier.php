<?php 
ob_start();
$metaRobots = '<meta name="robots" content="noindex, nofollow">';
$title = "Modification de l'admin";
$metaDescription = "";
require_once ('Include/Menu/header.php'); 

// Inclure la classe UserTable
require_once ('Include/Modele/UserTable.php');
?>

<?php
$errors_update = array('verifmdpdifferent' => '', 'verifmdptropcourt' => '');
$userTable = new UserTable($connexion);

// Vérifier si l'utilisateur est bien un administrateur
$userTable->checkAdmin();

if (isset($_GET['id'])) { 
    // Récupérez l'ID de l'utilisateur depuis l'URL
    $id = $_GET['id'];
    $showForm = true;

    // Récupérez les informations de l'utilisateur à modifier
    $query = "SELECT pseudo, email, nom, prenom, idRole FROM user WHERE id = ?";
    $statement = mysqli_prepare($connexion, $query);

    if (!$statement) {
        die("Erreur lors de la préparation de la requête : " . mysqli_error($connexion));
    }

    mysqli_stmt_bind_param($statement, 'i', $id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $pseudo, $email, $nom, $prenom, $idRole);

    mysqli_stmt_fetch($statement);

    mysqli_stmt_close($statement);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $nouveauPseudo = $_POST['pseudo'];
        $nouvelEmail = $_POST['email'];
        $nouveauNom = $_POST['nom'];
        $nouveauPrenom = $_POST['prenom'];
        $nouveauIdRole = $_POST['idRole'];
        $nouveauMdp = $_POST['mdp'];
        $confirmerMdp = $_POST['confirmerMdp'];

        // Appeler la méthode addUser pour ajouter un administrateur
        $userTable->updateUser($id, $nouveauPseudo, $nouvelEmail, $nouveauNom, $nouveauPrenom, $nouveauIdRole, $nouveauMdp, $confirmerMdp);
    }
}
?>

<header class="pistache-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Modification de l'admin</h1>
    </div>
</header>

<div class="container mt-3">
    <h2>Modifier l'utilisateur</h2>

    <span class=error><?php echo $errors_update['verifmdpdifferent']; ?></span>
    <span class=error><?php echo $errors_update['verifmdptropcourt']; ?></span>

    <form method="POST">
        <div class="form-group">
            <label for="pseudo">Pseudo :</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>
        </div>
        <div class="form-group">
            <label for="idRole">ID du Rôle :</label>
            <input type="number" class="form-control" id="idRole" name="idRole" value="<?php echo $idRole; ?>" required>
        </div>
        <div class="form-group">
            <label for="mdp">Nouveau mot de passe :</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Laissez vide pour ne pas changer">
        </div>
        <div class="form-group">
            <label for="confirmerMdp">Confirmer le mot de passe :</label>
            <input type="password" class="form-control" id="confirmerMdp" name="confirmerMdp" placeholder="Confirmez le mot de passe">
        </div>
        <button type="submit" class="btn btn-primary w-100 mt-2">Enregistrer les modifications</button>
    </form>
</div>

<?php 
require_once ('Include/Menu/footer.php'); 
ob_end_flush();
?>