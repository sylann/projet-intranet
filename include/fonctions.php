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

?>
