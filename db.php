<?php

/*
$server = 'sql305.infinityfree.com';
$db_name = 'if0_35435943_gis';
$username = 'if0_35435943';
$password = 'YETZXocfNE';
$port = '3306';
*/

//$server = 'localhost';
//$db_name = 'gis';
//$username = 'root';
//$password = '';
//$port = '3390';

$host = 'localhost';
$username = 'grou_racane123'; 
$password = '045ExxP-3O3p4@xu'; 
$database = 'grou_localgovernment';

// Create connection
$dbconn = new mysqli($host, $username, $password, $database);

// Check connection
if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
}

?>


