<?php include ('../includes/template.php');?>
<h2>Data Table</h2>

<table id="dataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <!-- Table body will be filled dynamically with data from API -->
    </tbody>
</table>

<script>
    // Function to fetch data from API and populate the table
// Function to fetch data from API and populate the table
function fetchData() {
    $.ajax({
        url: 'http://localhost/residents-test.php/test.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Clear existing table data
            $('#dataTable tbody').empty();

            // Loop through API response data and populate table rows
            $.each(data, function(index, item) {
                var row = '<tr>' +
                            '<td>' + item.id + '</td>' +
                            '<td>' + item.owner_name + '</td>' +
                            '<td>' + item.address + '</td>' +
                            '<td>' + item.file_name + '</td>' +
                            '<td><a href="http://localhost/residents-test.php/download.php?id=' + item.id + '">Download</a></td>' +
                          '</tr>';
                $('#dataTable tbody').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
}

// Call fetchData function initially to populate table
fetchData();

// Set interval to periodically fetch data from API and update table
//setInterval(fetchData, 5000); // Update interval in milliseconds (e.g., 5000 for every 5 seconds)

    // Retrieve Data

// Download Fil
</script>


