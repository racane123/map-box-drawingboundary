<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Interactive Map with Drawing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <!-- Bootstrap CDN  -->
  
  <!-- Map Box CDN-->
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.1.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.1.0/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.css" type="text/css" />
  <?php
  session_start();
 
  include 'header.php';
  
  ?>
  
  <style>
    
    body { margin: 0; padding: 0; }
    #map {position:absolute;top: 76px; bottom: 0; width: 100%; }
    #search-form{
      position:absolute;
      width:300px;
      left:750px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      top: 100px;
    }
  </style>
</head>
<body>
<?php
include "header.php";
include "navbar.php";

?>
    <div id="map"></div>
  <form id="search-form" class="input-group rounded">
    <input type="text" id="search-input" placeholder="Enter search query" class="form-control rounded" arial-label="Search" aria-describedby="search-addon" >
    <button type="submit" class="border-0"><span class="input-group-text border-0" id="search-addon"><i class="fas fa-search"></i></span></button>
  </form>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [120.96788000, 14.64953000],
      zoom: 16
    });

    map.on('load', function() {
      document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var query = document.getElementById('search-input').value;
        fetch('http://localhost/map-box-drawingboundary/search.php?query=' + query)
          .then(response => response.json())
          .then(data => {
            // Check if the source and layer already exist, and remove them if they do
            if (map.getLayer('search-results')) {
              map.removeLayer('search-results');
            }
            if (map.getLayer('result-polygon')) {
              map.removeLayer('result-polygon');
            }
            if (map.getSource('search-results')) {
              map.removeSource('search-results');
            }

            map.addSource('search-results', {
              type: 'geojson',
              data: data
            });

            

            // Add layer based on geometry type
            if (data.features.length > 0) {
              if (data.features[0].geometry.type === 'Polygon') {
                map.addLayer({
                  id: 'result-polygon',
                  type: 'fill',
                  source: 'search-results',
                  paint: {
                    'fill-color': '#007cbf',
                    'fill-opacity': 0.5
                  }
                });
                var centroid = turf.centroid(data.features[0]).geometry.coordinates;
                map.flyTo({
                  center: centroid,
                  zoom: 17,
                  essential: true
                });
                
                map.on('click', 'result-polygon', function (e) {
                  var name = e.features[0].properties.name;

                  // Calculate the centroid of the polygon
                  var centroid = turf.centroid(e.features[0].geometry);

                  new mapboxgl.Popup()
                  .setLngLat(centroid.geometry.coordinates)
                  .setHTML('Name: ' + name)
                  .addTo(map);
                  });
                
              } else if (data.features[0].geometry.type === 'Point') {
                map.addLayer({
                  id: 'search-results',
                  type: 'circle',
                  source: 'search-results',
                  paint: {
                    'circle-radius': 10,
                    'circle-color': '#007cbf'
                  }
                });
                map.flyTo({
                  center: data.features[0].geometry.coordinates,
                  zoom: 17,
                  essential: true
                });
                map.on('click', 'search-results', function (e) {
                  var coordinates = e.features[0].geometry.coordinates.slice();
                  var name = e.features[0].properties.name;

                  new mapboxgl.Popup()
                      .setLngLat(coordinates)
                      .setHTML('Name: ' + name)
                      .addTo(map);
                  });
              }
            }
            
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing your request. Please try again later.');
          });
      });
    });
</script>
</body>

</html>
