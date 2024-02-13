<?php
include 'dbconn.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ID and other required fields are set
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['title'])) {
        // Sanitize input data to prevent SQL injection
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);

        // Update query
        $sql = "UPDATE drawn_features SET name='$name', title='$title' WHERE id='$id'";
    
        // Execute query
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("success" => true, "message" => "Record updated successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Error updating record: " . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Required fields are missing"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

mysqli_close($conn);
?>
