<?php
session_start();
include 'header.php';

?>


<aside class="text-light aside-bg" style="display: flex; flex-direction: column; align-items: center; padding: 20px;">
    <a href="" class='nav-brand'><img src="images/logo-text.png" alt="logo" srcset="" class='logo-brand'></a>

    <ul class="nav flex-column p-3">
        <?php
            if(isset($_SESSION['email'])){
                echo '<li class="nav-item"><a class="nav-link text-light mb-5" href="index.php">'. $_SESSION['email'] .'</a></li>';
            }
        ?>
        <li class="nav-item">
            <a class="nav-link text-light" href="#" onclick="loadDashboardContent()"><i class="fas fa-users"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="#" onclick="loadAdminGeoData()"><i class="fas fa-globe"></i> Geo Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="#" onclick="loadMap()"><i class="fas fa-map"></i> Map</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="#section3"><i class="fas fa-file-alt"></i> Business Permit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="#section4"><i class="fas fa-cogs"></i> Section 4</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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