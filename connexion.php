<?php
/*
 * Formulaire HTML : 2 champs et bouton
 * 
 * PHP
 * Vérifications champs postés
 * Comparer en base le couple login / MDP
 * 
 * Si Ok
 * Créer une variable aléatoire
 * Insérer cette variable en base
 * Créer le cookie 
 * Rediriger l'utilisateur vers l'accueil
 * 
 * Si non OK
 * Rediriger vers la page login
 * Afficher message erreur
 * 
 * Créer un fichier connexion.inc.php
 * Tester la présence du cookie sid et s'assurer qu'il n'es pas vide
 *  Si condition ok:
 *  Requete dans la table utilisateurs pour vérifier la correspondance du sid
 * Rowcount>0 alors créer une variable $connecte = TRUE 
 *   Si RowCount ==0:
 *  $connecte = FALSE
 */

session_start();

require_once 'settings/bdd.inc.php'; //bien regarde le nom du chemin vers le fichier
require_once 'settings/init.inc.php';
require_once('libs/Smarty.class.php');
include_once 'Include/connexion.inc.php';

if (isset($_POST['connexion'])) {

    $sth = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR); //Sécurise la requete
    $sth->execute();
	$tab_connexion = $sth->fetchAll(PDO::FETCH_ASSOC); //Créer le tableau
    $count = $sth->rowCount();
//echo "'$count'";
    if ($count == 1) {
        //echo "Authentification reussite";
//print_r($tab_connexion);
        $email = $tab_connexion[0]['email'];
        $sid = md5($email . time());
		setcookie('sid', $sid, time() + 3600);
		
//echo "'$sid'";
        $maj = $bdd->prepare("UPDATE utilisateurs SET sid = :sid WHERE id = :id");
        $maj->bindValue(':sid', $sid, PDO::PARAM_STR);
        $maj->bindValue(':id', $tab_connexion[0]['id'], PDO::PARAM_STR);
		$maj->execute();

        $_SESSION['statut_connexion'] = TRUE;
		
		header("Location: index.php");
		
		$_COOKIE['connecte'] = TRUE;
    
    }else{
        
        $_SESSION['statut_connexion'] = FALSE;
        
        $smarty = new Smarty();

        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
//$smarty->config_dir = '/web/www.example.com/smarty/livredor/configs/';
//$smarty->cache_dir = '/web/www.example.com/smarty/livredor/cache/';

        if (isset($_SESSION['statut_connexion'])) {
            $smarty->assign('statut_connexion', $_SESSION['statut_connexion']);
        }

        unset($_SESSION['statut_connexion']);


        $smarty->debugging = true;

        include_once 'Include/Header.inc.php';

        $smarty->display('connexion.tpl');

        include_once 'Include/menu.inc.php'; //c'est le menu
        include_once 'Include/footer.inc.php'; // c'est le pied de page
    }
   
 
  } else {

        $smarty = new Smarty();

        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
//$smarty->config_dir = '/web/www.example.com/smarty/livredor/configs/';
//$smarty->cache_dir = '/web/www.example.com/smarty/livredor/cache/';

        if (isset($_SESSION['statut_connexion'])) {
            $smarty->assign('statut_connexion', $_SESSION['statut_connexion']);
        }

        unset($_SESSION['statut_connexion']);


        $smarty->debugging = true;

        include_once 'Include/Header.inc.php';

        $smarty->display('connexion.tpl');

        include_once 'Include/menu.inc.php'; //c'est le menu
        include_once 'Include/footer.inc.php'; // c'est le pied de page
    }
?>