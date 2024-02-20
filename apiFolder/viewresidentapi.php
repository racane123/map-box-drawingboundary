<?php
include '../db.php';

// Define the API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if feature_id is set in the POST data
    if (isset($_POST['feature_id'])) {
        // Extract feature_id from POST data
        $feature_id = $_POST['feature_id'];

        // Prepare and bind the SQL query with a parameter
        $sql = "SELECT DISTINCT
                    residents.name,
                    residents.age,
                    residents.gender,
                    residents.height,
                    residents.weight
                FROM
                    residents
                INNER JOIN
                    featuredrawn ON residents.feature_id = featuredrawn.feature_id
                WHERE
                    featuredrawn.feature_id = ?";

        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("i", $feature_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Output data of each row
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo json_encode($data);
        } else {
            echo json_encode(["error" => "No residents found"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Feature ID not provided"]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
}

$dbconn->close();
?>
