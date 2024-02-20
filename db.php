<?php

/*
$server = 'sql305.infinityfree.com';
$db_name = 'if0_35435943_gis';
$username = 'if0_35435943';
$password = 'YETZXocfNE';
$port = '3306';
*/

$server = 'localhost';
$db_name = 'gis';
$username = 'root';
$password = '';
$port = '3308';

// Create connection
$dbconn = new mysqli($server, $username, $password, $db_name, $port);

// Check connection
if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
}

?>


