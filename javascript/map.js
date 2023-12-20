
mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';
var map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v11',
  center: [-74.5, 40],
  zoom: 13
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
        var featureType = event.features[0].geometry.type;
        var coordinates = JSON.stringify(event.features[0].geometry.coordinates);
        saveData(name, featureType, coordinates);
        hideSaveForm();
    });
});

function saveData(name, featureType, coordinates) {
    var xhr = new XMLHttpRequest();
    var url = 'dbconn.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };

    var data = 'name=' + encodeURIComponent(name) +
    '&featureType=' + encodeURIComponent(featureType) +
    '&coordinates=' + encodeURIComponent(coordinates);

    xhr.send(data);
}


map.on('draw.create', function () {
  showSaveForm();
});

map.on('draw.update', function () {
  showSaveForm();
});

function showSaveForm() {
  saveForm.style.display = 'block';
}

drawingForm.addEventListener('submit', function (e) {
  e.preventDefault();
  var features = draw.getAll();
  var name = document.getElementById('saveName').value;
  // Add logic to save the features and name as needed
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

/***var map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v11', // You can use your custom style
  center: [-74.5, 40], // [longitude, latitude]
  zoom: 9
});

// Add navigation control
map.addControl(new mapboxgl.NavigationControl());

// Initialize the draw control
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

// Listen for draw.create or draw.update events
map.on('draw.create', updateMap);
map.on('draw.update', updateMap);

function updateMap(event) {
  var features = draw.getAll();
  console.log(features);
}

// Add a line
map.on('load', function () {
  map.addLayer({
    id: 'line',
    type: 'line',
    source: {
      type: 'geojson',
      data: {
        type: 'Feature',
        properties: {},
        geometry: {
          type: 'LineString',
          coordinates: [
            [-74.5, 40],
            [-74, 40.7],
            [-73.5, 40.5]
          ]
        }
      }
    },
    layout: {
      'line-join': 'round',
      'line-cap': 'round'
    },
    paint: {
      'line-color': '#888',
      'line-width': 4
    }
  });
});

***/






