<?php

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

/**
*\author Thomas BERARD
*\checker Romain
*\brief Renvoie ce qui est après $this dans $inthat, si et seulement $this est bien présent dans $inthat
*\param string $this, string $inthat
*\return string */
function keepAfter ($this, $inthat) {
	$html = "";
	if (!is_bool(strpos($inthat, $this))){
  	$html = substr($inthat, strpos($inthat,$this)+strlen($this));
	}
	return $html;
}

/**
*\author Thomas BERARD
*\checker Théo
*\brief Renvoie l'arborescence absolu si true en entré sinon renvoie l'arborescence relative par rapport à l'endroit ou on éxecute la fonction.
*\param $absolu=true ou $absolu=false
*\return Arborescence(absolue ou relative) */
function getArborescence($absolu=true) { //NE PAS OUBLIER D'AJOUTER LA CONSTANTE SUIVANTE DANS connexion.php : define('CHEMIN_SERVER', "/var/www/grepsi.fr/www/"); #on défini le chemin absolu du serveur web
  if($absolu) {
    return getcwd(); // On retourne l'arborescence complète avec cette fonction intégrée à PHP.
  }

  else {
    $arborescenceAbsolue = getcwd(); // On récupère l'arborescence complète avec cette fonction intégrée à PHP.
    $_SESSION['arborescence'] = keepAfter(CHEMIN_SERVER, $arborescenceAbsolue) . "/"; // On coupe la chaine pour ne garder que la partie relative en utilisant la fonction : keepAfter()
    return $_SESSION['arborescence']; // On retourne l'arborescence relative.
  }
}

/**
*\author Guillaume
*\checker Thomas BERARD
*\brief Permet de vérifier si le mail et le password existe dans la BDD.
*\param 2 chaines de caractères
*\return id de la personne traitée */
function checklogin($mail,$password) {
	global $p_base;
	$sth = $p_base->prepare('select id from personne where mail=:mail and password=:password');
	$sth->execute(array(':mail' =>$mail, ':password' =>sha1($password)));
	$resultat=$sth->fetch();
		if ($resultat==false){
			return false;
		}
		else{
			return $resultat['id'];
		}
}

/**
*\author Florian
*\checker ?
*\Brief : Affiche le bouton retour
*\param : aucun
*\return : une chaine html */

function afficheBoutonRetour(){
	return '<input type="submit" name="Retour" value="" </input>'
}

/**
*\author Valentin
*\checker Adrien
*\brief charge les informations de l'utilisateur connecté dans les variables de session
*\on appelle cette foncion depuis la fonction de connexion de l'utilisateur
*\param = idUtilisateur entier
*\return rien*/
function chargeUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base
	try{
		$p_requete = $p_base->prepare("SELECT * FROM personne WHERE id = :idUtilisateur");		//requête SQL nous donnant toutes les informations d'un utilisateur
		$p_requete->execute(array('idUtilisateur'=> $idUtilisateur));
		$donnees = $p_requete->fetch();

		$infos = ["id", "mail", "password", "nom", "prenom", "statut", "pseudo", "datenaiss", "tel",
		          "telpublic", "photo", "avatar", "cv", "cvpublic", "devise", "signature",
		          "acceptmails", "nbpost", "nblikes", "nbarticles", "nbcontribution"];

		foreach ($infos as $info) {
			$_SESSION[$info] = $donnee[$info]; //on met toutes les informations de la table dans les variables de session
		}

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}

/**
*\author Valentin
*\checker Adrien
*\brief Renvoie les informations de l'utilisateur (sa fiche)
*\param = idUtilisateur integer
*\return string*/
function afficheUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base

	try{
		$p_requete = $p_base->prepare("SELECT * FROM personne WHERE id = :idUtilisateur");		//requête SQL nous donnant toutes les informations d'un utilisateur
		$p_requete->execute(array('idUtilisateur'=> $idUtilisateur));
		$donnees = $p_requete->fetch();

		return '<div class="container-profil"><h3>'.$donnees['nom'].' '.$donnees['prenom'].'</h3><p>'.$donnees['pseudo'].'</p></div>';

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}

/**
*\author ?
*\checker ?
*\brief ?
*\return html string
*/
function afficheChat() {
	return '<form method="post>
		<input type="text" name="message" autofocus="autofocus" placeholder="Votre message">
		<input type="submit" name="submit" value="Poster" />
	</form>';
}

/**
*\author Théo
*\checker ?
*\brief Ajoute et affiche les messages de la base de données
*\return string*/
function afficheMessageChat() {
    global $p_base; //On récupère la variable $p_base
        try {
            if(!empty($_POST['message'])) { //La boucle s'execute si le contenu de message n'est pas vide
                $requete= $p_base->prepare('INSERT INTO tchat (contenu, date, idpersonne) VALUES (:contenu, :date, :idpersonne)'); //On prépare la requête d'insertion pour insérer le contenu du message dans la BDD
                $requete->execute(array(':contenu' => $_POST['message'], ':idpersonne'=> $_SESSION['id'], ':dateheure' => date('Y-m-d G:i:s'))); // on rentre les donnees dans un tableau
                $requete->closeCursor(); //On libère le curseur
                $p_requete = $bdd->query('SELECT pe.id, avatar, pseudo, contenu, date, idpersonne FROM personne pe, post po WHERE pe.id=po.idpersonne order by po.id desc limit 10'); //Requête qui selectionne les informations relatives au message
                    while ($donnees = $p_requete->fetch(PDO::FETCH_ASSOC)) {
                    $dateheure = $donnees['date'];
                    $dateheure = substr($dateheure, -8); // On selectionne uniquement les 8 derniers caractères de la chaine (l'heure)
                    $message = $donnees['avatar'].' '. $donnees['pseudo'].': '. $donnees['contenu']. '</br>'. $dateheure; //On affiche le message

                    }
            // On libère le pointeur
                $p_requete->closeCursor();
                }
            }
            catch (Exception $e)
                {
                die('Erreur : ' . $e->getMessage());
                }
    return $message;
}

/**
*\author Florian
*\checker Adrien
*\brief Génére un tableau avec les id des 25 derniers messages
*\return array
*/
function listeMessages() {
	global $p_base;
	try{
		$cpt = 0;
		$p_requete = $p_base->query("SELECT id, date from tchat order by date asc limit 25");
		while($resultat = $p_requete->fetch()) {
			$table[$cpt] = $resultat['id'];
			$cpt += 1;
		}

		return $table;

		$p_requete->closeCursor(); 		// Termine le traitement de la requête

	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die ('Erreur : '.$e->getMessage());
	}
}

/**
*\author Guillaume
*\checker Adrien
*\brief fonction qui génère le div « humeur du jour »
*\return string
* Information supplémentaire
* Formate une chaîne html qui affiche sélectionne une humeur au hasard dans la table et l'affiche
*/
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

?>
