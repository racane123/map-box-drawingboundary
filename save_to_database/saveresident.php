<?php
include '../db.php';

// Retrieve form data
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$bmi = $_POST['bmi'];
$bmi_category = $_POST['bmi_category'];
$feature_id = $_POST['feature_id'];
$brgy_no = $_POST['barangay_no'];


$add_query = $dbconn->prepare("INSERT INTO residents (name, age,gender, height, weight,bmi,bmi_category, feature_id,brgy_no) VALUES (?,?,?,?,?,?,?,?,?)");
$add_query->bind_param("sisiiisii", $name, $age, $gender,$height, $weight, $bmi,$bmi_category,$feature_id,$brgy_no);


if ($add_query->execute()) {
  echo json_encode(array("statusCode" => 200));
} else {
  echo json_encode(array("statusCode" => 201, "error" => $add_query->error));
}


$add_query->close();

$dbconn->close();
?>

