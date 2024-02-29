<?php
include '../db.php';



// Define the API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Assuming $dbconn is your database connection object

    // Query to retrieve total number of residents and other information
    $sql = "SELECT 
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178) AS total_residents,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178 AND gender = 'Male') AS male_count,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178 AND gender = 'Female') AS female_count,
    residents.ResidentID,
    residents.name,
    residents.age,
    residents.gender,
    residents.height,
    residents.weight,
    residents.bmi,
    residents.bmi_category,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178 AND bmi_category = 'Underweight') AS underweight_count,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178 AND bmi_category = 'Normal Weight') AS normalweight_count,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178 AND bmi_category = 'Overweight') AS overweight_count,
    (SELECT COUNT(*) FROM residents WHERE brgy_no = 178 AND bmi_category = 'Obesity') AS obesity_count
    FROM residents
    INNER JOIN barangay ON residents.brgy_no = barangay.barangay_no
    WHERE residents.brgy_no = 178
    GROUP BY
    residents.ResidentID,
    residents.name,
    residents.age,
    residents.gender,
    residents.height,
    residents.weight,
    residents.bmi,
    residents.bmi_category
    ";

    $result = $dbconn->query($sql);

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
    exit;
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method Not Allowed']);
}

$dbconn->close();
?>