<?php
include '../db.php';

// Prepare and bind the UPDATE statement
$ResidentID = $_POST['ResidentID'];
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$weight = $_POST['weight'];

$add_query = $dbconn->prepare("UPDATE residents SET name=?, age=?, gender=?, height=?, weight=? WHERE ResidentID=?");
$add_query->bind_param("sisiii", $name, $age, $gender, $height, $weight, $ResidentID); // 'sisiii' indicates string, integer, integer, integer, integer, integer data types

// Execute the prepared statement
if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}

// Close the prepared statement
$add_query->close();

// Close the database connection
$dbconn->close();
?>


