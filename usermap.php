<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mapbox Traffic Example</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet" />
    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';

        // Create a map instance
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/traffic-day-v2', // Replace with your preferred map style
            center: [120.96788000, 14.64953000], // Replace with desired center coordinates
            zoom: 12 // Adjust the initial zoom level
        });

        // Add traffic layer to the map
    </script>
</body>
</html>