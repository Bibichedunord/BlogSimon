<?php
session_start();
require_once 'settings/bdd.inc.php'; //bien regarde le nom du chemin vers le fichier
require_once 'settings/init.inc.php';

//-------------------------------------------------Partie PHP----------------------------------------------------------------------------
//                    ----------------------------Selection article----------------------
if (isset($_GET['id'])) {


    $idarticles = $bdd->prepare("SELECT * FROM articles WHERE id = :id");
    $idarticles->bindValue(':id', $_GET['id'], PDO::PARAM_INT); //Sécurise la requete
    $idarticles->execute(); //cette requette donne dans un tableau et sous tableau le nombre totale d'article

    $tabid_articles = $idarticles->fetchAll(PDO::FETCH_ASSOC); //Créer le tableau

    $titrearticle = $tabid_articles[0]['titre'];
    $textearticle = $tabid_articles[0]['texte'];
    $publiearticle = $tabid_articles[0]['publie'];
    $iddelarticle = $tabid_articles[0]['id'];
//print_r($tabid_articles); // récupére dans un tableau les donnée de la bdd
}
//                    ---------------------------Ajout article--------------------------------
if (isset($_POST['ajouter'])) {
    //print_r($_FILES);
//exit();
    $date_ajout = date("Y-m-d"); //Format date

    $_POST['date_ajout'] = $date_ajout;

//Condition simple
    /*
      if(isset($_POST['publie'])){ //isset teste l'existence d'une valeur
      $_POST['publie'] = 1;
      } else {
      $_POST['publie'] = 0;
      }
     */

//Condition ternaire
    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;

    //  print_r($_POST);
//Condition simple

    /* if ($_FILES['image']['error'] == 0) {
      echo "Image ok";
      } else {
      echo "pas OK";
      } */
    
    
    $sth = $bdd->prepare("INSERT INTO articles (titre, texte, date, publie) VALUES (:titre, :texte, :date, :publie)"); //requete préparer
    $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':date', $_POST['date_ajout'], PDO::PARAM_INT); //Sécurise la requete
    $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT); //Sécurise la requete    
    $sth->execute();
    $dernier_id = $bdd->lastInsertId(); //Retourne l'identifiant qui vien d'être insérer
    //echo '<br/> <b><u>'.$dernier_id.'</u></b>';
    move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$dernier_id.jpg");

    header("Location: articles.php");

    $_SESSION['ajout_article'] = TRUE;
} 

//------------------------------------------------Modification---------------------------------------------------

elseif(isset($_POST['modifier'])) 
{
    
    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;
    $sth = $bdd->prepare("UPDATE articles SET titre = :titre1article, texte = :texte1article, publie = :publie1article WHERE id = :id1delarticle"); //requete préparer
    
    $sth->bindValue(':titre1article', $_POST['titre'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':texte1article', $_POST['texte'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':publie1article', $_POST['publie'], PDO::PARAM_INT); //Sécurise la requete 
    $sth->bindValue(':id1delarticle', $_POST['id'], PDO::PARAM_INT); //Sécurise la requete 
    $sth->execute();
    header("Location: index.php");
}
else {
    
    
$publiearticle = isset($publiearticle) ? 1 : 0;

//----------------------------------------------------------Partie HTML---------------------------------------------------------------------    
    include_once 'Include/Header.inc.php';

    if (isset($_SESSION['ajout_article'])) {
        ?>

        <div class="alert alert-success" role="alert">
            <strong>Bravo!</strong> Ton article a été ajouté
        </div>
        <?php
        unset($_SESSION['ajout_article']);
    }
    ?>
    <div class="span8">

        <form action="articles.php" method="post" enctype="multipart/form-data" id="form_article" name="form-article" >
           <input type="hidden" name="id" value="<?php if (isset($tabid_articles)) {echo $iddelarticle;} ?>"
            <div class="clearfix">
                <label for="titre">Titre</label>
                <div class="input"><input type="text" name="titre" id="titre" value="<?php if (isset($titrearticle)) {
        echo $titrearticle;
    } ?> "></div>
            

            <div class="clearfix">
                <label for="text">Texte</label>
                <div class="input"><textarea name="texte" name="titre" id="texte"> <?php if (isset($textearticle)) {
        echo $textearticle;
    } ?> </textarea></div>
            </div>

            <div class="clearfix">
                <label for="image">Image</label>
                <div class="input"><input type="file" name="image" id="image"></div>
            </div>

            <div class="clearfix">
                <label for="publie">Publié</label>
                <div class="input"><input type="checkbox" name="publie" id="publie" <?php if ($publiearticle == 1) {
        echo "checked";
    } ?>></div>
            </div>
    <?php
    if (isset($_GET['id'])) {
        ?><div class="form-actions">        
                    <input type="submit" name="modifier" value="modifier" class="btn-large btn-primary">
                </div>
                
        <?php
    }else{
    ?>
            <div class="form-actions">        
                <input type="submit" name="ajouter" value="ajouter" class="btn-large btn-primary">
            </div>
            <?php
            } 
            ?>
        </form>
</div>
    

    <?php
    include_once 'Include/menu.inc.php'; //c'est le menu
    include_once 'Include/footer.inc.php'; // c'est le pied de page
}

?>
