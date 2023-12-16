<?php
// Connection parameters
$host = 'localhost';
$username = 'postgres';
$password = 'root';
$database = 'localgovernment';
$port = 5432;

// Establish a connection to the database
$conn = pg_connect("host=$host dbname=$database user=$username password=$password");

// Check the connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get data from the POST request
if (isset($_POST['name'], $_POST['featureType'], $_POST['coordinates'])) {
  $name = $_POST['name'];
  $featureType = $_POST['featureType'];
  $rawCoordinates = $_POST['coordinates'];

  // Remove surrounding double quotes from the received GeoJSON
  $rawCoordinates = trim($rawCoordinates, '"');

  // Decode coordinates as an array
  $coordinates = json_decode($rawCoordinates, true);

  // Ensure $coordinates is an array
  if (!is_array($coordinates)) {
      echo "Error: Invalid coordinates format.";
      exit;
  }

  // Determine the GeoJSON type based on the feature type
  $geojsonType = '';
  switch ($featureType) {
      case 'Point':
          $geojsonType = 'Point';
          break;
      case 'LineString':
          $geojsonType = 'LineString';
          break;
      case 'Polygon':
          $geojsonType = 'Polygon';
          break;
      default:
          echo "Error: Unknown feature type.";
          exit;
  }

  // Manually add the "type" property to the GeoJSON data
  $geojson = '{"type": "' . $geojsonType . '", "coordinates": ' . json_encode($coordinates) . '}';

  // Insert data into the database using a prepared statement
  $sql = "INSERT INTO drawn_features (name, feature_type, coordinates) VALUES ('$name', '$featureType', ST_SetSRID(ST_GeomFromGeoJSON('$geojson'), 4326))";

  // Execute the query
  $result = pg_query($conn, $sql);

  // Check if the insertion was successful
  if ($result) {
      echo "Data inserted successfully.";
  } else {
      echo "Error: Failed to insert data. " . pg_last_error($conn);
  }
} else {
  echo "Error: Invalid input.";
}




// Close the database connection
pg_close($conn);
?>
