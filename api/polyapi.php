<?php
include ('../db/dbconn.php');

$sql = "SELECT id, name, title, feature_type, ST_AsGeoJSON(coordinates) AS geojson from drawn_features";
$result = mysqli_query($conn, $sql);

$features = array('type' => 'FeatureCollection', 'features' => array());

while ($row = mysqli_fetch_assoc($result)) {
    $feature = array(
        'type' => 'Feature',
        'geometry' => json_decode($row['geojson']),
        'properties' => array(
            'id' => $row['id'],
            'title' => $row['title'],
            'name' => $row['name']
        )
    );
    array_push($features['features'], $feature);
}

$geojson_data = json_encode($features);

echo $geojson_data;

mysqli_close($conn);
?>
