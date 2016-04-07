<?php
/**
* \Message de Sylann :
* \
* \ Lorsque vous ouvrez ce fichier pour y ajouter votre fonction, faites bien attention à ne pas modifier le reste du fichier
* \ Sauf si c'est nécessaire
* \
* \ La meilleur façon de faire est d'ajouter votre travail à la fin de ce fichier, en laissant deux
* \ lignes vides entre la dernière accolade et la première ligne de votre commentaire entète.
* \
* \ Pour l'entète, dans le doute, en reprendre un existant.
* \ Bon codage !
*/


/**
* \Autheur: Nicolas BOUYSSOUNOUSE.
* \Vérificateur: Romain VINCENT.
* \Brief: Vérifie si l'utilisateur est connecté.
* \Return: Retourne 'true' si l'array global $_session contient la chaine de caractère 'ID'.
*/
function isConnected(){
	return isset($_SESSION['ID']);
}


/**
* \Autheur: Thomas BERARD.
* \Vérificateur: Théo GUIBOUD-RIBAUD.
* \Brief: Génération du haut de la page HTML.
* \Return: <!DOCTYPE html> & co.
*/
function hautPage () {
	return '<!DOCTYPE html>
	<html>
	<head>
	<title>GREPSI</title>
	<meta charset="UTF-8">
	<meta name="description" content="GREPSI - EPSI Grenoble">
	<meta name="keywords" content="EPSI, Grenoble">
	<meta name="language" content="fr">
	<meta name="author" content="Thomas BERARD, Nicolas BOUYSSOUNOUSE, Adrien CECCALDI, Nathan DESCOMBES, Jérôme FABBIAN, Florian GOJON, Théo GUIBOUD-RIBAUD, Guillaume SAYEN, Valentin SOVIGNET, Romain VINCENT">
	<link rel="stylesheet" type="text/css" href="style/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style/grepsi.css">
	</head>
	<body>
	';
}


/**
* \Autheur: Thomas BERARD.
* \Vérificateur: Théo GUIBOUD-RIBAUD.
* \Brief: Génération du bas de la page HTML.
* \Return: </body> & </html>.
*/
function basPage () {
	return '</body>
	</html>';
}


/**
* \Autheur: Thomas BERARD.
* \Vérificateur: Théo GUIBOUD-RIBAUD.
* \Brief: Affiche la barre de navigation en tête de page.
* \Return: Barre de navigation.
*/
function afficheMenu () {
	return '<nav id="cssmenu">
	<ul>
	<li><a href="#">Accueil</a></li>
	<li><a href="#">page1</a></li>
	<li><a href="#">page2</a></li>
	<li><a href="#">page3</a></li>
	<li><a href="#">page4</a></li>
	<li><a href="#">page5</a></li>
	<li><input style="margin-top: 5px; margin-left: 15px; width: 150px; text-align: center" type="text" id="identifiant" name="identifiant" placeholder="Entrez votre identifiant"/></li>
	<li><input style="margin-top: 5px; margin-left: 15px; width: 150px; text-align: center" type="password" id="password" name="password" placeholder="Entrez votre password"/></li>
	<li><button type="submit">CONNEXION</button></li>
	</ul>
	</nav>
	';
}


/**
* \Autheur: Thomas BERARD.
* \Vérificateur: Jérôme FABBIAN.
* \Brief: Affiche le footer en bas de page.
* \Return: Footer complet.
*/
function afficheFooter () {
	return '<footer class="footer-distributed">
		<div class="footer-right">
			<a href="https://www.facebook.com/Campus.EPSI.Grenoble" target="_blank"><img class="icon-social-shrink" src="images/facebook-logo.png" alt="Facebook EPSI Grenoble"></a>
			<a href="https://twitter.com/EPSIGrenoble" target="_blank"><img class="icon-social-shrink" src="images/twitter-logo.png" alt="Twitter EPSI Grenoble"></a>
		</div>

		<div class="footer-left">
			<a href="http://www.epsi.fr" target="_blank"><img class="epsi-logo" src="images/epsi-logo.png" alt="Facebook EPSI Grenoble" width="120" border="0"></a>
		</div>
	</footer>
	';
}


/**
* \Autheur: Florian GOJON.
* \Vérificateur: Nathan
* \Brief: Génére un tableau avec les id des 25 derniers messages.
* \Return: tableau.
*/
function listeMessages() {
	global $p_base;
	$requete = $p_base->query('select id, date from tchat order by date asc limit 25');
	$table = array();
	while($resultat = $requete->fetch()) {
		$table[] = $resultat['id'];
	}
	return $table;
}


/**brief : fonction qui génère le div « humeur du jour »
Entrée : Rien
Sortie : Chaîne
Formate une chaîne html qui affiche sélectionne une humeur au hasard dans la table et l'affiche*/
function affichehumeur(){
	global $p_base;
	try{
		$requete = $p_base->query("select contenu from tchat where humeur=1 ORDER BY rand() LIMIT 0,1");
		$resultat=$requete->fetch();
		return '<div class="humeur">'.$resultat['contenu'].'</div>';
	}
	catch(Exception $e){
		die ('Erreur : '.$e->getMessage());
	}
}


function getUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base
	/**
	*\brief Retourner un tableau chargé des infos de l'utilisateur
	*\author = Valentin
	*\checker = ?
	*\param = idUtilisateur entier
	*\return un tableau*/
	try{
		$p_requete = $p_base->prepare("SELECT * FROM personne WHERE id = :idUtilisateur");		//requête SQL nous donnant toutes les informations d'un utilisateur
		$p_requete->execute(array('idUtilisateur'=> $idUtilisateur));
		$donnees = $p_requete->fetch();

		$tableauUtilisateur["mail"] = $donnees['mail'];					//on met toutes les informations de la table dans le tableau
		$tableauUtilisateur["password"] = $donnees['password'];
		$tableauUtilisateur["nom"] = $donnees['nom'];
		$tableauUtilisateur["prenom"] = $donnees['prenom'];
		$tableauUtilisateur["statut"] = $donnees['statut'];
		$tableauUtilisateur["pseudo"] = $donnees['pseudo'];
		$tableauUtilisateur["datenaiss"] = $donnees['datenaiss'];
		$tableauUtilisateur["tel"] = $donnees['tel'];
		$tableauUtilisateur["telpublic"] = $donnees['telpublic'];
		$tableauUtilisateur["photo"] = $donnees['photo'];
		$tableauUtilisateur["avatar"] = $donnees['avatar'];
		$tableauUtilisateur["cv"] = $donnees['cv'];
		$tableauUtilisateur["cvpublic"] = $donnees['cvpublic'];
		$tableauUtilisateur["devise"] = $donnees['devise'];
		$tableauUtilisateur["signature"] = $donnees['signature'];
		$tableauUtilisateur["acceptmails"] = $donnees['acceptmails'];
		$tableauUtilisateur["nbpost"] = $donnees['nbpost'];
		$tableauUtilisateur["nblikes"] = $donnees['nblikes'];
		$tableauUtilisateur["nbarticles"] = $donnees['nbarticles'];
		$tableauUtilisateur["nbcontribution"] = $donnees['nbcontribution'];

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
	return $tableauUtilisateur;		//on retourne le tableau
}

function chargeUtilisateur($tableauUtilisateur){
	/**
	*\brief mettre les informations de l'utilisateur dans les $_SESSION
	*\author = Valentin
	*\checker = ?
	*\param = tableauUtilisateur tableau
	*\return rien*/
	foreach($tableauUtilisateur as $key => $value){		//pour chaque valeur dans le tableau
		$_SESSION[$key] = $value;						//on assigne une valeur à cette variable de session
	}
}

function afficheUtilisateur($tableauUtilisateur){
	/**
	*\brief Renvoie les informations de l'utilisateur (sa fiche)
	*\author = Valentin
	*\checker = ?
	*\param = tableauUtilisateur tableau
	*\return string*/
	$chaine = "";
	foreach($tableauUtilisateur as $key => $value){				//pour chaque valeur dans le tableau
		$chaine .= '<p>-- ' . $key . ' : ' . $value . '</p>';	//on fait des paragraphes avec ce qu'est la variable et sa valeur
	};
	return'<div>' . $chaine . '</div>';						//on return la chaine
}

function afficheMiniUtilisateur($tableauUtilisateur){
	/**
	*\brief Renvoie les informations de l'utilisateur sous la forme d'une mini fiche
	*\author = Valentin
	*\checker = ?
	*\param = tableauUtilisateur tableau
	*\return string*/
	return'<img src="' . $tableauUtilisateur['photo'] . '" title="Nom : ' . $tableauUtilisateur['nom'] . ', Prenom : ' . $tableauUtilisateur['prenom'] .'">';
}

?>
