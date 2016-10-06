<?php


/**
*\author Nicolas
*\checker ?
*\brief vérifi si le fichier exsiste puis change $_SESSION['arborescence'] en le nom du repertoir mis en argument.
*\return boolval
*\param /a $pathRequest
*/
function setArborescence($pathRequest){
    if (is_dir('./'.PATH.'/'.$pathRequest)){
        $_SESSION['arborescence']='/share/'.$pathRequest;
    }
    else {
        return false;
    }
}


/**
*\author Alexandre et Charles
*\checker Nicolas
*\brief . Génère l'affichage d’un bouton de téléchargement de fichiers.
*\return chaine html
*\param rien
*/
function AfficheBoutonTelecharger(){
        return '<input type=submit name="Telecharger" value="Telecharger" />'; // mettre une action
}


/**
*\author Alexandre et Charles
*\checker Théo
*\brief . Génère l'affichage d’un bouton de suppression de fichiers.
*\return chaine html
*\param rien
*/
function AfficheBoutonSupprimer(){
        return '<input type=submit name="Supprimer" value="Supprimer" />'; // mettre une action
}


/**
*\author Valentin
*\checker ?
*\brief Génère l'affichage d’un form pour renommer un fichier.
*\return chaine html
*\param rien
*/
function afficheFormRenommer(){
	if(isset($_GET['idFichier'])){			//si il y a bien un param idFichier dans l'url
		if(!empty($_GET['idFichier'])){
			global $p_base;			//pour avoir accès à la la variable $p_base
			try{
				$p_requete = $p_base->prepare("SELECT id, label as nomFichier FROM partage WHERE id = :id");		//requête SQL récupérant le nom du fichier
				$p_requete->execute(array('id'=> $_GET['idFichier']));
				$donnees = $p_requete->fetch();
				$nomFichier = $donnees['nomFichier'];
				$p_requete->closeCursor(); 		// Termine le traitement de la requête
			}
			catch(Exception $e){
			// En cas d'erreur précédemment, on affiche un message et on arrête tout
				die('Erreur : '.$e->getMessage());
			}


			return '<form method="post"><input type="text" placeholder="Nom du fichier" name="nomFichier" value="'.$nomFichier.'" /> <input type="hidden" value="'.$_GET['idFichier'].'" name="idFichier" /> <input type="submit" name="submitNomFichier"></form>';		//on return le form
			//notez bien le input type="hidden", il permet de passer l'id du fichier dans le form pour la fonction renommerFichier()
		}
		else{
			header("location: index.php");
		}
	}
	else{
		header("location: index.php");		//dans le cas où on a entré l'url à la main, on redirige vers l'index
	}
}


/**
*\author Valentin
*\checker ?
*\brief renomme le fichier selon un input text
*\return rien
*\param id du fichier
*/
function renommerFichier($idFichier){
	global $p_base;			//pour avoir accès à la la variable $p_base

	if(!empty($_POST['nomFichier'])){		//si l'utilisateur a bien saisi un nom de fichier
		if(isset($_POST['idFichier'])){		//au cas où un malin enlève le input hidden
			if(!empty($_POST['idFichier'])){	//on enlève la value de ce dernier
				try{
					$p_requete = $p_base->prepare("SELECT chemin, label FROM partage WHERE id = :id");		//requête SQL nous donnant le chemin du fichier
					$p_requete->execute(array('id'=> $idFichier));
					$donnees = $p_requete->fetch();
					$chemin = $donnees['chemin'];
					$nomFichier = $donnees['label'];
					$p_requete->closeCursor(); 		// Termine le traitement de la requête

					if(rename($chemin.$nomFichier,$chemin.$_POST['nomFichier'])){		//si le rename se passe bien
						$p_requete = $p_base->prepare("UPDATE partage SET label = :nomFichier");		//requête SQL mettant à jour le nom du fichier
						$p_requete->execute(array('nomFichier'=> $_POST['nomFichier']));
						$p_requete->closeCursor(); 		// Termine le traitement de la requête

						return '<div class="resultatRename"><p>Succès</p></div>';
					}
					else{	//si il y a une erreur
						return '<div class="resultatRename"><p>Erreur</p></div>';
					}


				}
				catch(Exception $e){
				// En cas d'erreur précédemment, on affiche un message et on arrête tout
					die('Erreur : '.$e->getMessage());
				}
			}
		}
	}
}

/**
*\author Florian
*\checker Thomas
*\Brief : Affiche un bouton qui permet d'ajouter un nouveau dossier.
*\param : rien
*\return : Une chaine html */
function afficheBoutonNouveauDossier() {
	return '<input type="submit" class="boutonNewDir" name="Nouveau Dossier" value="" >';
}

/**
*\author Florian
*\checker Romain
*\Brief : Fonction qui permet d'ajouter un nouveau dossier
*\param : le nom du repertoire a creer
*\return : true or false */
function nouveauDossier($repertoire){
	return mkdir ( $repertoire, 775);
}

/**
*\author Florian
*\checker Romain (pas encore fini)
*\Brief : Permet d'aller de -1 dans l'arborescence du gestionnaire de fichier
*\return : rien */
function boutonRetour(){
	$chemin = getArborescence();       // Insert la chaine de l'arborescence dans $chemin
	$taille = strlen($chemin);         // Calcul la taille de la chaine $chemin
	$depth = 0;                        // Profondeur de l'arborescence
	$supr = 0;                         // Initialise le compteur de caractére qu'il faut enlever
	for($chemin, $taille, $taille--){
		$supr++                          // Pour chaque caratére jusèu'à le deuxième / on augmente de 1
		if     ($chemin[$taille]== '/'){ // Si le caractére est un / on augmente de 1 le compteur
			$depth++;
		}
		elseif ($chemin[$taille] == '/' and compteur != 0) { // Si le caractére est un / et que le compteur est déjà a 1 alors on coupe la nouvelle chaine
			$supr--;                                           // Supr - 1 car on veut garder le deuxiéme /
			$chemin = substr($chemin, 0, -$supr);              // Supprime tout ce qu'il y a aprés le deuxiéme / en partant de la fin
			break;
		}
		break;
	}
	header('location:'. $chemin);
}

?>
