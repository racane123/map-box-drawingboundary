<?php
include '../db.php';

// Check if email and new password are provided
if(isset($_POST['email']) && isset($_POST['newPass'])) {
    $email = $_POST['email'];
    $newPass = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
   
    $add_query = $dbconn->prepare("UPDATE users SET `password` = ? WHERE email = ?");
    
    if (!$add_query) {
        echo json_encode(array("statusCode" => 500, "error" => "Error preparing query: " . $dbconn->error));
        exit;
    }

    $add_query->bind_param("ss", $newPass, $email); 

    if ($add_query->execute()) {
        echo json_encode(array("statusCode" => 200));
    } else {
        echo json_encode(array("statusCode" => 201, "error" => "Error executing query: " . $add_query->error));
    }
   
    $add_query->close();
} else {
    echo json_encode(array("statusCode" => 400, "error" => "Missing email or new password"));
}

$dbconn->close();
?>
