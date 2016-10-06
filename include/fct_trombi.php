<?php

/**
*\author Valentin
*\checker Adrien
*\brief Renvoie une chaine html permettant d'afficher le trombinoscope d'un groupe d'utilisateurs
*\param = idGroupe
*\return string*/
function afficheTrombinoscope($idGroupe){
	global $p_base;			//pour avoir accès à la la variable $p_base
	$chaineTrombi = "<div>";
	try{
		$p_requete = $p_base->query("SELECT idpersonne FROM membre WHERE idgroupe = $idGroupe");
		while($donnees = $p_requete->fetch()){
			$idPersonne = $donnees['idpersonne'];

			$p_requete2 = $p_base->query("SELECT id, nom, prenom, photo FROM personne WHERE id = $idPersonne");
			$donnees2 = $p_requete2->fetch();

			$tableauReduit['id'] = $donnees2['id'];
			$tableauReduit['nom'] = $donnees2['nom'];
			$tableauReduit['prenom'] = $donnees2['prenom'];
			$tableauReduit['photo'] = $donnees2['photo'];

			$chaineTrombi .= afficheMiniUtilisateur($tableauReduit);

			$p_requete2->closeCursor(); 		// Termine le traitement de la requête
		}

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
	$chaineTrombi .= "</div>";
	return $chaineTrombi;
}



/**
*\author Romain
*\checker ?
*\brief Renvoie une chaine html qui permet d'afficher les groupes avec un lien vers leur trombinoscope
*\return chaine html
*/
function afficheGroupes(){
	global $p_base;			//pour avoir accès à la la variable $p_base
	$groupes = '<div class="container-all-groups">';

	try{
		$p_requete = $p_base->query("SELECT * FROM groupe");
		while($donnees = $p_requete->fetch()){
			$groupes .= '<a href="tombinoscope.php?groupe='.$donnees['id'].'"
			<div class="container-group" style="background:(url:"'.$donnees['logo'].'");">
				<h3>'.$donnees['label'].'</h3>
				<p>'.$donnees['devise'].'</p>
			</div></a>';
		}

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}

	$groupes .= "</div>";
	return $groupes;
}


/**
*\author Valentin
*\checker Adrien
*\brief Renvoie les informations de l'utilisateur sous la forme d'une mini fiche
*\la fiche est cliquable pour accèder à la page complète de l'utilisateur
*\param = idUtilisateur integer
*\return string*/
function afficheMiniUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base

	try{
		$p_requete = $p_base->prepare("SELECT id, nom, prenom, photo FROM personne WHERE id = :idUtilisateur");		//requête SQL nous donnant toutes les informations d'un utilisateur
		$p_requete->execute(array('idUtilisateur'=> $idUtilisateur));
		$donnees = $p_requete->fetch();

		return'<a href="personne.php?id=' . $donnees['id'] . '">
			<img src="' . $donnees['photo'] . '" title="Nom : ' . $donnees['nom'] . '   Prenom : ' . $donnees['prenom'] .'">
		</a>';

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}


?>
