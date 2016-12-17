<?php
/* Smarty version 3.1.30, created on 2016-12-14 14:12:46
  from "C:\Program Files (x86)\EasyPHP-DevServer-14.1VC11\data\localweb\my portable files\blog\templates\connexion.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5851454e2f1207_92315323',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89f0c2e7ff61488942e082bf99d85213c3945dfa' => 
    array (
      0 => 'C:\\Program Files (x86)\\EasyPHP-DevServer-14.1VC11\\data\\localweb\\my portable files\\blog\\templates\\connexion.tpl',
      1 => 1480688611,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5851454e2f1207_92315323 (Smarty_Internal_Template $_smarty_tpl) {
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
