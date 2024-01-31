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
</style>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="images/logo-text.png" alt="logo">TownTechInnovations</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?php
                // Check if the user is an admin to display the Dashboard link
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                    echo '<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showMap()">Map</a>
                </li>

                <?php
                if (isset($_SESSION['email'])) {
                    echo '<li class="nav-item text-left"><a class="nav-link" href="#">'. $_SESSION["email"]. '</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>





