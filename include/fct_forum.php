<?php
/**
* Fonctions nécessaires au fonctionnement du forum :
*
* Bon codage !
*/

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