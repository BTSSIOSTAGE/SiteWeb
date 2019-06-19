<?php
function connect()
{
    error_reporting(0);

    $config = include('./inc/pgsql/dbconfig.php');

    $server = $config['server'];
    $username = $config['username'];
    $password = $config['password'];
    $database = $config['database'];
    $port = $config['port'];

    try{
        $dbconn = pg_connect("host=$server dbname=$database user=$username
        password=$password port=$port") or die('connection error');    
    } catch (Exception $ex) {

    }
    return $dbconn;
}

