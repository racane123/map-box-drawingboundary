<?php
include '../db.php';

$type = $_POST['typeofgeom'];
$name = $_POST['nameofgeom'];
$baranggay_no = $_POST['barangaynoofgeom'];
$address = $_POST['address'];
$stringgeom = $_POST['stringofgeom'];

// Prepare the INSERT query with proper MySQL syntax
$add_query = $dbconn->prepare("INSERT INTO featuredrawn (type, name,baranggay_no,address,geom) VALUES (?,?,?,?, ST_GeomFromGeoJSON(?))");
$add_query->bind_param("ssiss", $type, $name, $baranggay_no,$address,$stringgeom);

if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));

}

$dbconn->close();
?>