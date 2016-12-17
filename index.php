<?php
require_once 'settings/bdd.inc.php'; //bien regarde le nom du chemin vers le fichier
require_once 'settings/init.inc.php';
include_once 'Include/connexion.inc.php';
include_once 'Include/Header.inc.php';
//--------------------------------------------------GESTION D ARTICLE PAR PAGE------------------------------------------------------------
session_start();

if (isset($_COOKIE['connecte'])) {

if (isset($_SESSION['statut_connexion'])){
     ?>

        <div class="alert alert-success" role="alert">
            <strong>Bravo!</strong> Authentification reussite
        </div>
        <?php
        unset($_SESSION['statut_connexion']);
    }



if (isset($_POST['Poster'])) {
	
$sth = $bdd->prepare("INSERT INTO commentaires (pseudo, mail, commentaire, id_article) VALUES (:pseudo, :mail, :commentaire, :id_article )"); //requete préparer
    $sth->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_INT); //Sécurise la requete
	$sth->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_INT); //Sécurise la requete
    $sth->execute();
	header("Location: index.php");
   
	
}

if (isset($_GET['Supprimer'])) {
	
$sth1 = $bdd->prepare("DELETE FROM articles  WHERE `id` = :id"); //requete préparer
$sth2 = $bdd->prepare("DELETE FROM commentaires  WHERE `id_article` = :id"); //requete préparer
    $sth1->bindValue(':id', $_GET['id'], PDO::PARAM_INT); //Sécurise la requete
    $sth2->bindValue(':id', $_GET['id'], PDO::PARAM_INT); //Sécurise la requete
    $sth1->execute();
	$sth2->execute();
	header("Location: index.php");
   
	
}        

$nbarticle = 2;
$page = isset($_GET['p']) ? $_GET['p'] : 1;

//$article = ($page - 1) * ($nbarticle); //index de départ

function Indexstart($nbarticle, $page) {
    $article = ($page - 1) * ($nbarticle); //index de départ
    return $article;
}

$Indexdepart = Indexstart($nbarticle, $page);
//echo "<br/><h2><b>Page: $page index de départ $Indexdepart </h2></b>";

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

//echo "<br/><h2><b>Nombre d'article en bdd $nbArticleInBdd Nombre de pages à créer $nbpage</h2></b>";

//------------------------------------------------Affichage des articles-----------------------------------------------------------------

$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') as date_fr FROM articles WHERE publie =:publie LIMIT $Indexdepart, $nbarticle "); //prépartion d'une requete
$sth->bindValue(':publie', 1, PDO::PARAM_INT); //Sécurise la requete
$sth->execute();

$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($tab_articles); // récupére dans un tableau les donnée de la bdd

?>

<div class="span8">



    <?php
    foreach ($tab_articles as $value) {
        ?>
    
       
    
        <h2><?php echo $value['titre'] ?></h2>
        <img src="img/<?php echo $value['id'] ?>.jpg" width="300px" alt="<?php echo $value['titre'] ?>"/>
        <p style="text-align: justify;"><?php echo $value['texte'] ?></p>
        <p><em><u>Publié le : <?php echo $value['date_fr'] ?></u></em></p>
		<div>
            <a href ="articles.php?id=<?= $value['id']?>"> Modifier</a>
        </div>
		
<!-- ------------------------------------------------------------------------------------------------------------Bouton supprimer-------------------------- ----------------------------------------------------------------------------------------------------->
		
		<div>
            <a href ="index.php?Supprimer=oui&id=<?= $value['id']?>"> Supprimer</a>
        </div>
		
<!-- ------------------------------------------------------------------------------------------------------------Fonction pour cacher et afficher le bouton ----------------------------------------------------------------------------------------------------->			
<script type="Text/JavaScript">

  function Afficher_cacher(_div){
      
    var obj = document.getElementById(_div);
    if(obj.style.display == "block")
        obj.style.display = "none";
    else
        obj.style.display = "block";
}

</script>

<!-- ------------------------------------------------------------------------------------------------------------Formulaire de commentaire--------------------------------------------------------------------------------------------------------------------->

<br><input type="button" value="Commenter ?" onclick="Afficher_cacher('form<?php echo $value['id'] ?>')" /></br>

<form style="display: none;" id="form<?php echo $value['id'] ?>" method="POST" action="index.php">

   <p>
   
   Votre pseudo :</label>
       <input type="text" required name="pseudo" id="pseudo" />
       
       <br />
    Votre mail :</label>
       <input type="text" required name="mail" id="mail" />
	   
	   <br />
      Commentaire :</label>
       <input type="text" required name="commentaire" id="commentaire" />    

   </p>
   
   <input type="hidden" name="id_article" value="<?php echo $value['id'] ?>" />
   
   <input type="submit" Name="Poster" value="Poster" />
</form>		

<!-- ------------------------------------------------------------------------------------------------------------Requete pour afficher les commentaires ----------------------------------------------------------------------------------------------------->
<?php

    $com = $bdd->prepare("SELECT * FROM commentaires WHERE id_article = :id_article"); //Préparation de la requête
    $com->bindValue(':id_article', $value['id'], PDO::PARAM_INT); //Enlève tout ce qui n'est pas numérique
    $com->execute();

    $tab_com = $com->fetchAll(PDO::FETCH_ASSOC);
    
foreach ($tab_com as $value) {

echo "Auteur :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp". $value['pseudo']."</br>";

echo "Commentaire :".$value['commentaire']."</br>";
    
    }
}
    
?>

    <div class="pagination">
        <ul>
            <li><a>Page : </a></li>
            <?php for ($i = 1; $i <= $nbpage; $i++) { ?> 
                <li <?php if ($page == $i) { ?> class="active"<?php } ?>><a href ="index.php?p=<?= $i ?>"><?= $i ?></a></li>
                    <?php
                }
                ?>
        </ul>
    </div>
</div>
<?php
  }
            else
            {
                header("Location: connexion.php");
            }
include_once 'Include/menu.inc.php'; //c'est le menu
include_once 'Include/footer.inc.php'; // c'est le pied de page
?>