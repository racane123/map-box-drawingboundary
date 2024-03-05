

<body>

<div class="content-wrapper"  style="padding-left:20px;">

         <!--navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Select Barangay 
              </a>
              <ul class="dropdown-menu" >  
                <li> <a class="dropdown-item" id="barangay179" data-brgyno="179"
                            onclick="viewResidentChart_Table(this)">Barangay 179</a></li>
                <li><a class="dropdown-item" id="barangay171" data-brgyno="171"
                            onclick="viewResidentChart_Table(this)">Barangay 171</a></li> 
                <li> <a class="dropdown-item" id="barangay170" data-brgyno="170"
                            onclick="viewResidentChart_Table(this)">Barangay 170</a></li>
                <li> <a class="dropdown-item" id="barangay178" data-brgyno="178"
                            onclick="viewResidentChart_Table(this)">Barangay 178</a></li>
             </ul>
            </li>



          </ul>
        </div>
      </div>
    </nav>




 <!-- VIEW RESIDENT CHART AND TABLE -->
    <div class="card" style="width: 75rem; padding-left:50px;">
    
        <ul class="list-group list-group-flush">
            <li class="list-group-item"> <div id="population_data"> </div></li>
            <li class="list-group-item">

            <div class="container">
                    <div class="row justify-content-center">
                        <!-- VIEW Population by Gender -->
                        <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title">Population by Gender</h5>
                            <hr>
                            <canvas id="myChart" width="300" height="300"></canvas>
                        </div>
                        </div>
                            <!-- VIEW B.M.I Age 20 above -->
                        <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title">B.M.I Age 20 above</h5>
                            <hr>
                            <canvas id="myChart2" width="300" height="300"></canvas>
                        </div>
                        </div>
                             <!-- VIEW Employed Above 26 -->
                        <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <h5 class="card-title">Employed Above 26</h5>
                            <hr>
                            <canvas id="myChart3" width="300" height="300"></canvas>
                        </div>
                        </div>
                    </div>

                    
            </div>
            </li>

            
            <li class="list-group-item">
            <div style="width: 90%; margin: 0 auto; overflow-x: auto;">
                <table id="resident-tables" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Height</th>
                            <th scope="col">Weight</th>
                            <th scope="col">B.M.I</th>
                            <th scope="col">Category</th>
                            <th scope="col">Edit Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            </li>
        </ul>
</div>



<!-- Custom JS  -->  
<script src="..\javascript\population.js"></script>  

</div>    
</Body>