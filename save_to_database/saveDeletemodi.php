<?php
include '../db.php';

$feature_id = $_POST['feature_id_ofgeom'];

// Use a prepared statement to avoid SQL injection

$add_query = $dbconn->prepare("DELETE FROM featuredrawn WHERE feature_id = ?");
$add_query->bind_param("i",$feature_id); 

// Execute the prepared statement
if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}


$add_query->close();

$dbconn->close();
?>