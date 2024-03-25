<?php

// Include database connection
include('../db/dbconn.php');

// Function to perform reverse geocoding
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

// Fetch data from the database
$query = "SELECT name, title, ST_AsGeoJSON(coordinates) AS geojson FROM drawn_features";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error retrieving data from database: ' . mysqli_error($conn));
}

$polygons = array();

// Loop through each row of the result set
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $title = $row['title'];
    $geojson = json_decode($row['geojson'], true);

    // Extracting polygon coordinates
    $coordinates = $geojson['coordinates'];

    // Calculating center point of polygon
    $centroid = calculateCentroid($coordinates);

    // Skip if centroid calculation failed
    if (!$centroid) {
        continue;
    }

    // Reverse geocoding the centroid
    $centroidInfo = reverseGeocode($centroid[1], $centroid[0]);

    // Skip if reverse geocoding failed
    if (isset($centroidInfo['error'])) {
        continue;
    }

    // Extracting address lines and concatenating
    $addressLine1 = isset($centroidInfo['features'][0]['properties']['address_line1']) ? $centroidInfo['features'][0]['properties']['address_line1'] : '';
    $addressLine2 = isset($centroidInfo['features'][0]['properties']['address_line2']) ? $centroidInfo['features'][0]['properties']['address_line2'] : '';

    // Concatenate address lines, ensuring non-empty strings are concatenated with a space
    $address = trim(($addressLine1 !== '' ? $addressLine1 . ' ' : '') . $addressLine2);

    // Adding center point, address, and other data to the polygons array
    $polygons[] = array(
        'name' => $name,
        'title' => $title,
        'centroid' => $centroid,
        'address' => $address // Add concatenated address to the array
    );
}

// Output the polygons array
header('Content-Type: application/json');
echo json_encode($polygons);

// Close database connection
mysqli_close($conn);

// Function to calculate centroid of a polygon
function calculateCentroid($coordinates) {
    $numVertices = count($coordinates);

    if ($numVertices < 3) {
        return null; // Not a valid polygon
    }

    $sumX = 0;
    $sumY = 0;

    for ($i = 0; $i < $numVertices; $i++) {
        $lon = $coordinates[$i][0];
        $lat = $coordinates[$i][1];

        $sumX += $lon;
        $sumY += $lat;
    }

    $centroidLon = $sumX / $numVertices;
    $centroidLat = $sumY / $numVertices;

    return array($centroidLon, $centroidLat);
}
function calculatePolygonArea($coordinates) {
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
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $R * $c;
        
        // Add it to total area
        $totalArea += $distance;
    }
    
    // Return total area
    return $totalArea;
}
?>
