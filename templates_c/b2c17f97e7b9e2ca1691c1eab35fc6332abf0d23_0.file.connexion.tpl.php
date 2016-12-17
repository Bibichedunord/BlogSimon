<?php
/* Smarty version 3.1.30, created on 2016-11-28 15:16:47
  from "/home/u124588211/public_html/templates/connexion.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_583c4a5f2fcdb1_73132288',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b2c17f97e7b9e2ca1691c1eab35fc6332abf0d23' => 
    array (
      0 => '/home/u124588211/public_html/templates/connexion.tpl',
      1 => 1480338168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_583c4a5f2fcdb1_73132288 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="span8">

        <?php if (isset($_smarty_tpl->tpl_vars['statut_connexion']->value) && $_smarty_tpl->tpl_vars['statut_connexion']->value == FALSE) {?>
            

        <div class="alert alert-error" role="alert">
            <strong>Echec!</strong> Votre mail ou votre mot de passe est incorrect
        </div>
            
            <?php }?>
        
    


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

<?php }
}
