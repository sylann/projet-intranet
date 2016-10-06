<?php
/**
* Message de Sylann :
*
* Lorsque vous ouvrez ce fichier pour y ajouter votre fonction, faites bien attention à ne pas modifier le reste du fichier
* Sauf si c'est nécessaire
*
* La meilleur façon de faire est d'ajouter votre travail à la fin de ce fichier, en laissant deux
* lignes vides entre la dernière accolade et la première ligne de votre commentaire entète.
*
* Pour l'entète, dans le doute, en reprendre un existant.
* Bon codage !
*/

/**
*\author Nicolas
*\checker Romain VINCENT
*\brief Vérifie si l'utilisateur est connecté
*\return boolean
* Information supplémentaire
* Retourne 'true' si l'array global $_session contient la chaine de caractère 'ID'
*/
function isConnected(){
	return isset($_SESSION['ID']);
}


/**
*\author Thomas BERARD
*\checker Théo
*\brief Génération du haut de la page HTML
*\return string
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
	<meta name="author" content="Thomas BERARD, Nicolas BOUYSSOUNOUSE, Adrien CECCALDI, Nathan DESCOMBES, Alexandre DEMONTOUX, Charles DOUANGDARA, Jérôme FABBIAN, Florian GOJON, Théo GUIBOUD-RIBAUD, Hugues LEVASSEUR, Guillaume SAYEN, Valentin SOVIGNET, Romain VINCENT">
	<link rel="stylesheet" type="text/css" href="style/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style/grepsi.css">
	</head>
	<body>
	<div class="wrapper">
	';
}


/**
*\author Thomas BERARD
*\checker Théo
*\brief Génération du bas de la page HTML
*\return string
*/
function basPage () {
	return '</body>
	</html>';
}

/**
*\author Thomas BERARD
*\checker Théo
*\brief Affiche la barre de navigation en tête de page.
*\return string
*/
function afficheMenu () {
	$html = '<nav id="cssmenu">
		<ul>
			<li><a href="accueil.php">Accueil</a></li>
			<li><a href="agenda.php">Agenda</a></li>
			<li><a href="partage.php">Partage</a></li>
			<li><a href="wiki.php">Wiki</a></li>
			<li><a href="trombinoscope.php">Trombinoscope</a></li>
			<li><a href="forum.php">Forum</a></li>';

	// Affiche le outon de connexion si non connecté,
	// le prénom utilisateur et le bouton de déconnexion si connecté
	$html .= (!isConnected()) ?
		'<li><a href="form_connexion.php">Se connecter</a></li>' :
		'<li><span>'.$_SESSION["prenom"].'</span><form id="connect" class="" action="deconnexion.php" method="post"> <input type="submit" value="Se deconnecter"/> </form></li>';

	$html .= '</ul>
	</nav>';

	return $html;
}


/**
*\author Thomas BERARD
*\checker Jérôme FABBIAN
*\brief Affiche le footer en bas de page
*\return string
*/
function afficheFooter () {
	return '</div>
	<footer class="footer-distributed">
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

?>