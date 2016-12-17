<?php
/* Créer un fichier connexion.inc.php
 * Tester la présence du cookie sid et s'assurer qu'il n'es pas vide
 *  Si condition ok:
 *  Requete dans la table utilisateurs pour vérifier la correspondance du sid
 * Rowcount>0 alors créer une variable $connecte = TRUE 
 *   Si RowCount ==0:
 *  $connecte = FALSE
 */

require_once 'settings/bdd.inc.php'; //bien regarde le nom du chemin vers le fichier
require_once 'settings/init.inc.php';


if (isset($_COOKIE['sid']) && !empty($_COOKIE['sid']))
{
    $sth = $bdd->prepare("SELECT sid FROM utilisateurs WHERE sid = :sid"); 
    $sth->bindValue(':sid', $_COOKIE['sid'], PDO::PARAM_INT); //Sécurise la requete
    $sth->execute();
    $count = $sth->rowCount();

if ($count>0) {
    $_COOKIE['connecte'] = TRUE;
}
else {
    $_COOKIE['connecte'] = FALSE;
}
}
//VERIFICATION de connexion utilisateur

// Verification de la présence du cookie et sa conformité

?>
