<?php
require('../db/dbconn.php');

// Function to fetch geocoding details using Mapbox API and extract place_name
function fetchPlaceName($latitude, $longitude) {
    $mapbox_access_token = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
    $mapbox_url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' . $longitude . ',' . $latitude . '.json?access_token=' . $mapbox_access_token;
    
    $geocoding_response = file_get_contents($mapbox_url);
    $geocoding_data = json_decode($geocoding_response, true);

    // Extract place_name
    $place_name = $geocoding_data['features'][0]['place_name'];

    return $place_name;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $sql = "SELECT drivers.name, ST_AsGeoJSON(end_location) as location FROM routes JOIN drivers ON routes.driver_id = drivers.driver_id";

    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Decode the GeoJSON string
        $geojson = json_decode($row['location'], true);

        // Extract latitude and longitude
        $coordinates = $geojson['coordinates'];
        $latitude = $coordinates[1];
        $longitude = $coordinates[0];

        // Fetch place name using Mapbox API
        $place_name = fetchPlaceName($latitude, $longitude);

        // Create a new array with name and place_name
        $location = array(
            'name' => $row['name'],
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
