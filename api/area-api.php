<?php
// Function to perform reverse geocoding


include('../db/dbconn.php');

// Set response header to JSON
header('Content-Type: application/json');

// Check if the request method is OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Allow requests from any origin
    header('Access-Control-Allow-Origin: 127.0.0.1:5009');
    // Allow the GET method
    header('Access-Control-Allow-Methods: GET');
    // Allow content type application/json
    header('Access-Control-Allow-Headers: Content-Type');
    // End the script for OPTIONS requests  
    exit;
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Allow requests from specific origins, you can replace '*' with your domain
    header('Access-Control-Allow-Origin: *');

    // SQL query to fetch name and coordinates as GeoJSON from database
    $query = "SELECT name,title, ST_AsGeoJSON(coordinates) AS geojson FROM drawn_features";

    // Execute the query
    $result = $conn->query($query);

    // Initialize an empty array to store the response
    $response = array();

    // Iterate through the result set
    // Iterate through the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Decode the GeoJSON coordinates
        $coord = json_decode($row['geojson'], true); // Decode as associative array
        $name = $row['name'];
        $title = $row['title'];

        // Check if coordinates key exists
        if (!isset($coord['coordinates'])) {
            continue; // Skip this feature if coordinates are not available
        }

        // Extract coordinates
        $coordinates = $coord['coordinates'][0];

        // Ensure coordinates are in array format
        if (!is_array($coordinates)) {
            continue; // Skip this polygon if coordinates are not in expected format
        }
        // Extracting polygon coordinates
        $centercoordinates = $coord['coordinates'][0];
        $centroid = calculateCentroid($centercoordinates);
        // Reverse geocoding the centroid
        $centroidInfo = reverseGeocode($centroid[1], $centroid[0]);

        // Extracting address lines and concatenating
        $addressLine1 = isset($centroidInfo['features'][0]['properties']['address_line1']) ? $centroidInfo['features'][0]['properties']['address_line1'] : '';
        $addressLine2 = isset($centroidInfo['features'][0]['properties']['address_line2']) ? $centroidInfo['features'][0]['properties']['address_line2'] : '';

        // Concatenate address lines, ensuring non-empty strings are concatenated with a space
        $address = trim(($addressLine1 !== '' ? $addressLine1 . ' ' : '') . $addressLine2);

        // Calculate area using Haversine formula
        $area = calculatePolygonArea($coordinates);
        // Add area to response
        $response[] = array('name' => $name, 'title' => $title, 'address' => $address, 'area' => $area);
    }


    // Encode the response as JSON and echo it
    echo json_encode($response);
}

// Function to calculate area of a polygon
function calculatePolygonArea($coordinates)
{
    $totalArea = 0;
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
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $R * $c;

        // Add it to total area
        $totalArea += $distance;
    }

    // Return total area
    return $totalArea;
}

// Function to calculate the centroid of a polygon
function calculateCentroid($coordinates)
{
    $numVertices = count($coordinates);

    if ($numVertices < 3) {
        return null; // Not a valid polygon
    }

    $sumX = 0;
    $sumY = 0;

    foreach ($coordinates as $coordinate) {
        $lon = $coordinate[0];
        $lat = $coordinate[1];

        $sumX += $lon;
        $sumY += $lat;
    }

    $centroidLon = $sumX / $numVertices;
    $centroidLat = $sumY / $numVertices;

    return array($centroidLon, $centroidLat);
}

function reverseGeocode($latitude, $longitude)
{
    $apiKey = '236351096d5f4b03a5b0ce68dd2dbe30'; // Replace 'YOUR_API_KEY' with your actual API key
    $url = "https://api.geoapify.com/v1/geocode/reverse?lat=$latitude&lon=$longitude&apiKey=$apiKey";

    try {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Reverse geocoding request failed: ' . curl_error($curl));
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($statusCode !== 200) {
            throw new Exception('Reverse geocoding request failed with status code: ' . $statusCode);
        }

        $data = json_decode($response, true);
        curl_close($curl);

        return $data;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
