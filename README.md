# Cabinet-Dentaire-Dumitrascu-Roxana
Code source (données sensibles censurées) du cabinet dentaire Dumitrascu Roxana

# Comment faire fonctionner le site web ?
- Placez le code source de façon à pouvoir l'exécuter dans un environnement comme WampServer ou XAMPP
- Récupérez le fichier .sql et importez-la dans une base de données avec PHPMyAdmin, n'hésitez pas à regarder dans le fichier /Include/Database/config.php pour mettre les bonnes informations afin de faire la connexion avec la base de données.
- N'hésitez pas à faire les modifications concernant le reCAPTCHA v3 (**cela concerne les fichiers suivants : "login.php", "contact.php", "/Include/Modele/Authentification.php", n'hésitez pas à jeter un oeil dans le code source et à faire les modifications adéquates (voir dans la partie "# Configurer clé publique / clé privée via reCAPTCHA v3 de Google" si besoin d'aide**)
- Amusez-vous bien !

# Configurer clé publique / clé privée via reCAPTCHA v3 de Google
- D'abord, allez sur le lien : https://www.google.com/u/2/recaptcha/admin/create
- Mettez le libellé que vous souhaitez, puis "Sur la base d'un score (v3)", et pour la partie Domaines, mettez 127.0.0.1 si vous testez le site en localhost
- Une fois les conditions d'utilisation acceptées, vous obtenez enfin votre clé publique et votre clé privée (**attention à ne pas confondre les deux**).
- **Vous devez remplacer les XXXXX par la suite de caractères indiquée :**
- 
  **>** Lignes à modifier avec la clé privée : login.php (ligne 12), contact.php (ligne 81)
  
  **>** Lignes à modifier avec la clé publique : login.php (lignes 58 & 68), contact.php (lignes 257 & 262)
- Testez ! Attention à ne pas faire d'erreur lors du remplacement des caractères par vos clés !

# Comment accéder à la partie "admin" ?
- Accédez à la page "login.php"
- Rentrez le nom d'utilisateur "admin" puis le mot de passe "LeTestFonctionn3n1en@_"
- Et voilà, un bouton "ADMIN" en jaune devrait apparaître en haut à droite.
