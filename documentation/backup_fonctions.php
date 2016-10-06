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

		$_SESSION["id"] = $donnees['id'];
		$_SESSION["mail"] = $donnees['mail'];					//on met toutes les informations de la table dans les variables de session
		$_SESSION["password"] = $donnees['password'];
		$_SESSION["nom"] = $donnees['nom'];
		$_SESSION["prenom"] = $donnees['prenom'];
		$_SESSION["statut"] = $donnees['statut'];
		$_SESSION["pseudo"] = $donnees['pseudo'];
		$_SESSION["datenaiss"] = $donnees['datenaiss'];
		$_SESSION["tel"] = $donnees['tel'];
		$_SESSION["telpublic"] = $donnees['telpublic'];
		$_SESSION["photo"] = $donnees['photo'];
		$_SESSION["avatar"] = $donnees['avatar'];
		$_SESSION["cv"] = $donnees['cv'];
		$_SESSION["cvpublic"] = $donnees['cvpublic'];
		$_SESSION["devise"] = $donnees['devise'];
		$_SESSION["signature"] = $donnees['signature'];
		$_SESSION["acceptmails"] = $donnees['acceptmails'];
		$_SESSION["nbpost"] = $donnees['nbpost'];
		$_SESSION["nblikes"] = $donnees['nblikes'];
		$_SESSION["nbarticles"] = $donnees['nbarticles'];
		$_SESSION["nbcontribution"] = $donnees['nbcontribution'];

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
*\author Valentin
*\checker Adrien
*\brief Renvoie les informations de l'utilisateur sous la forme d'une mini fiche
*\la fiche est cliquable pour accèder à la page complète de l'utilisateur
*\param = idUtilisateur integer
*\return string*/
function afficheMiniUtilisateur($idUtilisateur){
	global $p_base;			//pour avoir accès à la la variable $p_base

	try{
		$p_requete = $p_base->prepare("SELECT id, nom, prenom, photo FROM personne WHERE id = :idUtilisateur");		//requête SQL nous donnant toutes les informations d'un utilisateur
		$p_requete->execute(array('idUtilisateur'=> $idUtilisateur));
		$donnees = $p_requete->fetch();

		return'<a href="personne.php?id=' . $donnees['id'] . '">
			<img src="' . $donnees['photo'] . '" title="Nom : ' . $donnees['nom'] . '   Prenom : ' . $donnees['prenom'] .'">
		</a>';

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
*\brief Renvoie une chaine html permettant d'afficher le trombinoscope d'un groupe d'utilisateurs
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

			$p_requete2->closeCursor(); 		// Termine le traitement de la requête
		}

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
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
*\checker Thomas BERARD
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
    global $p_base;         //pour avoir accès à la la variable $p_base
    try {
        $p_requete = $p_base->query('Select date, contenu, idpersonne, nom, prenom, signature, post.id, avatar, pseudo, devise from post, personne where post.id = '.$idPost.' and idpersonne = personne.id');
        $donnees = $p_requete->fetch();
    }
    catch(Exception $e){
    die ('Erreur : '.$e->getMessage());
    }
    return  '<table class="posttable" cellpadding="4" cellspacing="0" width="100%">
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
                            Date du message : '.$donnees['date'].'
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
*\author Nicolas
*\checker Florian
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
*\author Nicolas
*\checker Florian
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
*\author Nicolas
*\checker Florian
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
*\author Nicolas
*\checker Florian
*\brief renvoie un aperçu de l'article de 300 char avec son code html
*\return str
*\param /a $id
* Information supplémentaire
* Requète SQL sur contenu & label de la table wiki
* code html :
* <a>
* <h4> titre </h4>
* <p> article blablabla </p>
* </a>
* La classe CSS utilisé est "miniArticle"
*/
function afficheMiniArticle($id){
    $html='<a href="http://example.com" class="miniArticle"><div>';
    global $p_base;
    try{
        $reponse = $p_base->query("SELECT CAST(contenu AS CHAR(300)), label
        FROM wiki
        where id = ".$id);
        $resultat = $reponse->fetch();
    }
    catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }

    $html.="<h4>".$resultat[1]."</h4>";
    $html.="<p>".$resultat[0]." [...]</p>";
    $html.="</div></a>";
    return $html;
}


/**
*\author Adrien
*\checker Jérôme
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


/**
*\author Valentin
*\checker Florian
*\brief Renvoie une chaine html qui permet d'afficher la liste des articles
*\param integer valant le début de la requête
*\return chaine html
*informations supplémentaire : utilise la fonction afficheMiniArticleWiki()*/
function afficheListeArticle($debut){
	global $p_base;			//pour avoir accès à la la variable $p_base
	$listeArticle = "<div><ul>";

	try{
		$p_requete = $p_base->query("SELECT id FROM wiki LIMIT ". $debut .",20");
		while($donnees = $p_requete->fetch()){
			$listeArticle .= "<li>". afficheMiniArticle($donnees['id']) ."</li>";
		}

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}

	$listeArticle .= "</ul></div>";
	return $listeArticle;
}


/**
*\author Valentin
*\checker Florian
*\brief return une chaine html qui permet d'afficher la liste des articles ainsi que les liens de navigation
*\param rien
*\return chaine html
*\informations supplémentaire :  utilise les fonctions afficheListeArticle() et navigation()*/
function setupNavigationListeArticle(){
	global $p_base;

	if (isset($_GET['page'])) {			//si 'page' vaut quelque chose (--> si on a page=quelque chose)
		if(!empty($_GET['page'])){
			$pageCourante = $_GET['page'];	//pageCourante prend la valeur de page="?"
		}
		else{
			$pageCourante = 1;
		}
	}
	else {
		$pageCourante = 1;				//sinon la variable prend la valeur 1 (page 1)
	}

	if($pageCourante < 1) {				//pour ne pas pouvoir écrire un numéro de page négatif dans l'url, on revient à la première page
		$pageCourante = 1;
	}

	$debut = 20 * ($pageCourante - 1);


    try{
        $reponse = $p_base->query("SELECT count(*) AS compteur FROM wiki");		//on compte le nombre d'articles dans le wiki
        $donnees = $reponse->fetch();
        $taille = $donnees['compteur'];
    }
    catch(Exception $e){
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }

	$dernierePage = ceil($taille / 20);

	if((($pageCourante - 1) * 20) > $taille){		//si on tape dans l'url un num de page supérieur à la dernière page
		header('Location: index.php');		//on redirige vers la première page de listeville.php
	}

	$retour = navigation($pageCourante, $dernierePage);	//les boutons page suivante et page précédente
	$retour .= afficheListeArticle($debut);		//la liste des articles
	$retour .= navigation($pageCourante, $dernierePage);	//les boutons page suivante et page précédente

	return $retour;
}


/**
*\author Valentin
*\checker Florian
*\brief Renvoie une chaine html qui permet d'afficher les liens de navigation
*\param 2 integer
*\return chaine html
*informations complémentaires : pour les param-->integer valant le $_GET['page'] et integer valant le numéro de la dernière page des articles wiki*/
function navigation($pageCourante, $dernierePage){
	if($dernierePage <= 1){			//si il n'y a qu'une page
		return '';						//on return rien
	}
	elseif($pageCourante <= 1){				//si on est en page 1 ou moins, on affiche un seul lien (suivant)
		return '<ul>
			<li><a href="'.basename($_SERVER['PHP_SELF']).'?page='.($pageCourante + 1).'">Page suivante</a></li>
		</ul>';
	}
	elseif($pageCourante == $dernierePage){		//si on est à la dernière page ou plus, on n'affiche pas le lien page suivante
		return '<ul>
					<li><a href="'.basename($_SERVER['PHP_SELF']).'?page='.($pageCourante - 1).'">Page précédente</a></li>
				</ul>';

	}
	else{								//si on n'est pas en page 1 ou plus mais moins que la dernière page, on affiche les 2 liens
		return '<ul>
			<li><a href="'.basename($_SERVER['PHP_SELF']).'?page='.($pageCourante - 1).'">Page précédente</a></li>
			<li><a href="'.basename($_SERVER['PHP_SELF']).'?page='.($pageCourante + 1).'">Page suivante</a></li>
		</ul>';
	}
}


/**
*\author Valentin
*\checker Adrien
*\brief Renvoie l'id de l'article le plus vu du wiki
*\param rien
*\return id*/
function getMostViewedArticle(){
	global $p_base;			//pour avoir accès à la la variable $p_base
	try{
		$p_requete = $p_base->query("SELECT id, visites FROM wiki ORDER BY 2 DESC LIMIT 0,1");
		$donnees = $p_requete->fetch();
		return $donnees['id'];
		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}


/**
*\author Valentin
*\checker Thomas BERARD
*\brief Renvoie une chaine html qui permet d'afficher l'article
*\param id de l'article
*\return chaine html*/
function afficheArticle($idArticle){
	global $p_base;			//pour avoir accès à la la variable $p_base
	try{
		$p_requete = $p_base->query("SELECT wiki.label AS label, wiki.contenu AS contenu, wiki.datecrea AS dateCreation, wiki.visites AS visites, personne.pseudo AS pseudo FROM wiki, personne WHERE wiki.id = " . $idArticle . " and wiki.idpersonne = personne.id");
		$donnees = $p_requete->fetch();

		return'<div><p>'. $donnees['label'] .'</p><p>'. $donnees['pseudo'] .'</p><p>'. $donnees['dateCreation'] .'</p><p>'. $donnees['contenu'] .'</p><p>'. $donnees['visites'] .' vues</p></div>';

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}


/**
*\author Romain
*\checker ?
*\brief Renvoie une chaine html qui permet d'afficher les groupes avec un lien vers leur trombinoscope
*\return chaine html
*/
function afficheGroupes(){
	global $p_base;			//pour avoir accès à la la variable $p_base
	$groupes = '<div class="container-all-groups">';

	try{
		$p_requete = $p_base->query("SELECT * FROM groupe");
		while($donnees = $p_requete->fetch()){
			$groupes .= '<a href="tombinoscope.php?groupe='.$donnees['id'].'"
			<div class="container-group" style="background:(url:"'.$donnees['logo'].'");">
				<h3>'.$donnees['label'].'</h3>
				<p>'.$donnees['devise'].'</p>
			</div></a>';
		}

		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}

	$groupes .= "</div>";
	return $groupes;
}


/**
*\author Théo
*\checker Adrien
*\brief Affiche un écran d'écriture d'articles
*\return string*/
function afficheEcritureArticle(){
	if(isset($_POST['submit'])) {
		ajouteArticle();
	}
	return '<form method="post">
			<input type="text" name="label" placeholder="Titre">
			<textarea name="contenu" autofocus="autofocus" class="zonetext"></textarea>
			<input type="submit" name="submit" value="Sauvegarder">
		</form>
		';
}


function afficheChat() {
	return '<form method="post>
		<input type="text" name="message" autofocus="autofocus" placeholder="Votre message">
		<input type="submit" name="submit" value="Poster" />
	</form>';
}


/**
*\author Valentin
*\checker Adrien
*\Brief : On récupère toutes les données entrées par l'utilisateur dans le formulaire de création de wiki, puis grâce à une requête SQL update, on rentre ces informations dans la bdd.
*\param : rien -- post : Données rentrées par l'utilisateur dans le formulaire de l'article (label et contenu)
*\return : Rien*/
function ajouteArticle(){
	global $p_base;			//pour avoir accès à la la variable $p_base
	try{
		$p_requete = $p_base->prepare("INSERT INTO wiki(label, contenu, datecrea, lastmod, idpersonne) VALUES (:label, :contenu, :date, :lastmod, :idpersonne)");		//requête SQL insérant l'article
		$p_requete->execute(array('label'=> $_POST['label'],
								  'contenu'=> $_POST['contenu'],
								  'date'=> date('d/m/Y'),
							  	  'lastmod'=> date('d/m/Y'),
							  	  'idpersonne'=> $_SESSION['id']));
		$p_requete->closeCursor(); 		// Termine le traitement de la requête
	}
	catch(Exception $e){
	// En cas d'erreur précédemment, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}


/**
*\author Thomas BERARD
*\checker Romain
*\brief Renvoie ce qui est après $this dans $inthat si et seulement this est bien présent dans $inthat
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
*\author Florian
*\checker Romain (pas encore fini)
*\Brief : Permet d'aller de -1 dans l'arborescence du gestionnaire de fichier
*\return : rien */
/*
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


}*/
function supprimer(getArborescence){
	string $chaine = getArborescence();
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

?>
