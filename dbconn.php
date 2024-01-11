<?php
// Connection parameters
$host = 'localhost';
$username = 'postgres';
$password = 'root';
$database = 'localgovernment';
$port = 5432;

// Establish a connection to the database
$conn = pg_connect("host=$host port=$port dbname=$database user=$username password=$password");

// Check the connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
