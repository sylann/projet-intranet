<?php
include('include/fonctions.php');
	echo afficheHautPage ();  				// Apelle la fonction HautePage
	echo afficheMenu ();      				// Apelle la fonction Menu
	if (isConnecte) {		  				// Regarde si l'utilisateur est connecté
		echo afficheChat ();  				// Si conecté affiche le chat grace à ça fonction
		$tab = getLastBlog(5);				// Mets dans la variable tab les derniers blogs
			foreach($tab as $post){			
				echo affichePost($post);	// Apelle la fonction Post
			}
		echo afficheHumeur ();				// Apelle la fonction Humeur
		echo afficheFaitJour ();			// Apelle la fonction FaitJour
	}
	
	
	echo afficheFooter ();					// Apelle la fonction Footer
	echo BasPage ();
?>


