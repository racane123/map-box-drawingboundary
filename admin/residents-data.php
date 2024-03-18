<?php include ('../includes/template.php');?>


<h2>Data Table</h2>
<!--<button class="btn btn-primary" onclick="toggleTable()">View</button>-->
<table id="dataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Owner Name</th>
            <th>Address</th>
            <th>File</th>
        </tr>
    </thead>
    <tbody>
        <!-- Table body will be filled dynamically with data from API -->
    </tbody>
</table>

<script>
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
                                '<td><a href="#" onclick="viewFile(' + item.id + ')">View</a></td>' +
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
    setInterval(fetchData, 5000);

    // Function to view file
    function viewFile(id) {
        // Assuming the file can be viewed using a separate endpoint named view.php
        // You may need to adjust this URL according to your file viewing setup
        window.open('http://localhost/residents-test.php/view.php?id=' + id, '_blank');
    }
/** 
    function toggleTable() {
      var table = document.getElementById("dataTable");
      if (table.style.display === "none") {
        table.style.display = "table";
      } else {
        table.style.display = "none";
      }
    }
 **/   
</script>
