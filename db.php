<?php

/*
$server = 'sql305.infinityfree.com';
$db_name = 'if0_35435943_gis';
$username = 'if0_35435943';
$password = 'YETZXocfNE';
$port = '3306';


$server = 'localhost';
$db_name = 'gis';
$username = 'root';
$password = '';
<<<<<<< HEAD
$port = '3390';
*/

$server = 'localhost';
$db_name = 'grou_gis';
$username = 'root';
$password = 'LrsLsl+MB4qdrz!e';

=======
$port = '3308';
>>>>>>> f6dabf5dc15d91aec44e79794763a4e7fc05f5ae

// Create connection
$dbconn = new mysqli($server, $username, $password, $db_name);

// Check connection
if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
}

?>


