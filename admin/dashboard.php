<?php
session_start();


include('../includes/template.php');
<<<<<<< HEAD
include('../includes/otherHeader.php');
include('../includes/header.php');
=======
include('../includes/header.php');
include('../includes/otherHeader.php');
>>>>>>> otherbranch

?>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
 
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a  class="brand-link">
      <img src="../images/logo-text.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">TownTechInnovations</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../images/avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php
                if(isset($_SESSION['email'])){
                    echo $_SESSION['email'];
                }
            ?>
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
<<<<<<< HEAD
              <a  class="nav-link" onclick="">
                <i class="nav-icon fa-solid fa-gauge"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link" onclick=''>
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>Analytics Data</p>
                  </a>
                </li>
                <li class="nav-item">
                </li>
                <li class="nav-item">
                </li>
              </ul>
=======
              <a  class="nav-link" onclick="loadAnalyticsContent()">
                <i class="nav-icon fa-solid fa-gauge"></i>
                <p>
                  Analytics
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
>>>>>>> otherbranch
            </li>
          <li class="nav-item">
            <a  class="nav-link" onclick="loadDashboardContent()">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
            <!--<ul class="nav nav-treeview">
              <li class="nav-item">
              </li>
              <li class="nav-item">
              </li>
              <li class="nav-item">
              </li>
            </ul>-->
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Table Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link" onclick='loadAdminGeoData()'>
                  <i class="nav-icon fas fa-globe"></i>
                  <p>Geo Data</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="" class="nav-link">
              <i class="nav-icon fa-solid fa-route"></i>
              <p>Drivers Route</p>
              </a>
              </li>
              <li class="nav-item">
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link" onclick="loadMap()">
              <i class="nav-icon fas fa-map"></i>
              <p>
                 Admin Map
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="loadotherMap()">
              <i class="nav-icon fas fa-map"></i>
              <p>
                Admin Map 2
                <i class="right fas fa-angle-right"></i>
                
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="../index.php" class="nav-link">  <i class="nav-icon fas fa-map"></i>   <p> User Map <i class="right fas fa-angle-right"></i></p></a>
          </li>
          <!--decision 1-->
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    <div class="sidebar-custom">
      <a href="#" class="btn btn-link"><i class="fas fa-cogs"></i></a>
      <a href="../auth/logout.php" class="btn btn-secondary hide-on-collapse pos-right"><i class="fas fa-sign-out-alt"></i></a>
    </div>
    <!-- /.sidebar-custom -->
  </aside>

  

    <!-- Main content -->
    <section class="content-creation">




    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<<<<<<< HEAD
=======
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>




>>>>>>> otherbranch
<script>
    // Function to fetch and update dashboard content
    function updateDashboard() {
        $.ajax({
            url: 'userAccounts.php',
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard
                $('.content-creation').html(data);
                $('h2').text('Account Management');
            },
            error: function(error) {
                alert('Error fetching dashboard data:', error);
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
            url: 'admin-geodata.php',
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard with Admin Geo Data
                $('.content-creation').html(data);
                $('h1').text('Geo Data');
            },
            error: function(error) {
                alert('Error fetching Admin Geo Data:', error);
            }
        });
    }

    // Function to load Map content
    function loadMap() {
        $.ajax({
            url: 'usermap.php', 
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard
                $('.content-creation').html(data);
                $('h2').text('Map');
            },
            error: function(error) {
                alert('Error fetching dashboard data:', error);
            }
        });
    }
    

    // Function to load Map content
    function loadotherMap() {
        $.ajax({
            url: '../otherMap.php', 
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard
                $('.content-creation').html(data);
         
            },
            error: function(error) {
                alert('Error fetching dashboard data:', error);
            }
        });
    }



     // Function to analytics
     function loadAnalyticsContent() {
        $.ajax({
            url: '../analytics.php', 
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                // Update the content of the dashboard
                $('.content-creation').html(data);
         
            },
            error: function(error) {
                alert('Error fetching dashboard data:', error);
            }
        });
    }

    // Initial load of the dashboard
    loadDashboardContent();



</script>



</body>