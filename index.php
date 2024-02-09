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
    #map {position:absolute;top: 55px; bottom: 0; width: 100%; }
    .contain { display: flex; justify-content: flex-end; width: 100%; }
    #search-form {top:20px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); }
  </style>
</head>
<body>
<?php
include "header.php";
include "navbar.php";

?>
    <div id="map"></div>
    <div class="contain">
      <form id="search-form" class="input-group rounded">
         <input type="text" id="search-input" placeholder="Enter search query" class="form-control rounded" arial-label="Search" aria-describedby="search-addon" >
         <button type="submit" class="border-0"><span class="input-group-text border-0" id="search-addon"><i class="fas fa-search"></i></span></button>
       </form>
    </div> 
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/light-v10',
      center: [120.96788000, 14.64953000],
      zoom: 16
    });

    map.on('load', function () {
    map.loadImage(
    'images/hospital.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('hospital-icon', image);
    }
  );

  map.loadImage(
    'images/bakery.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('bakery-icon', image);
    }
  );

  map.loadImage(
    'images/cafe.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('cafe-icon', image);
    }
  );

  map.loadImage(
    'images/barber-shop.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('barbershop-icon', image);
    }
  );

  map.loadImage(
    'images/police-station.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('police-icon', image);
    }
  );

  map.loadImage(
    'images/fire-station.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('fire-icon', image);
    }
  );

  map.loadImage(
    'images/bank.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('bank-icon', image);
    }
  );
  map.loadImage(
    'images/grocery-cart.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('supermarket-icon', image);
    }
  );
  map.loadImage(
    'images/government.png',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('government-icon', image);
    }
  );

  map.loadImage(
    'https://placekitten.com/50/40',
    (error, image) => {
      if (error) {
        console.error(error);
      }
      map.addImage('default-icon', image);
    }
  );

  fetch('polyapi.php')
    .then(response => response.json())
    .then(data => {
      console.log(data);
      map.addSource('features', {
        type: 'geojson',
        data: data
      });

      // Point Cutomization
      map.addLayer({
        id: 'mergedLayer',
        type: 'symbol',
        source: 'features',
        layout: {
          'icon-image': [
            'match',
            ['get', 'title'],
            'hospital', 'hospital-icon',
            'cafe', 'cafe-icon',
            'bakeshop', 'bakery-icon',
            'barbershop', 'barbershop-icon',
            'police_station', 'police-icon',
            'fire_station', 'fire-icon',
            'bank', 'bank-icon',
            'supermarket', 'supermarket-icon',
            'government', 'government-icon',
            'default-icon'
          ],
          'icon-size':[
            'interpolate',
            ['linear'],
            ['zoom'],
            10, 0, // icon size is 0 at zoom level 10
            15, 0.10 // icon size is 1 at zoom level 15
          ],
          'text-field': ['get', 'name'],
          'text-size': [
            'interpolate',
            ['linear'],
            ['zoom'],
            10, 0, // text size is 0 at zoom level 10
            15, 12 // corrected, removed the trailing comma here
          ],
          'text-offset': [0, 1.5],
          'text-allow-overlap': false,
        },
        paint: {
          'text-color': '#000000'
        },
      });

    })
    .catch(error => {
      console.error('Error:', error);
    });
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
