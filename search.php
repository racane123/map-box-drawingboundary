<?php
include 'dbconn.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Escape the input to prevent SQL injection
    $query = mysqli_real_escape_string($conn, $query);

    // Construct the SQL query

    $sql = "SELECT id, name, feature_type, ST_AsGeoJSON(coordinates) AS geojson from drawn_features WHERE name LIKE '$query'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    $features = array('type' => 'FeatureCollection', 'features' => array());
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            
            while ($row = mysqli_fetch_assoc($result)) {
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
            echo "No results found.";
        }
    } else {
        // Handle query execution error
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid search query.";
}
?>
