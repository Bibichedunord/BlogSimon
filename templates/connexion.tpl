<div class="span8">

        {if isset($statut_connexion) AND $statut_connexion == FALSE}
            

        <div class="alert alert-error" role="alert">
            <strong>Echec!</strong> Votre mail ou votre mot de passe est incorrect
        </div>
            
            {/if}
        
    


    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_connexion" name="form-connexion" >
        <div class="clearfix">
            <label for="email">Email</label>
            <div class="input"><input type="text" name="email" id="email" value=""></div>
        </div>


        <div class="clearfix">
            <label for="mdp">Mot de passe</label>
            <div class="input"><input type="password" name="mdp" id="mdp" value=""></div>
        </div> 

        <div class="form-actions">        
            <input type="submit" name="connexion" value="connexion" class="btn-large btn-primary">
        </div>
    </form>
</div>

