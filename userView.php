<?php

session_start();
function is_user_logged_in() {
  return isset($_SESSION['email']);
}

if (!is_user_logged_in()) {
  header("Location: ./auth/login.php");
  exit();
}
  

//include ('includes/template.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--fontawesome icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!---bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--OpenLayers CSS-->
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
    <!--OpenLayers JS-->
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <!--Custom CSS-->
    <link rel="stylesheet" href="custom\css\style.css">
 
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="assets\js\search_ol-ext.js"></script>
    <!--crop-->
    <script src="assets\js\crop_ol-ext.js"></script>
    <script src="assets\js\hays_ol-ext.js"></script>
    <!--control-->
    <!--<link rel="stylesheet" href="assets\css\control_ol-ext.css">-->
    <script src="assets\js\control_ol-ext.js"></script>
    <link rel="stylesheet" href="assets\css\search_ol-ext.css">
    <!--pop up-->
    <link rel="stylesheet" href="assets\css/ol-ext.css">
    <!--<script src="assets\js\ol-ext.js"></script>-->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!--chart js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


    

<title>GIS MAP</title>
<?php
include 'useViewChart_Table.php';
?>


</head>

<body>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="">TownTechInnovations</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Barangay Charts
              </a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item" id="barangay179"  data-brgyno="179" onclick="viewResidentChart_Table(this)">Barangay 179</a></li>
              <li><a class="dropdown-item" id="barangay171"  data-brgyno="171" onclick="viewResidentChart_Table(this)">Barangay 171</a></li>
              <li><a class="dropdown-item" id="barangay171"  data-brgyno="170" onclick="viewResidentChart_Table(this)">Barangay 170</a></li>
              <li><a class="dropdown-item" id="barangay171"  data-brgyno="178" onclick="viewResidentChart_Table(this)">Barangay 178</a></li>
              </ul>
            </li>
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
               Parcel Filter
              </a>
                  <ul class="dropdown-menu multi-column" >  
                  <li><a class="dropdown-item" id="getallfeatures"  >All</a></li>
                  <li><a class="dropdown-item" id="Residential"  >Residential</a></li>
                  <li><a class="dropdown-item" id="School"  >School</a></li>
                  <li><a class="dropdown-item" id="Church"  >Church</a></li>
                  <li><a class="dropdown-item" id="Police Station"  >Police Station</a></li>
                  <li><a class="dropdown-item" id="Barangay Station"  >Barangay Station</a></li>

                  <li><a class="dropdown-item" id="Chicken Meat Shop"  >Chicken Meat Shop</a></li>
                  <li><a class="dropdown-item" id="Gas Station"  >Gas Station</a></li>
                  <li><a class="dropdown-item" id="Pet Food Shop"  >Pet Food Shop</a></li>
                  <li><a class="dropdown-item" id="Convenience Store"  >Convenience Store</a></li>
                  <li><a class="dropdown-item" id="Grocery Store"  >Grocery Store</a></li>
                  <li><a class="dropdown-item" id="SariSari Store"  >SariSari Store</a></li>
                  <li><a class="dropdown-item" id="Pharmacy"  >Pharmacy</a></li>
                  <li><a class="dropdown-item" id="Market"  >Market</a></li>

                  <li><a class="dropdown-item" id="Clinic"  >Clinic</a></li>       
                  <li><a class="dropdown-item" id="Karinderya"  >Karinderya</a></li>
                  <li><a class="dropdown-item" id="BarberShop"  >BarberShop</a></li>
                  <li><a class="dropdown-item" id="MilkTea Shop"  >MilkTea Shop</a></li>
                  <li><a class="dropdown-item" id="Repair Shop"  >Repair Shop</a></li>
                  <li><a class="dropdown-item" id="Empty Lot"  >Empty Lot</a></li>
                  <li><a class="dropdown-item" id="Playground"  >Playground</a></li>
                 
                  <li><a class="dropdown-item" id="Evacuation Area"  >Evacuation Area</a></li>
                 
                </ul>
            </li>

        
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Point Filter
              </a>
              <ul class="dropdown-menu" >  
                <li><a class="dropdown-item" id="getallfeature"  >All</a></li>
                <li><a class="dropdown-item" id="Street Light"  >Street Light</a></li> 
                <li><a class="dropdown-item" id="Sign"  >Street Sign</a></li>
                <li><a class="dropdown-item" id="Tricycle Station"  >Tricycle Station</a></li>
                <li><a class="dropdown-item" id="Jeepney Station"  >Jeepney Station</a></li> 
                <li><a class="dropdown-item" id="Bus Station"  >Bus Station</a></li>  
             </ul>
            </li>


            <li>
            <a class="nav-link" href="index.php" role="button" aria-expanded="false">
               Other Map
              </a>
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


































  
  <!--boostrap   js-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

  
  

<script>
        // Activate dropdown toggle
        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();
        });
</script>


</body>



<!--Custom JS-->
<script>


// global variable
var featureLayer


var FlagisDrawingOn = false
var FlagisModifyOn = false
var FlagisDeleteOn = false

var PointType = ['Street Light','Tricycle Station','Jeepney Station','Bus Station','Signs','Tree']
var LineType = ['Street','Sapa','National Highway','StateHighway',]
var PolygonType = ['Residential','School','Church','Police Station','Barangay Station','Gas Station','Clinic','Karinderya','Basketball Court','Pharmacy','SariSari Store','Waiting Shed','Convenience Store','Grocery Store','Chicken Meat Shop','Pet Food Shop','Market','BarberShop','MilkTea Shop','Repair Shop','Empty Lot','Park','Boundary','Evacuation Area']
var selectedGeomType


//
// view
//
var cityCenter = [13473779.769599514, 1659650.641159134];
var radius = 8000; 
var extent = [
  cityCenter[0] - radius, 
  cityCenter[1] - radius, 
  cityCenter[0] + radius, 
  cityCenter[1] + radius
];

var myview = new ol.View({
  projection: 'EPSG:3857',
  zoom: 14,
  center: cityCenter,
  minZoom: 14,
  maxZoom: 20,
   extent: extent 
});


//
//osm layer
/*
var baselayer = new ol.layer.Tile({
    source : new ol.source.OSM({
        attributions:'GIS MPG'
    })
})*/
var accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
var baselayer = new ol.layer.Tile({
    source: new ol.source.XYZ({
        url: 'https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=' + accessToken,
        tileSize: 520,
        projection: 'EPSG:3857'
    })
});

//
// source para sa featurelayer
//
var featureLayerSource = new ol.source.Vector();

  fetch('apiFolder/api.php')
  .then(function (response) {
    return response.json();
  })
  .then(function (data) {
    // Parse the GeoJSON data and add features to the vector source
    var features = new ol.format.GeoJSON().readFeatures(data);  
    featureLayerSource.addFeatures(features);
  })
  .catch(function (error) {
    console.error('Error fetching and processing GeoJSON:', error);
  });


  var chloroplethLayerSource = new ol.source.Vector();
 
  function turnOnChloropleth(){
  chloroplethLayerSource.clear(); 
  fetch('apiFolder/chloropleth.php')
  .then(function (response) {
    return response.json();
  })
  .then(function (data) {
    // Parse the GeoJSON data and add features to the vector source
    var features = new ol.format.GeoJSON().readFeatures(data);  
    chloroplethLayerSource.addFeatures(features);
  })
  .catch(function (error) {
    console.error('Error fetching and processing GeoJSON:', error);
  });
  }

 function turnOffChloropleth(){
  chloroplethLayerSource.clear();
 }

// POLYGONS

function featureIdbyType(featureType){
  featureLayerSource.clear();
  fetch('apiFolder/api.php?type=' + featureType)
  .then(function (response) {
    return response.json();
  })
  .then(function (data) {
    // Parse the GeoJSON data and add features to the vector source
    var features = new ol.format.GeoJSON().readFeatures(data);
    featureLayerSource.addFeatures(features);
  })
  .catch(function (error) {
    console.error('Error fetching and processing GeoJSON:', error);
  });  
}

function getallfeature(){
  featureLayerSource.clear();
  fetch('apiFolder/api.php?')
  .then(function (response) {
    return response.json();
  })
  .then(function (data) {
    // Parse the GeoJSON data and add features to the vector source
    var features = new ol.format.GeoJSON().readFeatures(data);
    featureLayerSource.addFeatures(features);
  })
  .catch(function (error) {
    console.error('Error fetching and processing GeoJSON:', error);
  });  
}


document.getElementById('getallfeature').addEventListener('click',function(){ getallfeature() })
document.getElementById('getallfeatures').addEventListener('click',function(){ getallfeature() })
document.getElementById('Residential').addEventListener('click',function(){ featureIdbyType('Residential') })
document.getElementById('BarberShop').addEventListener('click',function(){ featureIdbyType('BarberShop') })
document.getElementById('School').addEventListener('click',function(){ featureIdbyType('School') })
document.getElementById('Church').addEventListener('click',function(){ featureIdbyType('Church') })
document.getElementById('Police Station').addEventListener('click',function(){ featureIdbyType('Police Station') })
document.getElementById('Barangay Station').addEventListener('click',function(){ featureIdbyType('Barangay Station') }) 
document.getElementById('Clinic').addEventListener('click',function(){ featureIdbyType('Clinic') }) 
document.getElementById('Karinderya').addEventListener('click',function(){ featureIdbyType('Karinderya') }) 
document.getElementById('MilkTea Shop').addEventListener('click',function(){ featureIdbyType('MilkTea Shop') }) 
document.getElementById('MilkTea Shop').addEventListener('click',function(){ featureIdbyType('SariSari Store') }) 
document.getElementById('MilkTea Shop').addEventListener('click',function(){ featureIdbyType('Market') }) 
document.getElementById('Repair Shop').addEventListener('click',function(){ featureIdbyType('Police Station') }) 
document.getElementById('Empty Lot').addEventListener('click',function(){ featureIdbyType('Empty Lot') }) 
document.getElementById('Playground').addEventListener('click',function(){ featureIdbyType('Playground') }) 
document.getElementById('Evacuation Area').addEventListener('click',function(){ featureIdbyType('Evacuation Area') })

document.getElementById('Chicken Meat Shop').addEventListener('click',function(){ featureIdbyType('Chicken Meat Shop') })
document.getElementById('Gas Station').addEventListener('click',function(){ featureIdbyType('Gas Station') })
document.getElementById('Pet Food Shop').addEventListener('click',function(){ featureIdbyType('Pet Food Shop') })
document.getElementById('Convenience Store').addEventListener('click',function(){ featureIdbyType('Convenience Store') })
document.getElementById('Grocery Store').addEventListener('click',function(){ featureIdbyType('Grocery Store') })
document.getElementById('SariSari Store').addEventListener('click',function(){ featureIdbyType('SariSari Store') })
document.getElementById('Pharmacy').addEventListener('click',function(){ featureIdbyType('Pharmacy') })
document.getElementById('Market').addEventListener('click',function(){ featureIdbyType('Market') })

//point filter
document.getElementById('Street Light').addEventListener('click',function(){ featureIdbyType('Street Light') })
document.getElementById('Sign').addEventListener('click',function(){ featureIdbyType('Signs') })
document.getElementById('Tricycle Station').addEventListener('click',function(){ featureIdbyType('Tricycle Station') })
document.getElementById('Jeepney Station').addEventListener('click',function(){ featureIdbyType('Jeepney Station') })
document.getElementById('Bus Station').addEventListener('click',function(){ featureIdbyType('Bus Station') })



document.getElementById("refreshButton").addEventListener("click", function() {
  // Call the refresh function when the button is clicked
  getallfeature();
 });
 document.getElementById("refreshButton2").addEventListener("click", function() {
  // Call the refresh function when the button is clicked
  getallfeature();
 });




var chloroplethLayer = new ol.layer.Vector({
  source: chloroplethLayerSource,
  style: function(feature){
    var styles = [];

      var name = feature.get('name'); // Get the name attribute of the feature
      var type = feature.get('type'); // Assuming 'type' is the attribute containing feature type
    
      var polygonCoordinates = feature.getGeometry().getCoordinates()[0]; // Get the coordinates of the polygon
      var centroid = calculateCentroid(polygonCoordinates); // Calculate centroid
    
      // Define a mapping between feature types and their respective icons
      var iconMap = { 
        'Boundary': 'assets/img/barangay.png', 
      };
    
      var iconPath = iconMap[type] || 'assets/img/default.png'; 
    
      styles.push(
        new ol.style.Style({
          fill: new ol.style.Fill({
            color: 'rgba(0, 128, 0, 0.2)',
          }),
          stroke: new ol.style.Stroke({
            color: 'green',
            width: 1,
          }),
        }),
        new ol.style.Style({
          geometry: new ol.geom.Point(centroid), // Assuming you have calculated centroid
          image: new ol.style.Icon({
            src: iconPath,
            width: 25, // Adjust width and height as needed
            height: 25,
          }),
        }),
        new ol.style.Style({
          geometry: new ol.geom.Point(centroid),
          text: new ol.style.Text({
            text: name,
            fill: new ol.style.Fill({
              color: 'black',
            }),
            stroke: new ol.style.Stroke({
              color: 'white',
              width: 3,
            }),
            offsetX: 0, 
            offsetY: 20, 
          }),
        })
      );
    


    return styles;
  }

})
 

//
// pag display ng mga feature sa map na may style depende kung point,linstring, or polygon
//


var featureLayer = new ol.layer.Vector({
  source: featureLayerSource,
  style: function (feature) {
    var geometry = feature.getGeometry().getType();
    var styles = [];

    if (geometry === 'Point') {
      var type = feature.get('type'); 
      
      // Define a mapping between feature types and their respective icons
      var iconMap = {
          'Street Light': 'assets/img/streetlight.png',
          'Signs': 'assets/img/streetsign.png',
          'Signs': 'assets/img/streetsign.png',
          'Tricycle Station': 'assets/img/tricycle.png',
          'Jeepney Station': 'assets/img/jeep.png',
          'Bus Station': 'assets/img/bus.png',
      };
  
  
      var iconPath = iconMap[type] || 'assets/img/default.png'; 
  
   
      var pointStyleIcon = new ol.style.Style({
          image: new ol.style.Icon({
              src: iconPath,
             
              scale: 0.4, 
              anchor: [0.67, 0.89]
          })
      })
      var pointStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 4,
            fill: new ol.style.Fill({
                color: 'red',
            }),
            stroke: new ol.style.Stroke({
                color: 'white',
                width: 2,
            }),
        }),
    });
      
     
  
     // Define min and max resolutions for visibility control
var minResolutionToShow = map.getView().getResolutionForZoom(20); // Maximum resolution for zoom level 20
var maxResolutionToShow = map.getView().getResolutionForZoom(17.5); // Minimum resolution for zoom level 17

// Add conditions for applying the style based on zoom level
if (map.getView().getResolution() >= minResolutionToShow &&
    map.getView().getResolution() <= maxResolutionToShow) {
    styles.push(pointStyle,pointStyleIcon);
}


  } else if (geometry === 'LineString') {
      var name = feature.get('name'); // Get the name attribute of the feature
      

       var linestyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'blue',
                width: 2,
            })
          })

       var linename = new ol.style.Style({
           text: new ol.style.Text({
                    text: name, // Specify the label text
                    font: '12px Calibri,sans-serif', // Set the font style
                    fill: new ol.style.Fill({ color: '#000' }), // Fill color of the label text
                    stroke: new ol.style.Stroke({
                        color: '#fff', // Stroke color of the label text
                        width: 2
                    }),
                    placement: 'line', // Place the label along the line
                    maxAngle: Math.PI / 4, // Maximum angle between the label and the line
                    overflow: true // Allow the label to overflow the line
                }),
        })

        var linegeometry = new ol.style.Style({
                geometry: function(feature) {
                  // Return the line geometry for label placement
                  return new ol.geom.LineString(feature.getGeometry().getCoordinates());
              }

        })
            
        
     // Define min and max resolutions for visibility control
var minResolutionToShow = map.getView().getResolutionForZoom(20); // Maximum resolution for zoom level 20
var maxResolutionToShow = map.getView().getResolutionForZoom(15.5); // Minimum resolution for zoom level 17

// Add conditions for applying the style based on zoom level
if (map.getView().getResolution() >= minResolutionToShow &&
    map.getView().getResolution() <= maxResolutionToShow) {
    styles.push(linestyle,linename,linegeometry);
}

  
    
} else if (geometry === 'Polygon') {
  var name = feature.get('name'); 
  var type = feature.get('type'); 
  var polygonCoordinates = feature.getGeometry().getCoordinates()[0]; 
  var centroid = calculateCentroid(polygonCoordinates);

  var polygonExtent = feature.getGeometry().getExtent();
  var polygonWidth = Math.abs(polygonExtent[0] - polygonExtent[2]);
  var polygonHeight = Math.abs(polygonExtent[1] - polygonExtent[3]);
  var maxSize = 30; 
  var sizeFactor = Math.min(polygonWidth, polygonHeight) / Math.max(polygonWidth, polygonHeight);
  var iconSize = Math.round(sizeFactor * maxSize);

  // Define a mapping between feature types and their respective icons
  var iconMap = {
    'Residential': 'assets/img/residential.png',
    'School': 'assets/img/school.png',
    'Church': 'assets/img/church.png',
    'Police Station': 'assets/img/policestation.png',
    'Barangay Station': 'assets/img/barangay.png',
    'Clinic': 'assets/img/clinic.png',
    'Karinderya': 'assets/img/karinderya.png',
    'BarberShop': 'assets/img/barbershop.png',
    'MilkTea Shop': 'assets/img/milkteashop.png',
    'Repair Shop': 'assets/img/repairshop.png',
    'SariSari Store': 'assets/img/karinderya.png',
    'Gas Station': 'assets/img/gas-station.png',
    'Market': 'assets/img/market.png',
    'Chicken Meat Shop': 'assets/img/chicken.png',
    'Pet Food Shop': 'assets/img/pet-shop.png',
    'Convenience Store': 'assets/img/convenience-store .png',
    'Grocery Store': 'assets/img/store.png',
    'Pharmacy': 'assets/img/pharmacy.png',
    'Waiting Shed': 'assets/img/waiting shed.png',
    'Basketball Court': 'assets/img/basketball-court.png',
    'Park': 'assets/img/park.png',
  };

  var iconPath = iconMap[type] || 'assets/img/default.png';

  styles.push(
    new ol.style.Style({
      fill: new ol.style.Fill({
        color: 'rgba(0, 128, 0, 0.2)',
      }),
      stroke: new ol.style.Stroke({
        color: 'green',
        width: 1,
      }),
    }),
    new ol.style.Style({
      geometry: new ol.geom.Point(centroid), 
      image: new ol.style.Icon({
        src: iconPath,
        scale: iconSize / 50,
      }),
    }),
    new ol.style.Style({
      geometry: new ol.geom.Point(centroid),
      text: new ol.style.Text({
        text: name,
        fill: new ol.style.Fill({
          color: 'black',
        }),
        stroke: new ol.style.Stroke({
          color: 'white',
          width: 1,
        }),
        font: '8px Arial', 
        offsetX: 0,
        offsetY: 13,
      }),
    })
    
  );
}

    
    return styles;
  },
  
});

// Function to calculate centroid of a polygon
function calculateCentroid(coordinates) {
  var totalX = 0;
  var totalY = 0;
  var totalPoints = coordinates.length;
  coordinates.forEach(function(point) {
    totalX += point[0];
    totalY += point[1];
  });
  var centroidX = totalX / totalPoints;
  var centroidY = totalY / totalPoints;
  return [centroidX, centroidY];
}
 
 // Popup overlay with popupClass=anim
 var popup = new ol.Overlay.Popup ({
  popupClass: "default anim", 
  closeBox: true,
  onclose: function(){ console.log("You close the box"); },
  positioning: 'auto',
  autoPan: {
    animation: {
      duration: 100
    }
  }
});


// vector source para sa edit features
var editSource = new ol.source.Vector()

fetch('apiFolder/api.php')
  .then(function (response) {
    return response.json();
  })
  .then(function (data) {
    // Parse the GeoJSON data and add features to the vector source
    var features = new ol.format.GeoJSON().readFeatures(data);
    editSource.addFeatures(features);
    
    // Zoom to the extent of the loaded features
   // map.getView().fit(featureLayerSource.getExtent());
  })
  .catch(function (error) {
    console.error('Error fetching and processing GeoJSON:', error);
  });


// Layer array
var layerArray = [baselayer,featureLayer,chloroplethLayer] 


//Map
var map = new ol.Map({
    controls: ol.control.defaults({
        attributionOptions: {
          collapsible: false
        }
      }),

    target:'map',
    view: myview,
    layers:layerArray,
    overlays: [popup]
  
})




// Control Select 
var select = new ol.interaction.Select({});
map.addInteraction(select);

// Set the control grid reference
var search = new ol.control.SearchFeature({
  //target: $(".options").get(0),
  source: featureLayerSource,
  //property: $(".options select").val(),
  sort: function(f1, f2) {
    if (search.getSearchString(f1) < search.getSearchString(f2)) return -1;
    if (search.getSearchString(f1) > search.getSearchString(f2)) return 1;
    return 0;
  }
});
map.addControl(search);

// Select feature when click on the reference index
search.on('select', function(e) {
  select.getFeatures().clear();
  select.getFeatures().push (e.search);
  var p = e.search.getGeometry().getFirstCoordinate();
  map.getView().animate({
     center:p ,
     zoom : 15,
     easing: ol.easing.easeOut
    });
});


select.getFeatures().on(['add'], function (e) {
  if (!FlagisDrawingOn) {
    var feature = e.element;
    var type = feature.get("type");
    var brgy_no = feature.get("barangay_no");

    if( type === 'Boundary'){
      var content = 
      '</br> <b> NAME </b>:' + feature.get("name") +
      '</br><b> BRGY </b>:' + feature.get("barangay_no");
    }else {
      var content = 
      '<b> TYPE </b>:' + feature.get("type") +
      '</br> <b> NAME </b>:' + feature.get("name") +
      '</br><b> BRGY </b>:' + feature.get("baranggay_no");
    }
         
    var geometryType = feature.getGeometry().getType();
    var coordinates;
    if (geometryType === 'Point') {
        coordinates = feature.getGeometry().getCoordinates();
    } else if (geometryType === 'LineString') {
        coordinates = ol.extent.getCenter(feature.getGeometry().getExtent());
    } else if (geometryType === 'Polygon') {
        coordinates = ol.extent.getCenter(feature.getGeometry().getExtent());
    }
    

popup.show(coordinates, content);

  }

});

// On deselected => hide popup
select.getFeatures().on(['remove'], function (e) {
  //featureLayer.clear(true);
  popup.hide();
});


               

    



   
    


















function viewResidentChart_Table(element){
  
     var brgyno = element.getAttribute("data-brgyno");
     console.log(brgyno)

     var ctx1 = document.getElementById('myChart').getContext('2d');
     var ctx2 = document.getElementById('myChart2').getContext('2d');
     var ctx3 = document.getElementById('myChart3').getContext('2d');
     ctx1.clearRect(0, 0, ctx1.canvas.width, ctx1.canvas.height);
     ctx2.clearRect(0, 0, ctx2.canvas.width, ctx2.canvas.height);
     ctx3.clearRect(0, 0, ctx3.canvas.width, ctx3.canvas.height);
     

     $.ajax({
     url: "apiFolder/brgy"+brgyno+"api.php",
     type: "GET",
     dataType: "json",
     success: function(data) {
         if (data.hasOwnProperty('error')) {
             $("#population_data").html("Error: " + data.error);
         } else {
             // Extract male_count and female_count
             var maleCount = data[0].male_count;
             var femaleCount = data[0].female_count;

             var underweightCount = data[0].underweight_count;
             var normalweightCount = data[0].normalweight_count;
             var overweightCount = data[0].overweight_count;
             var obesityCount = data[0].obesity_count;

             var Employed = data[0].employed_count;
             var UnEmployed = data[0].unemployed_count;
              
             // Display total number of residents
             $("#population_data").html(" Barangay " + brgyno + " Total residents: " + data[0].total_residents);
             

             // Use maleCount and femaleCount in Chart.js data
             var ctx1 = document.getElementById('myChart').getContext('2d');
             var myChart = new Chart(ctx1, {
                 type: 'bar',
                 data: {
                     labels: ['Male', 'Female'],
                     datasets: [{
                         label: 'Population by Gender',
                         data: [maleCount, femaleCount],
                         backgroundColor: [
                             'rgba(255, 99, 132, 0.2)',
                             'rgba(54, 162, 235, 0.2)',
                         ],
                         borderColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     scales: {
                         yAxes: [{
                             ticks: {
                                 suggestedMin: 0  // Set the suggested minimum to 0
                             }
                         }]
                     }
                 }
             });
             
             var ctx2 = document.getElementById('myChart2').getContext('2d');
             var chart = new Chart(ctx2, {
                type: 'bar',
             data: {
                    labels: ['Underweight', 'Normal weight','Overweight','Obesity'],
                    datasets: [{
                    label: 'Barangay' + brgyno + ' Population',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [underweightCount, normalweightCount,overweightCount, obesityCount]
                  }]
               },

             options: {
                 scales: {
                    yAxes: [{
                      ticks: {
                          suggestedMin: 0  // Set the suggested minimum to 0
                              }
                           }]
                         }
                    }
             });





             var ctx3 = document.getElementById('myChart3').getContext('2d');
             var chart = new Chart(ctx3, {
                type: 'bar',
             data: {
                    labels: ['Employed', 'UnEmployed'],
                    datasets: [{
                    label: 'Barangay' + brgyno + ' Population',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [Employed, UnEmployed]
                  }]
               },

             options: {
                 scales: {
                    yAxes: [{
                      ticks: {
                          suggestedMin: 0  // Set the suggested minimum to 0
                              }
                           }]
                         }
                    }
             });
             
         }
         

     },
     error: function(xhr, status, error) {
         console.error("Error:", error);
     }
 });
  
 $('#viewResidentChart_Table').modal('show');
 
}















</script>






</html>