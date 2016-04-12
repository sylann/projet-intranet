<?php 
/**
* \author Théo GUIBOUD-RIBAUD
* \checker Romain VINCENT
* \brief Affiche la liste des groupes d'utilisateurs
* \return String
*/

function AfficheGroupe() {
	/* Retourne une chaine de caractère html
	* liste les groupes et contient des liens vers chaque page correspodante
	*/
	$html = "<p>\n";
	$html .= "<a href=\"trombinoscope.php?groupe=promo2019\">Promo 2019</a>\n";
	$html .= "<a href=\"trombinoscope.php?groupe=promo2018\">Promo 2018</a>\n";
	$html .= "<a href=\"trombinoscope.php?groupe=promo2017\">Promo 2017</a>\n";
	$html .= "<a href=\"trombinoscope.php?groupe=promo2016\">Promo 2016</a>\n";
	$html .= "<a href=\"trombinoscope.php?groupe=intervenant\">Intervenants</a>\n";
	$html .= "<a href=\"trombinoscope.php?groupe=administration\">Administration</a>\n";
	$html .= "</p>";
	return $html;
}
?>
