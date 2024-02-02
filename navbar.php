<?php


?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap');
  img{
    width: 100px;
    height: 50px;
  }

  .navbar-brand{
    font-family: "Josefin Sans", sans-serif;
    font-optical-sizing: auto;
    font-weight: bold;
    font-style: normal;
  }
 li{
    color:black;
  }
</style>


<nav class="navbar navbar-expand-lg navbar-dark bg-blue">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand text-dark" href="#"><img src="images/logo-text.png" alt="logo">TownTechInnovations</a>
    <!-- Toggle button for mobile view -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navigation links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
                <?php
                // Check if the user is an admin to display the Dashboard link
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="dashboard.php">Dashboard</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" onclick="showMap()">Chloropleth</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" onclick="showMap()">Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" onclick="showMap()">Map</a>
                </li>

                <?php
                if (isset($_SESSION['email'])) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $_SESSION["email"] . '</a>';
                    echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">';
                    echo '<li><a class="dropdown-item text-dark" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>
      </ul>
    </div>
  </div>
</nav>






