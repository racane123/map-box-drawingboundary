<?php
session_start();
function is_user_logged_in() {

  return isset($_SESSION['email']);
}

if (!is_user_logged_in()) {
  header("Location: login.php"); // Change 'login.php' to your actual login page
  exit();
}
  
?>

  <style>
    
    body { margin: 0; padding: 0; }
    #map {position:absolute;top: 55px; bottom: 0; width: 100%; }
    .filter-form { position: absolute; background: white; padding: 10px; }
    .contain { display: flex; justify-content: flex-end; width: 100%; }
    #search-form {top:20px; width: 300px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); }
    .card-sad{
      position: absolute;
    }
  </style>

<body>
<?php
include 'header.php';
include "navbar.php";

?>
    <div id="map"></div>
<!--<div class="contain">
<div class="filter-form">
  <h3>Filter Options</h3>
  <form id="filterForm">
    <select id="filterOptions" onchange="filterMarkers()">
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
  </form>
</div>
</div>-->
<div class="contain">
    <form id="search-form" class="input-group rounded">
      <input type="text" id="search-input" placeholder="Enter search query" class="form-control rounded" arial-label="Search" aria-describedby="search-addon" >
      <button type="submit" class="border-0"><span class="input-group-text border-0" id="search-addon"><i class="fas fa-search"></i></span></button>
    </form>
</div>
<div class="card-sad">
<div id="feature-card">   
</div>
</div>

<script>

mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
    var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/light-v10',
      center: [121.04207,14.75782],
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
    }
  );
  
  fetch('polyapi.php')
  .then(response => response.json())
  .then(data => {
    map.addSource('features', {
      type: 'geojson',
      data: data
    });
    // Point Customization
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
        'icon-size': [
          'interpolate',
          ['linear'],
          ['zoom'],
          10, 0, // icon size is 0 at zoom level 10
          15, 0.10 // icon size is 1 at zoom level 15
        ],
        'text-field': [
          'case',
          ['==', ['get', 'title'], 'none'], '', // If title is none, show empty string
          ['get', 'name'] // Otherwise, show name
        ],
        'text-size': [
          'interpolate',
          ['linear'],
          ['zoom'],
          10, 0, // text size is 0 at zoom level 10
          15, 12 // text size is 12 at zoom level 15
        ],
        'text-offset': [0, 1.5],
        'text-allow-overlap': false,
      },
      paint: {
        'text-color': '#000000'
      },
    });


    function updateCard(properties) {
    // Select the card element
    var card = document.getElementById('feature-card');

    // Clear previous content
    card.innerHTML = '';

    // Create elements to display the feature properties
    var title = document.createElement('h3');
    title.textContent = properties.name;

    var address = document.createElement('p');
    address.textContent = properties.title;

    // Append elements to the card
    card.appendChild(title);
    card.appendChild(address);
    }

    map.on('click', 'mergedLayer', function (e) {
    // Get the properties of the clicked feature
    var featureProperties = e.features[0].properties;
      console.log(featureProperties)
    // Update the card content with the feature properties
    updateCard(featureProperties);
    });

            // Change the cursor to a pointer when the mouse is over the mergedLayer
      map.on('mouseenter', 'mergedLayer', function () {
        map.getCanvas().style.cursor = 'pointer';
      });

            // Change it back to a pointer when it leaves.
      map.on('mouseleave', 'mergedLayer', function () {
      map.getCanvas().style.cursor = '';
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
        fetch('search.php?query=' + query)
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
// Function to fetch marker data from polyapi.php
function fetchMarkerData(callback) {
  fetch('polyapi.php')
    .then(response => response.json())
    .then(data => callback(data))
    .catch(error => console.error('Error fetching marker data:', error));
}

// Function to filter markers based on selected category
function filterMarkers() {
  var category = document.getElementById('filterOptions').value;
  fetchMarkerData(function(data) {
    
    // Check if the layer already exists and remove it if it does
    if (map.getLayer('mergedLayer')) {
      map.removeLayer('mergedLayer');
    }
    // Check if the source already exists and remove it if it does
    if (map.getSource('features')) {
      map.removeSource('features');
    }


    // Filter features based on category
    var filteredFeatures = data.features.filter(function(feature) {
      return category === 'all' || feature.properties.title === category;
    });

    // Add filtered features to the map
    map.addSource('features', {
      type: 'geojson',
      data: {
        type: 'FeatureCollection',
        features: filteredFeatures
      }
    });

    // Add layer to the map
    map.addLayer({
      id: 'mergedLayer',
      type: 'symbol',
      source: 'features',
      layout: {
        'icon-image': ['concat', ['get', 'title'], '-icon'],
        'icon-size': [
          'interpolate',
          ['linear'],
          ['zoom'],
          10, 0, // icon size is 0 at zoom level 10
          15, 0.08
        ],
        'text-field': ['get', 'name'],
        'text-size': [
          'interpolate',
          ['linear'],
          ['zoom'],
          10,
          0,
          15,
          12
        ],
        'text-offset': [0, 1.5],
        'text-allow-overlap': false
      },
      paint: {
        'text-color': '#000000'
      }
    });
  });
}
</script>
</body>
