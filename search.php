<?php
include 'dbconn.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Escape the input to prevent SQL injection
    $query = mysqli_real_escape_string($conn, $query);

    // Construct the SQL query
    $sql = "SELECT * FROM drawn_features WHERE name LIKE '$query%' ";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Fetch and display results
            while ($row = mysqli_fetch_assoc($result)) {
                // Output your results here
                echo $row['name'] . "<br>";
                echo $row['feature_type']. "<br>";
                echo $row['coordinates'];
            }
        } else {
            echo "No results found.";
        }
    } else {
        // Handle query execution error
        echo "Error executing query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid search query.";
}
?>
