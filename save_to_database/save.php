<?php
include '../db.php';

$type = $_POST['typeofgeom'];
$name = $_POST['nameofgeom'];
$baranggay_no = $_POST['barangaynoofgeom'];
$stringgeom = $_POST['stringofgeom'];

// Prepare the INSERT query with proper MySQL syntax
$add_query = $dbconn->prepare("INSERT INTO featuredrawn (type, name,baranggay_no,geom) VALUES (?,?,?, ST_GeomFromGeoJSON(?))");
$add_query->bind_param("ssis", $type, $name, $baranggay_no,$stringgeom);

if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));

}

$dbconn->close();
?>