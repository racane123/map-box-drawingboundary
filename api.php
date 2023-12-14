<?php

include_once('dbconn.php');

// Get JSON data from the POST request
$inputJSON = file_get_contents('php://input');
error_log('Received JSON data: ' . $inputJSON);

$data = json_decode($inputJSON);

// Check if JSON decoding was successful
if ($data === null) {
    $response = ['status' => 'error', 'message' => 'Invalid JSON data'];
    echo json_encode($response);
    exit;
}

// Decode the coordinates JSON string
$type = $data->type;
$coordinates = json_decode($data->coordinates);

// Check if coordinates decoding was successful
if ($coordinates === null) {
    $response = ['status' => 'error', 'message' => 'Invalid coordinates data'];
    echo json_encode($response);
    exit;
}

// Prepare and execute a SQL statement to insert the polygon coordinates
$sql = "INSERT INTO group68 (geometry) VALUES (ST_GeomFromGeoJSON(?))";
$stmt = $conn->prepare($sql);

// Check if the SQL statement preparation was successful
if (!$stmt) {
    $response = ['status' => 'error', 'message' => 'Failed to prepare SQL statement: ' . $conn->error];
    echo json_encode($response);
    exit;
}

$stmt->bind_param('s', $data->type);

// Check if the SQL statement execution was successful
if ($stmt->execute()) {
    $response = ['status' => 'success', 'message' => 'Polygon saved successfully'];
} else {
    $response = ['status' => 'error', 'message' => 'Failed to save polygon. Error: ' . $stmt->error];
}

echo json_encode($response);
?>