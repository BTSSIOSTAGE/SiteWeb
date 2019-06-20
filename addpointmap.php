<?php

error_reporting(0);

include('./inc/pgsql/dbconnect.php');
$dbconn = connect();

//$query = "SELECT name, lat, lon FROM cities";

$query = "SELECT organisme.libelle_o , adresse.rue1 , adresse.rue2 , adresse.lat , adresse.lng, formation_organisme.libelle_f , formation_organisme.capacite, formation_organisme.niv_requis,formation_organisme.type FROM adresse , organisme , formation_organisme WHERE organisme.organisme_id = adresse.organisme_id AND organisme.organisme_id = formation_organisme.organisme_id";

$result = pg_query($dbconn, $query) or die('query error');

$city = array();

$citiesArray = array();

while ($row = pg_fetch_row($result)) {
    $city["libelle_o"] = $row[0];
    $city["rue1"] = $row[1];    
    $city["rue2"] = $row[2];
    $city["lat"] = $row[3];
    $city["lng"] = $row[4];
    $city["libelle_f"] = $row[5];
    $city["capacite"] = $row[6];
    $city["niv_requis"] = $row[7];
    $city["type"] = $row[8];
    array_push($citiesArray, $city);
}

echo json_encode($citiesArray, JSON_UNESCAPED_UNICODE);


pg_close($dbconn);
?>

