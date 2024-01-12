<?php
include 'dbconn.php';

$sql = "SELECT id, name, feature_type, ST_AsGeoJSON(coordinates) AS geojson from drawn_features";
$result = pg_query($conn, $sql);

$features = array('type' => 'FeatureCollection', 'features' => array());

while ($row = pg_fetch_assoc($result)) {
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

pg_close($conn);
