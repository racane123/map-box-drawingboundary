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
$database = 'localgovernment';
$port = 3308;

*/
$conn = mysqli_connect($host, $username, $password, $database,$port);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
