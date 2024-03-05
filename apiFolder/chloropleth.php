<?php
include ('../db.php');

header('Access-Control-Allow-Origin: http://trygis.infinityfreeapp.com/');
header('Access-Control-Allow-Methods: GET');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $query = "SELECT 
    (SELECT COUNT(*) FROM residents) AS total_residents,
    barangay.Type,
    barangay.Name,
    barangay.barangay_no,
    ST_AsGeoJSON(barangay.geom) as geometry,
    barangay.brgy_id
FROM 
    barangay
LEFT JOIN 
    residents ON barangay.barangay_no = residents.brgy_no
GROUP BY
    barangay.Type,
    barangay.Name,
    barangay.barangay_no,
    barangay.brgy_id;";

    
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
                'type' => $row['Type'],
                'name' => $row['Name'],
                'barangay_no' => $row['barangay_no'],
                'brgy_id' => $row['brgy_id'],
                'total_residents' => $row['total_residents']
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


