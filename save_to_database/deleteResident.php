<?php
include '../db.php';

$ResidentID = $_POST['ResidentID'];

// Insert data into databaseDELETE FROM featuredrawn WHERE OwnerID = ?"
$add_query = $dbconn->prepare("DELETE From residents WHERE ResidentID = ?");
$add_query->bind_param("i",$ResidentID);

if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}

$add_query->close();
$dbconn->close();
?>