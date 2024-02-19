<?php
include ('../db.php');

header('Access-Control-Allow-Origin: http://trygis.infinityfreeapp.com/');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if type parameter is provided
    if (isset($_GET['type'])) {
        // Sanitize the input to prevent SQL injection
        $type = $dbconn->real_escape_string($_GET['type']);
        
        // Query with type filter
        $query = "SELECT type, name, baranggay_no, ST_AsGeoJSON(geom) as geometry, feature_id  
                  FROM featuredrawn 
                  WHERE type = '$type'";
    } else {
        $query = "SELECT type, name, baranggay_no, ST_AsGeoJSON(geom) as geometry, feature_id  FROM featuredrawn";
    }

    $result = $dbconn->query($query);

    if (!$result) {
        error_log('Error fetching data: ' . $dbconn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
        exit;
    }

    $features = [];

    while ($row = $result->fetch_assoc()) {
        $geometry = json_decode($row['geometry']);
        $feature = [
            'type' => 'Feature',
            'geometry' => $geometry,
            'properties' => [
                'type' => $row['type'],
                'name' => $row['name'],
                'baranggay_no' => $row['baranggay_no'],
                'feature_id' => $row['feature_id']
            ],
        ];
        $features[] = $feature;
    }

    $geoJsonResponse = [
        'type' => 'FeatureCollection',
        'features' => $features,
    ];
    header('Content-Type: application/json');
    echo json_encode($geoJsonResponse);
    exit;
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
}

$dbconn->close();
?>
