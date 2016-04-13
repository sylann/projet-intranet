 <?php
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