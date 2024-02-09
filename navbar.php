<?php
include "template.php";
?>

<nav class="navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">

      <a class="nav-link" data-toggle="dropdown" href="#">
            <?php
            if (isset($_SESSION['email'])) {
                echo $_SESSION['email'];
            }
            ?>
            <i class="fas fa-caret-down"></i>
        </a>


        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
                <!-- Dropdown Start -->
                <?php
                 // Check if the user is an admin to display the Dashboard link
                 if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo '<a class="nav-link text-dark" href="dashboard.php">Dashboard</a>';
                }
                ?>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item dropdown-item-title text-dark mr-5" href="logout.php">
                    <span class="">
                        Logout
                        <i class="fas fa-sign-out-alt"></i>
                    </span>
                </a>
            </a>
        </div>

        </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
</nav>


<script>
   
// Activate dropdown toggle
$(document).ready(function(){
    $('.dropdown-toggle').dropdown();
});
</script>