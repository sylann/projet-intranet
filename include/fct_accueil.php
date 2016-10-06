<?php


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

 ?>
