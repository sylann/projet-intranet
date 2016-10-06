<?php

require_once('include/connexion.php');
require_once('include/fct_common.php');
require_once('include/fct_trombi.php');

if (!isConnected()) {            // Regarde si l'utilisateur est connecté
 die('Page inaccessible');      // Si il ne l'est pas, ne charge pas la page
}

include("include/haut_page.html"); // head html meta, styles ...
echo afficheMenu(); // fonction qui affiche la barre de navigation

echo afficheChat ();             // Si connecté, affiche le chat grâce à sa fonction

if ($_GET['groupe'] == '') {     // Si la valeur $_GET de groupe est vide
	echo afficheGroupes ();        // Appelle la fonction afficheGroupes responsable d'afficher la liste des groupes
}
else {                           // Sinon
	echo afficheTrombinoscope ();  // Appelle la fonction afficheTrombinoscope
}

echo afficheFooter();
include("include/bas_page.html"); // scripts, balise fermantes
?>
