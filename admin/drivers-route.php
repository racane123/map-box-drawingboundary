<?php
require('../includes/template.php');


?>


<style>
    .card {
        display: flex;
        justify-content: left;
        align-items: center;
        margin-top: 20px; /* Adjust margin as needed */
    }
</style>
<div class="content-wrapper">
<div class="card">
    <table id="routesTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Route ID</th>
                <th>Driver Name</th>
                <th>Route Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
</div>
<script>
    $(document).ready(function() {
        // Function to fetch routes data via AJAX
        function fetchRoutes() {
            $.ajax({
                url: '../driver/fetch_routes.php',
                type: 'GET',
                success: function(data) {
                    // Parse the JSON response
                    var routes = JSON.parse(data);
                    // Clear existing table rows
                    $('#routesTable tbody').empty();
                    // Append new rows with fetched data
                    routes.forEach(function(route) {
                        var row = '<tr><td>' + route.id + '</td><td>' + route.name + '</td><td>' + route.route_name + '</td><td>' + route.status + '</td>';
                        row += '<td><button class="btn btn-primary view-btn" data-id="' + route.id + '">View</button></td></tr>';
                        $('#routesTable tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // You can handle errors here, like displaying an error message
                }
            });
        }

        // Fetch routes on page load
        fetchRoutes();

        // View button click event handler
        $(document).on('click', '.view-btn', function() {
            var routeId = $(this).data('id');
            window.location.href = '../driver/driver-map.php?route_id=' + routeId;
        });
    });
</script>

<!-- Bootstrap JS -->
