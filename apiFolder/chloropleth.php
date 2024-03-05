<?php
include ('../db.php');

header('Access-Control-Allow-Origin: http://trygis.infinityfreeapp.com/');
header('Access-Control-Allow-Methods: GET');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $query = "SELECT 
     (SELECT COUNT(*) FROM residents WHERE brgy_no = 171) AS total_residents_171,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 173) AS total_residents_173,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 177) AS total_residents_177,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178) AS total_residents_178,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 179) AS total_residents_179,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 186) AS total_residents_186,
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
                'total_residents_171' => $row['total_residents_171'],
                'total_residents_173' => $row['total_residents_173'],
                'total_residents_177' => $row['total_residents_177'],
                'total_residents_178' => $row['total_residents_178'],
                'total_residents_179' => $row['total_residents_179'],
                'total_residents_186' => $row['total_residents_186']
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


