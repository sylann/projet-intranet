<?php

function isConnected(){
  // Author Nicolas
  // Checker Romain
  // Renvois 'true' si l'array global $_session contient la chaine de caractère 'ID'
  return isset($_SESSION['ID']);
}

?>
