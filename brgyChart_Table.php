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
      <label for="Occupation">Has Occupation:</label>
      <select class="form-control" id="Occupation">
          <option value="yes">Yes</option>
          <option value="no">No</option>
         
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
      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" onclick="removeViewRes()">Close</button>
  
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveResidentChanges()">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- Edit delete resident info -->
<div class="modal fade" id="deleteinfo" tabindex="-1" role="dialog" aria-labelledby="deleteinfoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
      <h5 class="modal-title" id="deleteinfoLabel">Deleting Resident, are you sure?..</h5>
        <form id="deleteinfoForm">
        <input type="hidden" id="deleteResidentID" name="ResidentID">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" onclick="removeViewRes()">Close</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="deleteResident()">Delete Resident</button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelViewMoreShopInfo">Back</button>
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
      <label for="file">Upload Permit (PDF only)</label>
      <input type="file" class="form-control-file" id="O_permit" name="file" accept="application/pdf">
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




<!-- Edit deleteOwner info -->
<div class="modal fade" id="deleteOwner" tabindex="-1" role="dialog" aria-labelledby="deleteOwnerLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
      </div>
      <div class="modal-body">
      <h5 class="modal-title" id="deleteOwnerLabel">Deleting Shop Owner are you sure?..</h5>
        <form id="deleteOwnerForm">
        <input type="hidden" id="deleteOwnerID" name="OwnerID">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel">Close</button>
        <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="deleteOwner()">Delete Owner</button>
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


<!-- Custom JS  -->  
<script src="..\javascript\population.js"></script>  








