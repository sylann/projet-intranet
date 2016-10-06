<?php


require_once('include/connexion.php');
require_once('include/fonctions.php');

echo hautPage(); // head html meta, scrits, styles ...
echo afficheMenu(); // fonction ui affiche la barre de navigation

 ?>
<section>
	<div class="site-wrapper">
		<form action="assets/member.php" method="post" class="form-signin">
			<h2 class="form-signin-heading" style="color: #1192FF;">Connexion</h2>
			<input style="margin-top:10px;" type="text" class="form-control" name="username" placeholder="Login" required="" autofocus="" />
			<input style="margin-top:10px;" type="password" class="form-control" name="password" placeholder="Password" required=""/>
			<button style="margin-top:10px;" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		</form>
	</div>
</section>
<?php

echo afficheFooter();					  // Appelle la fonction Footer
echo BasPage();
?>
