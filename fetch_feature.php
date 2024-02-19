<?php
// Include database connection file
include 'db/dbconn.php';

// Check if ID parameter is provided
if(isset($_POST['id'])) {
    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to fetch the feature details by ID
    $sql = "SELECT id, name, title, feature_type FROM drawn_features WHERE id = '$id'";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if($result) {
        // Check if a record was found
        if(mysqli_num_rows($result) == 1) {
            // Fetch the record
            $row = mysqli_fetch_assoc($result);
            
            // Return the feature details as JSON
            echo json_encode($row);
        } else {
            // No record found with the provided ID
            echo json_encode(array("error" => "No record found with the provided ID"));
        }
    } else {
        // Query failed
        echo json_encode(array("error" => "Error executing query: " . mysqli_error($conn)));
    }
} else {
    // ID parameter not provided
    echo json_encode(array("error" => "ID parameter not provided"));
}

// Close database connection
mysqli_close($conn);
?>
