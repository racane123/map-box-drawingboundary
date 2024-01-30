<?php
include 'dbconn.php';
include 'header.php';

$sql = "SELECT * FROM drawn_features";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Fetch and display results
        echo "<div class='container mt-4 table-container'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        
        // Fetch the first row to get column names
        $firstRow = mysqli_fetch_assoc($result);
        
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        // Display table headers based on column names
        foreach ($firstRow as $columnName => $value) {
            echo "<th scope='col'>" . $columnName . "</th>";
        }
        echo "</tr>";
        echo "</thead>";
    
        // Reset the result pointer back to the beginning
        mysqli_data_seek($result, 0);
    
        echo "<tbody>";
        // Display data rows
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
    
        echo "</table>";
        echo "</div>"; // Close the table-responsive div
        echo "</div>"; // Close the container div
    } else {
        echo "<div class='container mt-4'>";
        echo "<p>No results found.</p>";
        echo "</div>";
    }
} else {
    // Handle query execution error
    echo "<div class='container mt-4'>";
    echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
    echo "</div>";
}
?>
