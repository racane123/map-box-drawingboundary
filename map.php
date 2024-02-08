<?php
include 'header.php';


?>

<div id="map-container mt-5">
      <div id="map"></div>
      <div class="container mt-5">
        <div id="saveForm">
        <h3>Save Drawing</h3>
      <form id="drawingForm">
        <div class="mb-3">
          <select name="title" id="">
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
        <label for="saveName" class="form-label">Name:</label>
        <input type="text" class="form-control" id="saveName" name="saveName" required>
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" onclick="cancelDrawing()">Cancel</button>
      </div>
    </form>
  </div>
</div>
    </div>
