<?php
/**
* \author Nicolas
* \check
*/
function isConnected(){
/** Cette fonction renvois 'true' si la varriable "$_SESSION['ID']" est attribuée a l'utilisateur*/
    return isset($_SESSION['ID']);
}
?>
