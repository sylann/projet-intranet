<?php

require_once('include/connexion.php');
require_once('include/fonctions.php');

if (!isConnected()) {            // Regarde si l'utilisateur est connecté
 die('Page inaccessible');      // Si il ne l'est pas, ne charge pas la page
}

echo hautPage(); // head html meta, scrits, styles ...
echo afficheMenu(); // fonction qui affiche la barre de navigation

echo afficheChat ();             // Si connecté, affiche le chat grâce à sa fonction

if ($_GET['groupe'] == '') {     // Si la valeur $_GET de groupe est vide
	echo afficheGroupes ();        // Appelle la fonction afficheGroupes responsable d'afficher la liste des groupes
}
else {                           // Sinon
	echo afficheTrombinoscope ();  // Appelle la fonction afficheTrombinoscope
}

echo afficheFooter();
echo BasPage(); // balises body et html fermantes
?>


<?php

/*
* \Autheur: Jérôme.
* \Vérificateur: Romain VINCENT.
* \Brief: Retourne la page d'affichage du trombinoscope en étant connecté.
* \print: Ecran complet de trombinoscope.
*/

include('include/fonctions.php');// Appelle la liste des fonctions



echo afficheFooter ();           // Appelle la fonction Footer
echo BasPage ();                 // Appelle la fonction Baspage

?>
