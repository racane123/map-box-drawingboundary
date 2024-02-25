<!DOCTYPE html>
<html lang="en">

<body>

   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!--navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            

          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Chloropleth
              </a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item"  onclick="turnOnChloropleth()">Turn on Chloropleth</a></li>
              <li><a class="dropdown-item"  onclick="turnOffChloropleth()">Turn off Chloropleth</a></li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Filter
              </a>
              <ul class="dropdown-menu" >  
              <li><a class="dropdown-item" id="getallfeature"  >All</a></li>
              <li><a class="dropdown-item" id="Residential"  >Residential</a></li>
              <li><a class="dropdown-item" id="School"  >School</a></li>
              <li><a class="dropdown-item" id="Church"  >Church</a></li>
              <li><a class="dropdown-item" id="Police Station"  >Police Station</a></li>
              <li><a class="dropdown-item" id="Barangay Station"  >Barangay Station</a></li>
              <li><a class="dropdown-item" id="Clinic"  >Clinic</a></li>
              <li><a class="dropdown-item" id="Karinderya"  >Karinderya</a></li>
              <li><a class="dropdown-item" id="BarberShop"  >BarberShop</a></li>
              <li><a class="dropdown-item" id="MilkTea Shop"  >MilkTea Shop</a></li>
              <li><a class="dropdown-item" id="Repair Shop"  >Repair Shop</a></li>
              <li><a class="dropdown-item" id="Empty Lot"  >Empty Lot</a></li>
              <li><a class="dropdown-item" id="Playground"  >Playground</a></li>
              <li><a class="dropdown-item" id="Boundary"  >Boundary</a></li>
              <li><a class="dropdown-item" id="Evacuation Area"  >Evacuation Area</a></li> 
            </ul>
      
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Map Div-->
    <div class="map" id="map"></div>
    
    <?php
 include ('brgyChart_Table.php');
 ?>

    <!--start modify feature confirmation Modal -->
    <div class="modal fade" id="confirmModal">
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
                 
                 
                  <p class="card-text"><i class="fa-solid fa-location-dot fa-2x "></i></p>
                  <a onclick="startDraw('Point')" class="card-link">Add Point</a>
                
                </div>
              </div>
            </div>

            <div class="col-4">
              <div class="card">
                <div class="card-body">
               
                 
                  <p class="card-text"><i class="fa-solid fa-road fa-2x"></i></p>
                  <a onclick="startDraw('LineString')" class="card-link">Add Line</a>
                
                </div>
              </div>
            </div>

            <div class="col-4">
              <div class="card">
                <div class="card-body">
             
                 
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

      

  











  
    </div><!-- /.container-fluid -->


  <!--boostrap   js-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>


  <!--Custom JS-->
  <script src="..\javascript\main.js"></script>
 

</body>
</html>