<?php

function isConnected(){
	// Author Nicolas
	// Checker Romain
	// Renvois 'true' si l'array global $_session contient la chaine de caractère 'ID'
	return isset($_SESSION['ID']);
}

function hautPage () {
	/** Retourne le code HTML du haut de la page HTML.
	Author = Thomas
	Checker = Romain*/
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

function basPage () {
	/** Retourne le code HTML du bas de la page HTML.
	Author = Thomas
	Checker = Romain*/
	return '</body>
</html>';
}

function afficheMenu () {
	/** Retourne le code HTML de la navbar en tête de page.
	Author = Thomas
	Checker = Romain*/
	return '<nav id="cssmenu">
	<ul>
	<li><a href="#">Accueil</a></li>
	<li><a href="#">page1</a></li>
	<li><a href="#">page2</a></li>
	<li><a href="#">page3</a></li>
	<li><a href="#">page4</a></li>
	<li><a href="#">page5</a></li>
	</ul>
	</nav>
';
}

function afficheFooter () {
	/** Retourne le code HTML du footer pour le bas de page.
	Author = Thomas
	Checker = Romain*/
	return '<footer id="cssfooter">
	<ul>
	<li id="epsi-logo"><a href="http://www.epsi.fr" target="_blank"><img src="images/epsi-logo.png" width="100px"></a></li>
</footer>
';
}

function getUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base
	/**
	\brief Retourner un tableau chargé des infos de l'utilisateur
	\author = Valentin
	\checker = ?
	\param = idUtilisateur entier
	\return un tableau*/
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
	\brief mettre les informations de l'utilisateur dans les $_SESSION
	\author = Valentin
	\checker = ?
	\param = tableauUtilisateur tableau
	\return rien*/
	foreach($tableauUtilisateur as $key => $value){		//pour chaque valeur dans le tableau
		$_SESSION[$key] = $value;						//on assigne une valeur à cette variable de session
	}
}

function afficheUtilisateur($tableauUtilisateur){
	/**
	\brief Renvoie les informations de l'utilisateur (sa fiche)
	\author = Valentin
	\checker = ?
	\param = tableauUtilisateur tableau
	\return string*/
	$chaine = "";
	foreach($tableauUtilisateur as $key => $value){				//pour chaque valeur dans le tableau
		$chaine .= '<p>-- ' . $key . ' : ' . $value . '</p>';	//on fait des paragraphes avec ce qu'est la variable et sa valeur
	};
	return'<div>' . $chaine . '</div>';						//on return la chaine
}
?>