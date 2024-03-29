<!DOCTYPE html>
<html lang="en">

<body>


 <?php
 
 include 'brgyChart_Table.php';
 ?> 


    <!--navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="">TownTechInnovations</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#"></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Barangay No.
              </a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item" id="barangay179"  data-brgyno="179" onclick="viewResidentChart_Table(this)">Barangay 179</a></li>
              <li><a class="dropdown-item" id="barangay170"  data-brgyno="170" onclick="viewResidentChart_Table(this)">Barangay 170</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Filter
              </a>
              <ul class="dropdown-menu">  
                <select id="featureType" class="form-select form-select-sm">
                <option value="all">All Features</option>
                <option value="Residential">Residential</option>
                <option value="School">School</option>
                <option value="Church">Church</option>
                <option value="Police Station">Police Station</option>
                <option value="Barangay Station">Barangay Station</option>
                <option value="Clinic">Clinic</option>
                <option value="Karinderya">Karinderya</option>
                <option value="BarberShop">BarberShop</option>
                <option value="MilkTea Shop">MilkTea Shop</option>           
                <option value="Repair Shop">Repair Shop</option>
                <option value="Empty Lot">Empty Lot</option>
                <option value="Playground">Playground</option>
                <option value="Evacuation Area">Evacuation Area</option>
                <option value="Boundary">Boundary</option>
                </select>
              </ul>
      
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Map Div-->
    <div class="map" id="map"></div>
    


<!--start modify feature confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modifying Points - Lines - Polygons</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       ARE YOU SURE?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearEditSource()">NO</button>
        <button type="button" class="btn btn-primary" onclick="startedit()">YES</button>
      </div>
    </div>
  </div>
</div>
   <!--end modify feature confirmation Modal -->

   <!--start save update modify feature confirmation Modal -->

<div class="modal fade" id="confirmFeatureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">SAVING MODIFIED Points - Lines - Polygons</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       ARE YOU SURE?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearEditSource()">NO</button>
        <button type="button" class="btn btn-primary" id="refreshButton2" onclick="saveModitodb()">YES</button>
      </div>
    </div>
  </div>
</div>
   <!--end save update modify feature confirmation Modal -->

   <!--begin: start draw Modal -->

<div class="modal fade" id="startdrawModal" tabindex="-1" aria-labelledby="startdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="startdrawModalLabel">Select Draw Type</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="text-align: center;">
        <!--cards-->

    <div class="row">

        <div class="col-4">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Point</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">POLE,SIGNS,TREE etc..</h6>
              <p class="card-text"><i class="fa-solid fa-location-dot fa-2x "></i></p>
              <a onclick="startDraw('Point')" class="card-link">Add Point</a>
            
            </div>
          </div>
        </div>

        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Line</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Road,River,Sapa etc</h6>
              <p class="card-text"><i class="fa-solid fa-road fa-2x"></i></p>
              <a onclick="startDraw('LineString')" class="card-link">Add Line</a>
             
            </div>
          </div>
        </div>

        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Polygon</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Building,Empty Lot etc..</h6>
              <p class="card-text"><i class="fa-solid fa-draw-polygon fa-2x"></i></p>
              <a onclick="startDraw('Polygon')" class="card-link">Add Polygon</a>
              
            </div>
          </div>
        </div>

    </div>


        </div>
        
      </div>
    </div>
  </div>
   <!--end: start draw Modal -->




  <div class="modal fade" id="enterInformationModal" tabindex="-1" aria-labelledby="enterInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="enterInformationModalLabel">Enter Feature's Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <div class="modal-body" style="text-align: center;">
          <!-- Type of Feature selection -->
          <div class="form-group">
            <label for="typeoffeatures">TYPE OF FEATURE</label>
            <select class="form-control" id="typeoffeatures">
            </select>
          </div>
          <!-- Name and Address fields -->

          <form id="newDrawn">
          <div class="form-group">
          
            <label for="exampleInputtext1">NAME</label>
            <input type="text" class="form-control" id="exampleInputtext1" name="name" aria-describedby="textHelp">
            <!-- <small id="textHelp" class="form-text text-muted">Address, Name, etc.</small>-->
            </div>
            <div class="form-group">
            <!-- BARANGAY -->
            <label for="exampleInputtext2">BARANGAY NUMBER</label>
            <input type="text" class="form-control" id="exampleInputtext2" name="barangayNo" aria-describedby="textHelp">
            </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearDrawSource()">Close</button>
          <button type="button" class="btn btn-primary" id="refreshButton" onclick="savetodb()">Save Feature</button>
        </div>
      </div>
    </div>
</div>


  <!--boostrap js-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  
  <!--Custom JS-->
  <script src="..\custom\js\main.js"></script>
 
  

</body>
</html>