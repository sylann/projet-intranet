<?php

require_once('include/connexion.php');
require_once('include/fct_common.php');
require_once('include/fct_partage.php');
require_once('include/upload.php');

if (!isConnected()) {            // Regarde si l'utilisateur est connecté
 die('Page inaccessible');      // Si il ne l'est pas, ne charge pas la page
}

include("haut_page.html"); // head html meta, styles ...
echo afficheMenu(); // fonction qui affiche la barre de navigation

 ?>

 <!-- Ajouter votre contenu ici
  doit appeler la fonction correspondante

  pensez à tout ce qu'il faudrait ajouter et qui n'est peut-être pas encore prévu

  faites des commentaires dans trello !! :-)
 -->


<!-- ajouter le menu d'upload avec le code suivant :

  <form action="upload.php" class="dropzone" id="jacob" method="post" enctype="multipart/form-data">
    <div class="fallback">
      <input name="file" type="file" id="file" />
    </div>
  </form>
 -->
<?php

echo afficheFooter();
include("bas_page.html"); // scripts, balise fermantes
?>
