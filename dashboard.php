<?php

session_start();
include 'header.php';

?>


<aside class="text-light aside-bg" style="display: flex; flex-direction: column; align-items: center; padding: 20px;">
    <a href="" class='nav-brand'><img src="images/logo-text.png" alt="logo" srcset="" class='logo-brand'></a>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-light" onclick="loadDashboardContent()">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" onclick="loadAdminGeoData()">Geo Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" onclick="loadMap()">Map</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light">Section 3</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light">Section 4</a>
        </li>
    </ul>
</aside>

<div class="content">
</div>

<script>
    // Function to fetch and update dashboard content
    function updateDashboard() {
        $.ajax({
            url: 'userAccounts.php', // Replace with the actual server endpoint
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard
                $('.content').html(data);
            },
            error: function(error) {
                console.error('Error fetching dashboard data:', error);
            }
        });
    }

    // Function to load dashboard content
    function loadDashboardContent() {
        updateDashboard();
    }

    // Function to load Admin Geo Data content
    function loadAdminGeoData() {
        $.ajax({
            url: 'admin-geodata.php', // Replace with the actual server endpoint
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard with Admin Geo Data
                $('.content').html(data);
            },
            error: function(error) {
                console.error('Error fetching Admin Geo Data:', error);
            }
        });
    }

    // Function to load Map content
    function loadMap() {
        $.ajax({
            url: 'usermap.php', // Replace with the actual server endpoint
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard
                $('.content').html(data);
            },
            error: function(error) {
                console.error('Error fetching dashboard data:', error);
            }
        });
    }

    // Initial load of the dashboard
    loadDashboardContent();



</script>