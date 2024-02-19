<?php
include '../db.php';

// Retrieve form data
$O_name = $_POST['O_name'];
$O_age = $_POST['O_age'];
$O_gender = $_POST['O_gender'];
$O_permit = $_POST['O_permit'];
$O_feature_id = $_POST['O_feature_id'];
$O_barangay_no = $_POST['O_barangay_no'];

$add_query = $dbconn->prepare("INSERT INTO shopinfo (O_Name, O_age, O_gender,O_permit, O_featureID,O_barangay_no) VALUES (?,?,?,?,?,?)");
$add_query->bind_param("sisiii", $O_name, $O_age, $O_gender,$O_permit,$O_feature_id,$O_barangay_no);

if ($add_query->execute()) {
  echo json_encode(array("statusCode" => 200));
} else {
  echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}


$add_query->close();

$dbconn->close();
?>