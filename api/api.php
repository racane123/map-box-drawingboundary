<?php
// Ensure this script is accessed via HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header('Status: 403 Forbidden');
    echo 'HTTPS is required for this API.';
    exit;
}

include ('../db/dbconn.php');
// Handle API request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Perform database query
    $query = "SELECT name , title, address, feature_type, ST_AsGeoJSON(coordinates) as geojson FROM drawn_features";
    $result = $conn->query($query);
    
    // Check if data was retrieved
    if ($result->num_rows > 0) {
        // Initialize an empty array to hold features
        $features = array('type' => 'FeatureCollection', 'features' => array());
        
        // Fetch data from result set and encode as GeoJSON features
        while ($row = mysqli_fetch_assoc($result)) {
            $feature = array(
                'type' => 'Feature',
                'title' => $row['title'],
                'name' => $row['name'],
                'geometry' => json_decode($row['geojson']),
            );
            // Push each feature into the $features array
            array_push($features['features'], $feature);
        }
        
        // Prepare response
        $response = array('status' => 'success', 'data' => $features);
        echo json_encode($response);
    } else {
        // No data found
        $response = array('status' => 'error', 'message' => 'No data found');
        echo json_encode($response);
    }
} else {
    // Handle unsupported HTTP methods
    header('Status: 405 Method Not Allowed');
    echo 'Unsupported request method.';
}

// Close database connection
$conn->close();
?>
