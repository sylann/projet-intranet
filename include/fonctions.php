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
*\author Nicolas BOUYSSOUNOUSE
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
*\checker Théo GUIBOUD-RIBAUD
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
	<meta name="author" content="Thomas BERARD, Nicolas BOUYSSOUNOUSE, Adrien CECCALDI, Nathan DESCOMBES, Jérôme FABBIAN, Florian GOJON, Théo GUIBOUD-RIBAUD, Guillaume SAYEN, Valentin SOVIGNET, Romain VINCENT">
	<link rel="stylesheet" type="text/css" href="style/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style/grepsi.css">
	</head>
	<body>
	';
}


/**
*\author Thomas BERARD
*\checker Théo GUIBOUD-RIBAUD
*\brief Génération du bas de la page HTML
*\return string
*/
function basPage () {
	return '</body>
	</html>';
}


/**
*\author Thomas BERARD.
*\checker Théo GUIBOUD-RIBAUD.
*\brief Affiche la barre de navigation en tête de page.
*\return string
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
*\author Thomas BERARD
*\checker Jérôme FABBIAN
*\brief Affiche le footer en bas de page
*\return string
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
*\author Florian GOJON
*\checker Nathan
*\brief Génére un tableau avec les id des 25 derniers messages
*\return array
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


/**
*\author Guillaume
*\checker
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


/**
*\brief Retourner un tableau chargé des infos de l'utilisateur
*\author = Valentin
*\checker = ?
*\param = idUtilisateur entier
*\return un tableau*/
function getUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base
	try{
		$p_requete = $p_base->prepare("SELECT * FROM personne WHERE id = :idUtilisateur");		//requête SQL nous donnant toutes les informations d'un utilisateur
		$p_requete->execute(array('idUtilisateur'=> $idUtilisateur));
		$donnees = $p_requete->fetch();

		$tableauUtilisateur["id"] = $donnees['id'];
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


/**
*\brief mettre les informations de l'utilisateur dans les $_SESSION
*\author = Valentin
*\checker = ?
*\param = tableauUtilisateur tableau
*\return rien*/
function chargeUtilisateur($tableauUtilisateur){
	
	foreach($tableauUtilisateur as $key => $value){		//pour chaque valeur dans le tableau
		$_SESSION[$key] = $value;						//on assigne une valeur à cette variable de session
	}
}


/**
*\brief Renvoie les informations de l'utilisateur (sa fiche)
*\author = Valentin
*\checker = ?
*\param = rien
*\return string*/
function afficheUtilisateur($tableauUtilisateur){
	$chaine = "";
	foreach($tableauUtilisateur as $key => $value){				//pour chaque valeur dans le tableau
		$chaine .= '<p>-- ' . $key . ' : ' . $value . '</p>';	//on fait des paragraphes avec ce qu'est la variable et sa valeur
	};
	return'<div>' . $chaine . '</div>';						//on return la chaine
}


/**
*\brief Renvoie les informations de l'utilisateur sous la forme d'une mini fiche
*\author = Valentin
*\checker = ?
*\param = idpersonne integer
*\return string*/
function afficheMiniUtilisateur($tableauUtilisateur){
	return'<a href="personne.php?id=' . $tableauUtilisateur['id'] . '"><img src="' . $tableauUtilisateur['photo'] . '" title="Nom : ' . $tableauUtilisateur['nom'] . '   Prenom : ' . $tableauUtilisateur['prenom'] .'"></a>';
}


/**
*\brief Renvoie une chaine html permettant d'afficher le trombinoscope d'un groupe d'utilisateurs
*\author = Valentin
*\checker = ?
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
		}

		$p_requete2->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
	$chaineTrombi .= "</div>";
	return $chaineTrombi;
}


/**
*\author Adrien
*\checker
*\brief Fonction affichage d'un post avec partie user, mise en page & toolbar
*\param \a $idPost/
*\return string
* Autres informations :
* Requète SQL avec recherche de la date & du contenu du post, de la signature, de l'avatar, du pseudo, du nom & du prenom du user
* 'table' Affichage forum sous forme tableau, largeur 100%, class "posttable"
* 'td user' Affichage du bloc user avec pseudo, devise & avatar, affichage centré, largeur 150px
* 'td post'  Affichage du bloc post avec une toolbar en partie supérieure, le contenu du post & la signature du user, qui prends le reste de la place en largeur (100%-150px)
* 'toolbar' Affichage d'une toolbar avec la date & (fonctions à venir)
* 'idPost' Affichage du post et de la signature du user
*/
function affichePost ($idPost) {
	try {
		$p_requete = $p_base->query('Select date, contenu, idpersonne, signature, post.id, avatar, pseudo from post, personne, devise where post.id = '.$idPost' and idpersonne = personne.id');
		$donnees = $requete->fetchall());
	}
	catch(Exception $e){
	die ('Erreur : '.$e->getMessage());
	}
	return	'<table class="posttable" cellpadding="4" cellspacing="0" width="100%">
				<tbody>
					<td class="user" rowspan="1" valign="top" width="150">
						<center>
							<div>'.$donnees['pseudo'].'
							</br>
							<div>'.$donnees['devise'].'
 							<img src="'.$donnees['avatar'].'" title="'.$donnees['nom'].','. $donnees['prenom'].'">
 						</center>
					</td>
					<td class="post" valign="top">
						<div class="toolbar">
							Date du message : '.$donnees['date']'
						</div>
						<div class="'.$idPost.'">
							<p>'.$donnees['contenu'].'</p>
							</br>
						</div>
						<div class="signature">
							--------------------
							</br>'
							.$donnees['signature'].'
						</div>
					</td>
				</tbody>
			</table>';
}


/**
*\author Adrien
*\checker Romain
*\brief Fonction récupération des derniers blogs à afficher sur la page d'accueil du site, genère un tableau avec les id des 5 derniers blogs
*\return array
* Information supplémentaire
* Nombre de blog à ramener actuellement = 5
* Requète SQL avec recherche de l'id & de la date du post, l'id du topic, en vérifiant qu'il s'agit d'un blog, classement descendant par date, avec une limite de 5 blogs pour l'affichage principal
* Rangement des résultats dans le tableau 'tableLastBlog'
*/
function getLastBlog() {
	global $p_base;
	try {
		$requete = $p_base->query('select post.id as id, post.date, blog, topic.id, idtopic from post, topic where idtopic = topic.id and blog is TRUE order by post.date desc limit 5');
		$tableLastBlog = array();
		while($resultat = $requete->fetch()) {
			$tableLastBlog[] = $resultat['id'];
		}
	}
	catch(Exception $e){
		die ('Erreur : '.$e->getMessage());
	}
	return $tableLastBlog;
}


/**
*\author Adrien
*\checker Romain
*\brief Fonction récupération de tous les blogs à afficher sur la page d'archive des blogs, genère un tableau avec les id de tous les blogs
*\return array
* Information supplémentaire
* Requète SQL avec recherche de l'id & de la date du post, l'id du topic, en vérifiant qu'il s'agit d'un blog, classement descendant par date pour l'affichage des archives
* Rangement des résultats dans le tableau 'tableBlog'
*/
function getBlog() {
	global $p_base;
	try {
		$requete = $p_base->query('select post.id as id, post.date, blog, topic.id, idtopic from post, topic where idtopic = topic.id and blog is TRUE order by post.date desc');
		$tableBlog = array();
		while($resultat = $requete->fetch()) {
			$tableBlog[] = $resultat['id'];
		}
	}
	catch(Exception $e){
	die ('Erreur : '.$e->getMessage());
	}
	return $tableBlog;
}


/**
*\author Nicolas BOUYSSOUNOUSE
*\checker
*\brief renvoie le nombre maximum de MOTD dans la base de donnée
*\return int
* Information supplémentaire
* Requète SQL avec recherche du nombre de ligne de la table quotidien
*/
function countMOTD(){
    global $p_base;
    // Ce bloc renvoie le nombre maximum de MOTD dans la base de donnée
    try{
        $nbMOTD = $p_base->query('select count(*) from quotidien');
        $resultat = $nbMOTD->fetch();
        $nbMOTD=$resultat[0];
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    return $nbMOTD;
}


/**
*\author Nicolas BOUYSSOUNOUSE
*\checker
*\brief renvoie le code HTML qui affiche le MOTD
*\param \a $alea/
*\return string
* Information supplémentaire
* Requète SQL qui va sélectionner la maxime et son auteur dans la table "quotidien"
* STRUCTURE HTML
*   <div>
*       <h4> blablabla </h4>
*       <cite> by blablabla </cite>
*   </div>
*/
function faitJour($alea){
    global $p_base;
    $MOTD="<div>";

    // Ce bloque concerne la requète SQL d'une citation aléatoire en fonction de "$nbMOTD"
    try{
        $MaximEtAuteur = $p_base->query('
        SELECT maxime, auteur
        FROM quotidien
        LIMIT '.$alea.',1 ;');
        $resultat = $MaximEtAuteur->fetch();
        $Maxime = '<h4>'.$resultat[0].'</h4>';
        $Auteur = '<cite>'.$resultat[1].'</cite>';
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    $MOTD.=$Maxime.$Auteur;
    $MOTD.="</div>";

    return $MOTD;

}


/**
*\author Nicolas BOUYSSOUNOUSE
*\checker
*\brief renvoie le code HTML qui affiche le MOTD
*\return string
* Information supplémentaire
* La fonction récupère le jour de la semaine, est le défini comme seed des prochains rand().
* $alea va contenir un chiffre définis aléatoirement entre 0 et 'countMOTD()-1'.
*/
function afficheFaitJour(){
    $day = getdate()['wday'];
    srand($day);
    $alea = rand(0, countMOTD()-1);
    return faitJour($alea);
}

/**
*\author Adrien
*\checker 
*\brief Fonction retourne l'id du dernier article
*\return id article
* Informations supplémentaires
* Nombre d'article à ramener actuellement = 1
* Return l'Id d'un article, cet article est choisi par requête SQL, cette dernière est un select dans les articles où la date de création de l'article est la plus récente (order by date desc	et on prend le premier).
* Rangement des résultats dans le tableau 'tableDernierArticle'
*/
function getDernierArticle() {
	global $p_base;
	try {
		$requete = $p_base->query(' select id, datecrea from wiki order by datecrea DESC limit 1 ');
		$tableDernierArticle = array();
		while($resultat = $requete->fetch()) {
			$tableDernierArticle[] = $resultat['id'];
		}
	}
	catch(Exception $e){
		die ('Erreur : '.$e->getMessage());
	}
	return $tableDernierArticle;
}