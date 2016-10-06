<?php




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
?>
