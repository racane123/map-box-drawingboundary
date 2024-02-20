<?php
include '../db.php';

$type = $_POST['typeofgeom'];
$name = $_POST['nameofgeom'];
$barangay_no = $_POST['barangaynoofgeom'];
$stringgeom = $_POST['stringofgeom'];

$add_query = $dbconn->prepare("UPDATE residents SET name=?, age=?, gender=?, height=?, weight=? WHERE ResidentID=?");
$add_query->bind_param("sisiii", $name, $age, $gender, $height, $weight, $ResidentID); // 'sisiii' indicates string, integer, integer, integer, integer, integer data types

// Prepare the INSERT query with proper MySQL syntax
$add_query = $dbconn->prepare("INSERT INTO barangay (type, name,barangay_no,geom) VALUES (?,?,?, ST_GeomFromGeoJSON(?))");
$add_query->bind_param("ssis", $type, $name, $barangay_no,$stringgeom);

if (add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));

}

$dbconn->close();
?>