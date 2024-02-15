<?php
include '../includes/header.php';


?>

<div id="map-container mt-5">
  <div id="map"></div>
  <div class="form-container">
  <form id="point-form">
  <div class="mb-3">
    <label for="title" class="form-label">Title:</label>
       <select name="title" id="title" class="form-select">
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
     <div class="mb-3">
       <label for="saveName" class="form-label">Name:</label>
       <input type="text" class="form-control" id="saveName" name="saveName" required>
     </div>
     <div class="text-center">
       <button type="submit" class="btn btn-primary">Save</button>
       <button type="button" class="btn btn-secondary" onclick="cancelDrawing()">Cancel</button>
     </div>
  </form>

  <form id="line-form">
      <label for="">Title:</label>
        <select name="title" id="title" class="form-select">
           <option value="bakeshop">street</option>
           <option value="rivers">River</option>
           <option value="none">None</option>
         </select>
    <div class="mb-3">
       <label for="saveName" class="form-label">Name:</label>
       <input type="text" class="form-control" id="saveName" name="saveName" required>
     </div>
     <div class="text-center">
       <button type="submit" class="btn btn-primary">Save</button>
       <button type="button" class="btn btn-secondary" onclick="cancelDrawing()">Cancel</button>
     </div>
  </form>
  <form id="polygon-form">
      <label for="">Title:</label>
        <select name="title" id="title" class="form-select">
          <option value="building">Building</option>
          <option value="openlot">Open Lot</option>
          <option value="residential_area">Residential Area</option>
          <option value="commercial_area">Commercial Area</option>
          <option value="none">None</option>
        </select>
      <div class="mb-3">
      <label for="saveName" class="form-label">Name:</label>
       <input type="text" class="form-control" id="saveName" name="saveName" required>
      </div>
      <input type="hidden" id="polygon-geojson" name="polygon-geojson">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</div>
