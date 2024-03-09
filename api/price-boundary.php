<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data sent from the client
    $json_data = file_get_contents('php://input');
    
    // Decode the JSON data into an associative array
    $data = json_decode($json_data, true);
    
    // Validate the data if necessary
    
    // Connect to your database (modify the connection details as needed)
    include('../db/dbconn.php');
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO boundaryprice (name, area, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sdd", $name, $area, $price);

    // Set parameters and execute the statement
    $name = $data['name'];
    $area = $data['area'];
    $price = $data['price'];

    if ($stmt->execute()) {
        // Data inserted successfully
        echo json_encode(array("status" => "success"));
    } else {
        // Failed to insert data
        echo json_encode(array("status" => "error", "message" => $stmt->error));
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Request method is not POST
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
