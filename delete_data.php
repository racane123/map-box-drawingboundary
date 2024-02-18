<?php
// Include database connection or any necessary configurations
include('db/dbconn.php');

// Check if the ID parameter is sent via POST request
if(isset($_POST['id'])) {
    // Sanitize the received ID to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Prepare the DELETE query
    $sql = "DELETE FROM drawn_features WHERE id = '$id'";

    // Execute the DELETE query
    if(mysqli_query($conn, $sql)) {
        // Deletion successful
        $response = array(
            'success' => true,
            'message' => 'Record deleted successfully.'
        );
        echo json_encode($response);
    } else {
        // Error occurred while deleting
        $response = array(
            'success' => false,
            'message' => 'Error deleting record: ' . mysqli_error($conn)
        );
        echo json_encode($response);
    }
} else {
    // ID parameter is missing
    $response = array(
        'success' => false,
        'message' => 'ID parameter is missing.'
    );
    echo json_encode($response);
}
?>
