<?php
include "template.php";
?>

<nav class="navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link">TownTechInnovations</a>
      </li>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="userView.php" class="nav-link" >OtherMap</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">


      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            if (isset($_SESSION['email'])) {
                echo $_SESSION['email'];
            }
            ?>
          
        </a>


        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
                <!-- Dropdown Start -->
                <?php
                 // Check if the user is an admin to display the Dashboard link
                 if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo '<a class="nav-link text-dark" href="admin/dashboard.php">Dashboard</a>';
                }
                ?>
                <div class="dropdown-divider"></div>
                <?php
                echo '<a class="dropdown-item dropdown-item-title text-dark mr-5" href="' . $_SERVER['REQUEST_URI'] . '/../auth/logout.php">Logout <i class="fas fa-sign-out-alt"></i></a>';
                ?>
            </a>
        </div>

        </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
</nav>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script>
   
// Activate dropdown toggle
$(document).ready(function(){
    $('.dropdown-toggle').dropdown();
});


</script>


