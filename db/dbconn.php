<?php
// Connection parameters
$host = 'localhost';
$username = 'root'; 
$password = ''; 
$database = 'localgovernment';
$port = '3390';


$conn = mysqli_connect($host, $username, $password, $database,$port);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
