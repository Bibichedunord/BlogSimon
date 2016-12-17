    <div class="span8">
        
{if isset($ajout_de_article) AND $ajout_de_article == FALSE}
        
        <div class="alert alert-success" role="alert">
            <strong>Bravo!</strong> Ton article a été ajouté
        </div>
        {/if}

        <form action="articles.php" method="post" enctype="multipart/form-data" id="form_article" name="form-article" >
           <input type="hidden" name="id" value="{if (isset($ajout_de_article)){$iddelarticle;}{/if}}?>"
            <div class="clearfix">
                <label for="titre">Titre</label>
                <div class="input"><input type="text" name="titre" id="titre" value="{if (isset($ajout_de_article[0]['titre']))}{$titrearticle}{/if}}">
                    </div>
            

            <div class="clearfix">
                <label for="text">Texte</label>
                <div class="input"><textarea name="texte" name="titre" id="texte">{if (isset($ajout_de_article[0]['texte']))}{$textearticle}{/if}}">
                </textarea></div>
            </div>

            <div class="clearfix">
                <label for="image">Image</label>
                <div class="input"><input type="file" name="image" id="image"></div>
            </div>

            <div class="clearfix">
                <label for="publie">Publié</label>
                <div class="input"><input type="checkbox" name="publie" id="publie"  {if ($publiearticle == 1) {
        echo "checked"};
        {/if}
     ></div>
            </div>
    
    {if (isset($_GET['id']))} 
        
        ?><div class="form-actions">        
                    <input type="submit" name="modifier" value="modifier" class="btn-large btn-primary">
                </div>
                
        
    } {else} {
{/if}    
            <div class="form-actions">        
                <input type="submit" name="ajouter" value="ajouter" class="btn-large btn-primary">
            </div>
            
            } 
            
        </form>
</div>