<?php
include '../db.php';

$O_name = $_POST['O_name'];
$O_age = $_POST['O_age'];
$O_gender = $_POST['O_gender'];
$O_feature_id = $_POST['O_feature_id'];
$O_barangay_no = $_POST['O_barangay_no'];

if (isset($_FILES['O_permit'])) {
    $permitContent = file_get_contents($_FILES['O_permit']['tmp_name']);
    if ($permitContent === false) {
        echo json_encode(array("statusCode" => 201, "error" => "Error reading the uploaded file."));
        exit;
    }
} else {
    echo json_encode(array("statusCode" => 201, "error" => "No file uploaded."));
    exit;
}

// Insert data into database
$add_query = $dbconn->prepare("INSERT INTO shopinfo (O_Name, O_age, O_gender, O_permit, O_featureID, O_barangay_no) VALUES (?, ?, ?, ?, ?, ?)");
$add_query->bind_param("sisssi", $O_name, $O_age, $O_gender, $permitContent, $O_feature_id, $O_barangay_no);

if ($add_query->execute()) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}

$add_query->close();
$dbconn->close();
?>
