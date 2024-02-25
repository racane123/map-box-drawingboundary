<?php
include ('../db/dbconn.php');

?>
<style>
.parent-alert {
    position: relative;
}

#customAlert {
    position: absolute;
    right: 20px; 
    top: 10%; 
    transform: translateY(50%); 
    z-index: 1000; 
}
</style>
<body>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

  <!--navbar-->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
      <h2>  </h2>
      </div>
  </nav>
  <!--navbar-->






<div class="parent-alert">
    <div id="customAlert" class="alert" role="alert" style="display: none;position:absolute;">
    </div>
</div>
<form id="drawingForm" style="display:none;">
  <input type="hidden" id="featureId" name="id">
  <div class="mb-3">
    <label for="saveName" class="form-label">Name:</label>
    <input type="text" class="form-control" id="saveName" name="name" required>
  </div>
  <div class="mb-3">
    <label for="title" class="form-label">Title:</label>
    <select class="form-control" id="title" name="title">
      <option value="bakeshop">Bake shop</option>
      <option value="barbershop">Barbershop</option>
      <option value="cafe">Cafe/Restaurant</option>
      <option value="hospital">Hospital</option>
      <option value="police_station">Police Station</option>
      <option value="fire_station">Fire Station</option>
      <option value="bank">Bank</option>
      <option value="supermarket">Super Market</option>
      <option value="government">Government</option>
      <option value="none">None</option>
    </select>
  </div>
  <div class="text-center">
    <button type="submit" class="btn btn-primary">Confirm</button>
    <button type="button" class="btn btn-secondary" onclick="cancelDrawing()">Cancel</button>
  </div>
</form>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><strong>Geo-Data</strong></h3>
    <div class="card-tools">
      <div class="input-group input-group-sm" style="width: 150px;">
        <div class="input-group-append">
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body table-responsive p-0" style="height: 300px;">
    <table class="table table-head-fixed text-nowrap">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Title</th>
          <th>Feature Type</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="featureTableBody">
      </tbody>
    </table>
  </div>
</div>



</div><!-- /.container-fluid -->


</body>

<script>
$(document).ready(function(){
  // Fetch data from PHP script and render table
  $.ajax({
    url: '../api/polyapi.php',
    dataType: 'json',
    success: function(data){
      $.each(data.features, function(index, feature){
        var row = '<tr><td>' + feature.properties.id + '</td><td>' + feature.properties.name + '</td><td>' + feature.properties.title + '</td><td>' + feature.geometry.type + '</td>';
        row += '<td><button class="btn btn-primary btn-sm mr-1 update-btn" data-id="' + feature.properties.id + '">Edit</button><button class="btn btn-danger btn-sm delete-btn" data-id="' + feature.properties.id + '">Delete</button></td></tr>';
        $('#featureTableBody').append(row);
      });
    }
  });
});

// Update button click event
$(document).on('click', '.update-btn', function(){
  var id = $(this).data('id');
  
  // Fetch data for the selected feature
  $.ajax({
    url: '../fetch_feature.php',
    type: 'POST',
    dataType: 'json',
    data: {id: id},
    success: function(feature){
      // Populate form fields with fetched data
      $('#featureId').val(feature.id);
      $('#saveName').val(feature.name);
      $('#title').val(feature.title);

      // Hide only the row corresponding to the clicked update button
      $(this).closest('tr').hide(); // Add this line

      // Show form
      $('#drawingForm').show();
    },
    error: function(xhr, status, error){
      alert('Error: ' + error);
    }
  });
});

// Form submission event
$('#drawingForm').submit(function(event){
  event.preventDefault();

  // Serialize form data
  var formData = $(this).serialize();

  // AJAX call to update_data.php
  $.ajax({
    url: '../update_data.php',
    type: 'POST',
    dataType: 'json',
    data: formData,
    success: function(response){
      if (response.success) {
        $('#customAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
        setTimeout(function(){
          $('#customAlert').hide();
          location.reload(); // Refresh page to reflect changes
        }, 3000); // Hide after 3 seconds
      } else {
        $('#customAlert').removeClass('alert-success').addClass('alert-danger').text(response.message).show();
      }
    },
    error: function(xhr, status, error){
      $('#customAlert').removeClass('alert-success').addClass('alert-danger').text('Error: ' + error).show();
    }
  });
});

// Cancel button click event
function cancelDrawing() {
  $('#featureTableBody').show();
  $('#drawingForm').hide();
}

// Delete button click event
$(document).on('click', '.delete-btn', function(){
  var id = $(this).data('id');
  
  // Confirm with the user before deleting
  if(confirm('Are you sure you want to delete this item?')) {
    $.ajax({
      url: '../delete_data.php',
      type: 'POST',
      dataType: 'json',
      data: {id: id},
      success: function(response){
        if (response.success) {
          $('#customAlert').removeClass('alert-danger').addClass('alert-success').text(response.message).show();
          setTimeout(function(){
            $('#customAlert').hide();
          }, 3000); // Hide after 3 seconds
        } else {
          $('#customAlert').removeClass('alert-success').addClass('alert-danger').text(response.message).show();
        }
      },
      error: function(xhr, status, error){
        $('#customAlert').removeClass('alert-success').addClass('alert-danger').text('Error: ' + error).show();
      }
    });
  }
});
</script>
