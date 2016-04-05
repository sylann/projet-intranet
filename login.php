<?php
function
session_start(); //On initialise une session
$erreur=''; //Création de la variable pour gérer les erreurs
if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$erreur = "Nom d'utilisateur ou mot de passe incorrect"
	}
else
{
// On définit le nom d'utilisateur et le mot de passe
$username=$_POST['username'];
$password=$_POST['password'];
// On se connecte au serveur avec les identifiants
$connection = mysql_connect("localhost", "root", "");
// Pour protéger des injections SQL (merci google)
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
// Connection à la base de donnée
$db = mysql_select_db("grepsi", $connection);
// Requête SQL qui permet de vérifier que le couple mot de passe et nom d'utilisateur est valide
$query = mysql_query("select * from login where password='$password' AND username='$username'", $connection);
$rows = mysql_num_rows($query);
if ($rows == 1) {
	$_SESSION['login_user']=$username; //On initialise la session
header("location: index.html"); // On renvoie vers la page d'accueil
} else {
$erreur = "Nom d'utilisateur ou mot de passe invalide";
}
mysql_close($connection); // On ferme le pointeur de connexion
}
}
?>