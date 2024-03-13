<?php
require('../db/dbconn.php');

// Function to fetch geocoding details using Mapbox API and extract place_name
function fetchPlaceName($latitude, $longitude) {
    $mapbox_access_token = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ'; // Replace with your Mapbox access token
    $mapbox_url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' . $longitude . ',' . $latitude . '.json?access_token=' . $mapbox_access_token;
    
    // Use cURL to make HTTP request
    $curl = curl_init($mapbox_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $geocoding_response = curl_exec($curl);
    curl_close($curl);

    // Check if response is valid
    if ($geocoding_response === false) {
        return false;
    }

    // Decode the response
    $geocoding_data = json_decode($geocoding_response, true);

    // Extract place_name
    $place_name = $geocoding_data['features'][0]['place_name'];

    return $place_name;
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Make a request to the provided URL
    $emergency_response_url = 'https://group65.towntechinnovations.com/emergency-response.php';
    $emergency_response = file_get_contents($emergency_response_url);

    // Check if response is valid
    if ($emergency_response === false) {
        http_response_code(400);
        exit("Error: Unable to retrieve data from the URL.");
    }

    // Decode the JSON response
    $emergency_data = json_decode($emergency_response, true);

    $data = array();
    foreach ($emergency_data['reports'] as $report) {
        // Fetch coordinates from the location object
        $latitude = $report['location']['coordinates'][1];
        $longitude = $report['location']['coordinates'][0];

        // Fetch place name using Mapbox API
        $place_name = fetchPlaceName($latitude, $longitude);

        // Create a new array with name and place_name
        $location = array(
            'fullName' => $report['fullName'],
            'place_name' => $place_name
        );

        // Add the new location array to the data array
        $data[] = $location;
    }

    // Encode the cleaned data into JSON format
    $routes_data = json_encode($data);

    echo $routes_data;
} else {
    http_response_code(400);
}

mysqli_close($conn);
?>
