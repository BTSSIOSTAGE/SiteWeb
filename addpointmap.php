<?php

error_reporting(0);

include('./inc/pgsql/dbconnect.php');
$dbconn = connect();

$query = "SELECT name, lat, lon FROM cities";

$result = pg_query($dbconn, $query) or die('query error');

$city = array();

$citiesArray = array();

while ($row = pg_fetch_row($result)) {
    $city["name"] = $row[0];
    $city["lat"] = $row[1];
    
    $city["lon"] = $row[2];
    array_push($citiesArray, $city);
}

echo json_encode($citiesArray, JSON_UNESCAPED_UNICODE);


pg_close($dbconn);
?>

