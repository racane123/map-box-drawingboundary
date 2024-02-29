<?php
// Connection parameters

$host = 'localhost';
$username = 'grou_racane123'; 
$password = '045ExxP-3O3p4@xu'; 
$database = 'grou_localgovernment';
/*
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$database = 'gis';
$port = 3390;
*/



$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
