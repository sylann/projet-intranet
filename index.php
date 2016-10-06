<?php
session_start();
require_once('include/connexion.php');
require_once('include/fonctions.php');

echo hautPage(); // head html meta, scrits, styles ...
echo afficheMenu(); // fonction ui affiche la barre de navigation



// Regarde si l'utilisateur est connecté
if (isConnected()) {
	// Mets dans la variable tab les derniers blogs
	$tab = getLastBlog(5);
	// Pour chaque post dispo, appelle la fonction Post
	foreach($tab as $post){
		echo affichePost($post);


		echo afficheHumeur();				  // Appelle la fonction Humeur
		echo afficheFaitJour();			  // Appelle la fonction FaitJour
		echo afficheGroupes();
	}
}


echo afficheFooter();					  // Appelle la fonction Footer
echo BasPage();
?>
