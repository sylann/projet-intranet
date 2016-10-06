<?php

require_once('include/connexion.php');
require_once('include/fonctions.php');

if (!isConnected()) {            // Regarde si l'utilisateur est connecté
 die('Page inaccessible');      // Si il ne l'est pas, ne charge pas la page
}

echo hautPage(); // head html meta, scrits, styles ...
echo afficheMenu(); // fonction qui affiche la barre de navigation

 ?>

 <!-- Ajouter votre contenu ici
  doit appeler la fonction correspondante

  pensez à tout ce qu'il faudrait ajouter et qui n'est peut-être pas encore prévu

  faites des commentaires dans trello !! :-)
 -->

<?php

echo afficheFooter();
echo BasPage(); // balises body et html fermantes
?>
