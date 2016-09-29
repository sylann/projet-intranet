<?php

// Faire une copie de ce fichier et le nommer connexion.php_check_syntax
// Ajouter le nom de la bdd correspondant à votre phpmyadmin localhost
// votre username et votre mot de passe.
// Fin

	define('DB_SERVER', "localhost"); #on défini le serveur
	define('DB_BASE', "le_nom_de_votre_bdd"); #on défini le nom de la base
	define('DB_USER', "le_nom_de_votre_utilisateur"); #on défini l'utilisateur
	define('DB_PASSWORD', "votre_mot_de_passe"); #on défini le mot de passe

	define('CHEMIN_SERVER', "/var/www/grepsi.fr/www/"); #on défini le chemin absolu du serveur web

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$p_base = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_BASE, DB_USER, DB_PASSWORD, $pdo_options); #on créé une connexion avec la base de données
	$p_base->exec("Set character set utf8"); #on convertit en utf8
?>
