<?php
include '../db.php';
header('Access-Control-Allow-Origin:*');

$Owner_ID = $_POST['Owner_ID'];

// Insert data into databaseDELETE FROM featuredrawn WHERE OwnerID = ?"
$add_query = $dbconn->prepare("DELETE From shopinfo WHERE OwnerID = ?");
$add_query->bind_param("i",$Owner_ID);

if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}

$add_query->close();
$dbconn->close();
?>