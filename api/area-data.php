<?php

include('../db/dbconn.php');



// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // SQL query to fetch name and coordinates as GeoJSON from database
    $query = "SELECT feature_type, name, ST_AsGeoJSON(coordinates) AS geojson FROM drawn_features";

    // Execute the query
    $result = $conn->query($query);

    // Initialize an empty array to store the response
    $response = array();

    // Iterate through the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Decode the GeoJSON coordinates
        $coord = json_decode($row['geojson'], true);
        $name = $row['name'];
        $featureType = $row['feature_type'];
    
        // Check if coordinates exist and are an array
        if (!isset($coord['type']) || $coord['type'] !== 'Polygon' || !isset($coord['coordinates'][0]) || !is_array($coord['coordinates'][0])) {
            continue; // Skip this iteration if it's not a valid Polygon
        }
    
        $coordinates = $coord['coordinates'][0];
    
        // Calculate area using Haversine formula
        $area = calculatePolygonArea($coordinates);
    
        // Add area to response
        $response[] = array('name' => $name, 'featureType' => $featureType, 'area' => $area);
    }
    
    
    // Encode the response as JSON and echo it
    echo json_encode($response);
}

// Function to calculate area of a polygon
function calculatePolygonArea($coordinates) {
    $totalArea = 0;
    
    // Ensure $coordinates is always an array
    if (!is_array($coordinates)) {
        $coordinates = [$coordinates]; // Convert single coordinate to an array
    }
    
    $numVertices = count($coordinates);

    if ($numVertices < 3) {
        return 0; // Not a valid polygon
    }

    for ($i = 0; $i < $numVertices - 1; $i++) {
        $lon1 = $coordinates[$i][0];
        $lat1 = $coordinates[$i][1];
        $lon2 = $coordinates[$i + 1][0];
        $lat2 = $coordinates[$i + 1][1];
        
        // Haversine formula implementation
        $R = 6378160; // Earth radius in meters
        $dLon = deg2rad($lon2 - $lon1);
        $dLat = deg2rad($lat2 - $lat1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $R * $c;
        
        // Add it to total area
        $totalArea += $distance;
    }
    
    // Return total area
    return $totalArea;
}