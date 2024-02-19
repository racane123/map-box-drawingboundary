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






<!-- ADD RESIDENT Modal -->
<div class="modal" id="myModals">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ADD RESIDENT</h4>
      </div>
      
     <!-- Modal Body -->
<div class="modal-body">
  <form>
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name">
    </div>
    <div class="form-group">
      <label for="age">Age:</label>
      <input type="text" class="form-control" id="age">
    </div>
    <div class="form-group">
      <label for="gender">Gender:</label>
      <select class="form-control" id="gender">
          <option value="male">Male</option>
          <option value="female">Female</option>
      </select>
  </div>
    <div class="form-group">
      <label for="height">Height:Centimeters</label>
      <input type="text" class="form-control" id="height">
    </div>
    <div class="form-group">
      <label for="weight">Weight:Kilograms</label>
      <input type="text" class="form-control" id="weight">
    </div>

    <input type="hidden" id="feature_id_input">
    <!-- Hidden input field for storing barangay_no -->
    <input type="hidden" id="barangay_no_input">
  </form>
</div>
      
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" onclick="removeViewRes()">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveButton" onclick="saveinfotodb()" >Save</button>
      </div>
      
    </div>
  </div>
</div>


<!-- view RESIDENT Modal -->
<div class="modal" id="viewresident">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">RESIDENTS</h4>
      </div>
      
     <!-- Modal Body -->
<div class="modal-body">
          <div style="width: 90%; margin: 0 auto; overflow-x: auto;">
            <table id="resident-tables" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Height</th>
                        <th scope="col">Weight</th>
                      
                        <th scope="col">Edit Info</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
          </div>
</div>
      
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" onclick="removeViewRes()">Back</button>
  
      </div>
      
    </div>
  </div>
</div>


<!-- Edit RESIDENT info -->
<div class="modal fade" id="editinfo" tabindex="-1" role="dialog" aria-labelledby="editinfoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editinfoLabel">Edit Resident Information</h5>
      </div>
      <div class="modal-body">
        <form id="editResidentForm">
        <input type="hidden" id="editResidentID" name="residentID">
          <div class="form-group">
            <label for="editName">Name</label>
            <input type="text" class="form-control" id="editName" name="name">
          </div>
          <div class="form-group">
            <label for="editAge">Age</label>
            <input type="text" class="form-control" id="editAge" name="age">
          </div>
          <div class="form-group">
           <label for="gender">Gender:</label>
           <select class="form-control" id="editGender" name="gender">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
           </select>
         </div>
          <div class="form-group">
            <label for="editHeight">Height</label>
            <input type="text" class="form-control" id="editHeight" name="height">
          </div>
          <div class="form-group">
            <label for="editWeight">Weight</label>
            <input type="text" class="form-control" id="editWeight" name="weight">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" onclick="removeViewRes()">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveResidentChanges()">Save changes</button>
      </div>
    </div>
  </div>
</div>





<!-- view MORE SHOP INFO Modal -->
<div class="modal" id="viewMoreShopInfo">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">SHOP INFO</h4>
      </div>
     <!-- Modal Body -->
<div class="modal-body">
          <div style="width: 90%; margin: 0 auto; overflow-x: auto;">
            <table id="shopinfo-tables" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Owner Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Business Permit</th>
                        <th scope="col">Edit Info</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
          </div>
</div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelViewMoreShopInfo" onclick="removeViewRes()">Back</button>
      </div>
    </div>
  </div>
</div>


<!-- ADD MORE SHOP INFO Modal -->
<div class="modal" id="addShopInfo">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ADD SHOP INFO</h4>
      </div>
      
     <!-- Modal Body -->
<div class="modal-body">
  <form>
    <div class="form-group">
      <label for="name">Owner Name</label>
      <input type="text" class="form-control" id="O_name">
    </div>
    <div class="form-group">
      <label for="age">Age:</label>
      <input type="text" class="form-control" id="O_age">
    </div>
    <div class="form-group">
      <label for="gender">Gender:</label>
      <select class="form-control" id="O_gender">
          <option value="male">Male</option>
          <option value="female">Female</option>
      </select>
  </div>
    
    <div class="form-group">
      <label for="file">Upload Permit</label>
      <input type="file" class="form-control-file" id="O_permit" name="file">
  </div>

    <input type="hidden" id="shop_barangayNo">
    <input type="hidden" id="shop_featureID">
  </form>
</div>
      
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceladdShopInfo">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveButton" onclick="saveShopInfotodb()" >Save</button>
      </div>
      
    </div>
  </div>
</div>



<!-- Toast  -->
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
   
    <div class="toast-body">

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