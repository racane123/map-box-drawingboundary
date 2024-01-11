<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Interactive Map with Drawing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- Bootstrap CDN  -->
  
  <!-- Map Box CDN-->
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.js"></script>
  <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js'></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.css" type="text/css" />
  <link
  rel="stylesheet"
  href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.1/mapbox-gl-geocoder.css"
  type="text/css"
/>
  <?php
  include 'header.php';
  
  ?>
  
  <style>
    
    body { margin: 0; padding: 0; }
    #map {position:absolute;top: 56px; bottom: 0; width: 100%; }
    .mapboxgl-ctrl-group.mapboxgl-ctrl.mapboxgl-ctrl-group-active {
    }
    #saveForm {
      display: none;
      position: absolute;
      top: 10px;
      left: 10px;
      background: white;
      padding: 10px;
      z-index: 1;
    }
  </style>
</head>
<body>
<?php
include 'navbar.php';
?>
<?php
include 'map.php';
?>
  <div id="geocoder-container"></div>
  <script src="javascript/map.js"></script>
  <script src="javascript/navbar.js"></script>
</body>

</html>
