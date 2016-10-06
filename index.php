<?php
session_start();
require_once('include/connexion.php');
require_once('include/fct_common.php');
require_once('include/fct_accueil.php');

include("include/haut_page.html"); // head html meta, styles ...
echo afficheMenu(); // fonction ui affiche la barre de navigation

// Regarde si l'utilisateur est connecté
if (isConnected()) {
	// Mets dans la variable tab les derniers blogs
	$tab = getLastBlog(5);
	// Pour chaque post dispo, appelle la fonction Post
	foreach($tab as $post){
		echo affichePost($post);
	}
}

?>

<!-- Ajouter votre contenu ici
 doit appeler la fonction correspondante

 pensez à tout ce qu'il faudrait ajouter et qui n'est peut-être pas encore prévu

 faites des commentaires dans trello !! :-)
-->

<?php

echo "666 Bienvenue sur le site de l'enfer 999";

echo afficheFooter();     // Appelle la fonction Footer
include("include/bas_page.html"); // scripts, balise fermantes

?>
