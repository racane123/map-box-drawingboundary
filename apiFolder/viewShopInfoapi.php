<?php
include '../db.php';

header('Access-Control-Allow-Origin:*');
// Define the API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if feature_id is set in the POST data
    if (isset($_POST['feature_id'])) {
        $feature_id = $_POST['feature_id'];

        $sql = "SELECT DISTINCT
                    shopinfo.OwnerID,
                    shopinfo.O_Name,
                    shopinfo.O_age,
                    shopinfo.O_gender,
                    shopinfo.O_permit
                FROM
                    shopinfo
                INNER JOIN
                    featuredrawn ON shopinfo.O_featureID = featuredrawn.feature_id
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

            foreach ($data as &$row) {
                $row['O_permit'] = base64_encode($row['O_permit']);
            }

            echo json_encode($data);
        } else {
            echo json_encode(["error" => "No owner yet"]);
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
