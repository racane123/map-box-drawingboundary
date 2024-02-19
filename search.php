<?php
include 'db/dbconn.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, feature_type, ST_AsGeoJSON(coordinates) AS geojson FROM drawn_features WHERE name LIKE ?");
    
    // Bind the parameter
    $stmt->bind_param("s", $query);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    $features = array('type' => 'FeatureCollection', 'features' => array());
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $feature = array(
                    'type' => 'Feature',
                    'geometry' => json_decode($row['geojson']),
                    'properties' => array(
                        'id' => $row['id'],
                        'name' => $row['name']
                    )
                );
                array_push($features['features'], $feature);
            }

            $geojson_data = json_encode($features);

            echo $geojson_data;
        } else {
            echo json_encode(array('message' => 'No results found.'));
        }
    } else {
        // Log the error instead of showing it to the user
        error_log("Error executing query: " . $stmt->error);
        echo json_encode(array('message' => 'Error retrieving data.'));
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(array('message' => 'Invalid search query.'));
}

// Close the database connection
$conn->close();
?>
