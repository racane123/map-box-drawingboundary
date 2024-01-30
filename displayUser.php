<?php
// Allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "dbconn.php";

if (!$conn) {
    die("Error connecting to the database");
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>
