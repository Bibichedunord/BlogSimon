<?php

require_once 'settings/bdd.inc.php';



//Résultat : Page courante, Index de départ, index d'arrivée
//Déclarer une variable du nombre d'articles par page
//Récupérer la variable de la page courante
//$page = $_GET['p'];
//Calculer l'index de départ de la requete
//Calculer le nombre de messages publiés dans la table
//ceil($articlestotal / $nbarticle) //retourne l'entier supérieur
//-----------------------------------------------Calculer l'index de départ de la requete----------------------------------------------

$nbarticle = 2;
$page = isset($_GET['p']) ? $_GET['p'] : 1;
//$article = ($page - 1) * ($nbarticle); //index de départ

function Indexstart($nbarticle, $page) {    
    $page = isset($_GET['p']) ? $_GET['p'] : 1;
    $article = ($page - 1) * ($nbarticle); //index de départ
    return $article;
}
$sql = "UPDATE articles SET titre ='$titre', texte ='$texte', publie='$publie' WHERE id='$id'";


$sth = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");
$sth->execute();
$count = $sth->rowCount();

$sid = md5($email . time());

setcookie('sid', $sid, time() +30);



$Indexdepart = Indexstart(2, 1);
echo "<br/><h2><b>Page: $page index de départ $Indexdepart </h2></b>";

//-----------------------------------------------Calculer le nombre de messages publiés dans la table----------------------------------

$articlestotal = $bdd->prepare("SELECT COUNT(*) as nb_Articles FROM articles WHERE publie = :publie");
$articlestotal->bindValue(':publie', 1, PDO::PARAM_INT); //Sécurise la requete
$articlestotal->execute(); //cette requette donne dans un tableau et sous tableau le nombre totale d'article

$tab_articles = $articlestotal->fetchAll(PDO::FETCH_ASSOC); //Créer le tableau
//print_r($tab_articles); // récupére dans un tableau les donnée de la bdd

$nbArticleInBdd = $tab_articles[0]['nb_Articles']; //on recherche dans le sous tableau appelé nb_Article la valeur du nombre 
//d'article total

$nbpage = ceil($nbArticleInBdd / $nbarticle); // on divise le nombre d'article de la bdd par la variable qui indique le nombre d'article
//par page

echo "<br/><h2><b>Nombre d'article en bdd $nbArticleInBdd Nombre de pages à créer $nbpage</h2></b>";
?>