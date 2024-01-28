<?php
// Allow cross-origin resource sharing (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "dbconn.php";
if (!$conn) {
    die("Error connecting to the database");
}

$sql = "SELECT * FROM users";
$result = pg_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . pg_last_error($conn));
}

$data = array();

while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}

pg_close($conn);

echo json_encode($data);
?>
