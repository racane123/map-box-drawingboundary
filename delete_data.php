<?php
include 'db/dbconn.php';
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Prepare and execute statement to delete the item
    $sql = "DELETE FROM drawn_features WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the statement
    $success = $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Prepare response
    $response = array();
    if($success) {
        $response['success'] = true;
        $response['message'] = "Item successfully deleted.";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to delete item.";
    }
} else {
    // ID is not provided
    $response['success'] = false;
    $response['message'] = "ID not provided.";
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
