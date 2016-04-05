<?php

/*
* \Autheur: Jérôme.
* \Vérificateur: Romain VINCENT.
* \Brief: Retourne la page d'affichage du trombinoscope en étant connecté.
* \print: Ecran complet de trombinoscope.
*/

include('include/fonctions.php');			// Appelle la liste des fonctions

if (!isConnected()) {					// Regarde si l'utilisateur est connecté
	die('Page inaccessible');			// Si il ne l'est pas, ne charge pas la page
}	
	  				
echo afficheHautPage ();  				// Appelle la fonction HautPage
echo afficheMenu ();      				// Appelle la fonction Menu
echo afficheChat ();  					// Si connecté, affiche le chat grâce à sa fonction

if ($_GET['groupe'] == '') {				// Si la valeur $_GET de groupe est vide
	echo afficheGroupes ();				// Appelle la fonction afficheGroupes responsable d'afficher la liste des groupes
}
else {							// Sinon
	echo afficheTrombinoscope ();			// Appelle la fonction afficheTrombinoscope
}

echo afficheFooter ();					// Appelle la fonction Footer
echo BasPage ();					// Appelle la fonction Baspage

?>
