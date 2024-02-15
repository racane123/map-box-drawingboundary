<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Group 68</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 120px; bottom: 55px;right:1px; width: 100%; }
        #saveForm {
        display: none;
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 10px;
        z-index: 1;
        max-width: 90%;
        width: 300px;
        text-align: center;
        }

    @media (max-width: 768px) {
        #saveForm {
        width: 90%;
        }
    }  
    </style>

</head>
<body>

<?php
include '../includes/header.php';
include 'map.php';

?>
<script>
   
mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
var map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/satellite-streets-v11',
  center: [121.04207,14.75782],
  zoom: 16
});
var draw = new MapboxDraw({
  displayControlsDefault: false,
  controls: {
    point: true,
    line_string: true,
    polygon: true,
    trash: true
  }
});

map.addControl(draw);
var saveForm = document.getElementById('saveForm');
var drawingForm = document.getElementById('drawingForm');

map.on('draw.create', function (event) {
    showSaveForm();
    

    drawingForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var name = document.getElementById('saveName').value;
        var title = document.querySelector('select[name = "title"]').value;
        var featureType = event.features[0].geometry.type;
        var coordinates = JSON.stringify(event.features[0].geometry.coordinates);
        saveData(name, title, featureType, coordinates);
        hideSaveForm();
        location.reload();
    });
});

function saveData(name, title, featureType, coordinates) {
    var xhr = new XMLHttpRequest(); 
    var url = '../api/postapi.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };

    var data = 'name=' + encodeURIComponent(name) +
    '&title=' + encodeURIComponent(title) +
    '&featureType=' + encodeURIComponent(featureType) +
    '&coordinates=' + encodeURIComponent(coordinates);

    xhr.send(data);
}


map.on('load', function() {
  fetch('../api/polyapi.php')
    .then(response => response.json())
    .then(data => {
      map.addSource('features', {
        type: 'geojson',
        data: data,
      });

      map.addLayer({
        id: 'points',
        type: 'circle',
        source: 'features',
        paint: {
        'circle-radius': 6,
        'circle-color': 'red'
        },
        filter: ['==', '$type', 'Point']
    });

    map.addLayer({
        id: 'line',
        type: 'line',
        source: 'features',
        paint: {
        'line-color': 'blue',
        'line-width': 2
        },
        filter: ['==', '$type', 'LineString']
    });

    map.addLayer({
        id: 'polygons',
        type: 'fill',
        source: 'features',
        layout: {},
        paint: {
        'fill-color': 'green',
        'fill-opacity': 0.5
        },
        filter: ['==', '$type', 'Polygon']
    });
    

    // Add a popup when clicking on a feature
    map.on('click', 'points', function (e) {
    var coordinates = e.features[0].geometry.coordinates.slice();
    var name = e.features[0].properties.name;

    new mapboxgl.Popup()
        .setLngLat(coordinates)
        .setHTML('Name: ' + name)
        .addTo(map);
});

map.on('click', 'polygons', function (e) {
var name = e.features[0].properties.name;

// Calculate the centroid of the polygon
var centroid = turf.centroid(e.features[0].geometry);

new mapboxgl.Popup()
.setLngLat(centroid.geometry.coordinates)
.setHTML('Name: ' + name)
.addTo(map);
});

map.on('click', 'line', function (e) {
var coordinates = e.features[0].geometry.coordinates.slice();
var name = e.features[0].properties.name;

new mapboxgl.Popup()
    .setLngLat(coordinates)
    .setHTML('Name: ' + name)
    .addTo(map);
});


// Change the cursor to a pointer when hovering over the features layer
map.on('mouseenter', 'features', function () {
    map.getCanvas().style.cursor = 'pointer';
});

// Change it back to a pointer when it leaves
map.on('mouseleave', 'features', function () {
    map.getCanvas().style.cursor = '';
});
    })
    .catch(error => {
      console.error('Error:', error);
    });
});




function showSaveForm() {
  saveForm.style.display = 'block';
}

drawingForm.addEventListener('submit', function (e) {
  e.preventDefault();
  var features = draw.getAll();
  var name = document.getElementById('saveName').value;
  console.log('Saving features:', features, 'with name:', name);
  hideSaveForm();
});

function cancelDrawing() {
  draw.deleteAll();
  hideSaveForm();
}

function hideSaveForm() {
  saveForm.style.display = 'none';
}

</script>
</body>
</html>