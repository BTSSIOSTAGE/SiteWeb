<?php

error_reporting(0);

require_once('./inc/fonction.php');

$lat = strip_tags($_POST['plat']);
$lng = strip_tags($_POST['plng']);
$name = strip_tags($_POST['pnom']);
$adr1 = strip_tags($_POST['paddr1']);
$adr2 = strip_tags($_POST['paddr2']);
$cpdeville = strip_tags($_POST['pcpdeville']);
$telephone = strip_tags($_POST['pnumtel']);
$email = strip_tags($_POST['pemail']);
$intituleadresse = strip_tags($_POST['pintitule']);




$dbconn->addOrganismes($lat, $lng, $name, $adr1, $adr2, $cpdeville , $telephone, $email , $intituleadresse);






?>

