<?php

try {
$bdd = new PDO('mysql:host=localhost;dbname=u124588211_simde;charset=utf8', 'u124588211_simon', '1234Simon');
$bdd->exec("set names utf8");
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>