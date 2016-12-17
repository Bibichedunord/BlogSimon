<?php
// charge la bibliothèque Smarty
require_once('libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
//$smarty->config_dir = '/web/www.example.com/smarty/livredor/configs/';
//$smarty->cache_dir = '/web/www.example.com/smarty/livredor/cache/';

$name = "Simon";

$smarty->assign('name',$name); // assigne nos variables

//** un-comment the following line to show the debug console
$smarty->debugging = true;

$smarty->display('smarty-test.tpl');

?>