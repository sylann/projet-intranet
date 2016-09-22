<?php
// Author = Guillaume
// Checker = Romain
	define('DB_SERVER', "localhost"); #on défini le serveur
	define('DB_BASE', "grepsi"); #on défini le nom de la base
	define('DB_USER', "grepsi"); #on défini l'utilisateur
	define('DB_PASSWORD', "toto"); #on défini le mot de passe
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$p_base = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_BASE, DB_USER, DB_PASSWORD, $pdo_options); #on créé une connexion avec la base de données
	$p_base->exec("Set character set utf8"); #on convertit en utf8
?>
