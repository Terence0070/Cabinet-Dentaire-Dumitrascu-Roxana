<?php 
ob_start();
$metaRobots = '<meta name="robots" content="noindex, nofollow">';
$title = "Administration";
$metaDescription = "";
require_once ('Include/Menu/header.php'); 

// Inclure la classe UserTable
require_once ('Include/Modele/UserTable.php');
?>

<header class="pistache-background pt-4 pb-1">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Gestion des administrateurs</h1>
    </div>
</header>

<?php
// Créer une instance de la classe userTable avec la connexion à la base de données
$userTable = new UserTable($connexion);

// Vérifier si l'utilisateur est bien un administrateur
$userTable->checkAdmin();

// Vérifier si l'ID de l'admin à supprimer est présent dans l'URL
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Appeler la méthode deleteUser pour supprimer un admin précis
    $userTable->deleteUser($id);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $idRole = htmlspecialchars($_POST['idRole']);

    // Appeler la méthode addUser pour ajouter un administrateur
    $userTable->addUser($email, $mdp, $pseudo, $prenom, $nom, $idRole);
}

// Appeler la méthode displayAdminUsers pour afficher les administrateurs
$userTable->displayAdminUsers();
?>

    <div class="container mt-4">
        <!-- Formulaire d'ajout d'administrateur -->
        <form action="admin.php" method="POST">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe (doit contenir minimum 12 caractères, des caractères spéciaux (exemple : _-/ etc.), un chiffre et une majuscule):</label>
                <input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <div class="form-group">
                <label for="pseudo">Pseudo :</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="idRole">Rôle :</label>
                <select class="form-select" id="idRole" name="idRole" required>
                    <option value="1">Administrateur (1)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-2">Ajouter administrateur</button>
        </form>
    </div>
</section>

<?php 
require_once ('Include/Menu/footer.php'); 
ob_end_flush();
?>