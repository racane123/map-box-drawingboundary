<?php
// Connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'localgovunit';

// Establish a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$name = $_POST['name'];
$featureType = $_POST['featureType'];
$coordinates = json_decode($_POST['coordinates']);

echo $coordinates;

if (isset($_POST['coordinates'])) {
  $coordinates = $_POST['coordinates'];
  // Insert data into the database
  $sql = "INSERT INTO drawn_features (name, feature_type, coordinates) VALUES ('$name', '$featureType', ST_GeomFromGeoJSON('$coordinates'))";

  if ($conn->query($sql) === TRUE) {
      echo "Data saved successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "Error: Coordinates not set.";
}

// Close the database connection
$conn->close();

?>
