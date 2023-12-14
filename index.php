<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Interactive Map with Drawing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.js"></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.css" type="text/css" />
  <style>
    body { margin: 0; padding: 0; }
    #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    .mapboxgl-ctrl-group.mapboxgl-ctrl.mapboxgl-ctrl-group-active {
      display: none; /* hide the Draw toolbar by default */
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
  <div id="map"></div>
  <div id="saveForm">
    <h3>Save Drawing</h3>
    <form id="drawingForm">
      <label for="saveName">Name:</label>
      <input type="text" id="saveName" name="saveName" required>
      <br>
      <button type="submit">Save</button>
      <button type="button" onclick="cancelDrawing()">Cancel</button>
    </form>
  </div>
  <script src="javascript/map.js"></script>
</body>
</html>
