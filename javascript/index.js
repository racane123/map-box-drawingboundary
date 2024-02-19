mapboxgl.accessToken = 'pk.eyJ1IjoicmFjYW5lMTIzIiwiYSI6ImNscDJhZ2xmbDBwdmEybG9pa2w4Yms0emEifQ.vyLoKd0CBDl14MKI_9JDCQ';

const map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v11',
  center: [120.96788000, 14.64953000],
  zoom: 16
});

map.addControl(
  new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    mapboxgl: mapboxgl
  })
);

map.on('load', function() {
  fetch('api/polyapi.php')
    .then(response => response.json())
    .then(data => {
      map.addSource('geojsonSource', {
        type: 'geojson',
        data: data,
      });

      map.addLayer({
        id: 'points',
        type: 'circle',
        source: 'geojsonSource',
        paint: {
          'circle-radius': 6,
          'circle-color': [
            'match',
            ['get', 'name'],
            'point_test', '#909127',
            'hospital' , '#850323',


            '#ffffff'

          ]
        },
        filter: ['==', '$type', 'Point']
      });

      map.addLayer({
        id: 'lines',
        type: 'line',
        source: 'geojsonSource',
        layout: {},
        paint: {
          'line-color': 'blue',
          'line-width': 2
        },
        filter: ['==', '$type', 'LineString']
      });

      map.addLayer({
        id: 'polygons',
        type: 'fill',
        source: 'geojsonSource',
        layout: {},
        paint: {
          'fill-color': [
            'match',
            ['get', 'name'],
            'barangay_177', '#ecf2a5',
            'residential_area', '#a5f2f1',

            '#ffffff'
          ]
        },
        filter: ['==', '$type', 'Polygon']
      });
      
    })

    
    .catch(error => {
      console.error('Error:', error);
    });

    map.on('click', 'places', (e)=>{
      alert("click click")
    })
});




