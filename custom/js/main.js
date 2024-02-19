
// global variable
var featureLayer
var geoms
var feature_id

var selectInt
var modi
var snapi
var editdrawLayer

var draw
var snapii

var FlagisDrawingOn = false
var FlagisModifyOn = false

var PointType = ['Street Light','Signs','Tree']
var LineType = ['Street','Sapa','National Highway','StateHighway',]
var PolygonType = ['Residential','School','Church','Police Station','Barangay Station','Clinic','Karinderya','BarberShop','MilkTea Shop','Repair Shop','Empty Lot','Playground','Boundary','Evacuation Area']
var selectedGeomType


// custom control
window.apps = {};
 var apps = window.apps;

 /**
  * @constructor
  * @extends {ol.control.Control}
  * @param {Object=} opt_options Control options.
  */

 apps.DrawingApp = function(opt_options) {

   var options = opt_options || {};

   var button = document.createElement('button');
   button.id = 'drawbtn'
   button.innerHTML = '<i class="fa-solid fa-pen-ruler"></i>';

   var this_ = this;
   var startStopApp = function() {
       if (FlagisDrawingOn == false){
    $('#startdrawModal').modal('show')
    
       }else {
            map.removeInteraction(draw)
            map.removeInteraction(snapii) 
            FlagisDrawingOn = false
            document.getElementById('drawbtn').innerHTML = '<i class="fa-solid fa-pen-ruler"></i>'
            defineTypeoffeature()
            $('#enterInformationModal').modal('show') 
       }
   };

   button.addEventListener('click', startStopApp, false);
   button.addEventListener('touchstart', startStopApp, false);

   var element = document.createElement('div');
   element.className = 'draw-app ol-unselectable ol-control';
   element.appendChild(button);

   ol.control.Control.call(this, {
     element: element,
     target: options.target
   });

 };
 ol.inherits(apps.DrawingApp, ol.control.Control);


// custom control
window.appss = {};
var appss = window.appss;

/**
 * @constructor
 * @extends {ol.control.Control}
 * @param {Object=} opt_options Control options.
 */
appss.ModifyFeatureApp = function(opt_options) {

  var options = opt_options || {};

  var button = document.createElement('button');
  button.id = 'editbtn'
  button.innerHTML = '<i class="fa-solid fa-pen-to-square"></i>';

  var this_ = this;
  var startStopApp = function() {
      if (FlagisModifyOn == false){
        $('#confirmModal').modal('show')
      }else {
       
           FlagisModifyOn = false
           map.removeLayer(editdrawLayer)
           map.removeInteraction(selectInt)
           map.removeInteraction(modi)
           map.removeInteraction(snapi)
           
           editSource.clear()        
           document.getElementById('editbtn').innerHTML = '<i class="fa-solid fa-pen-to-square"></i>'
           $('#confirmFeatureModal').modal('show')
      }
  };

  button.addEventListener('click', startStopApp, false);
  button.addEventListener('touchstart', startStopApp, false);

  var element = document.createElement('div');
  element.className = 'modify-app ol-control ol-bar ol-left';
  element.appendChild(button);

  ol.control.Control.call(this, {
    element: element,
    target: options.target
  });

};
ol.inherits(appss.ModifyFeatureApp, ol.control.Control);











//
// view
//
var myview = new ol.View({
  projection: 'EPSG:3857',
  zoom: 14,
  center: [13473779.769599514, 1659650.641159134],
  minZoom: 14,
  maxZoom: 20
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

// 
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

document.getElementById('featureType').addEventListener('change', function() {
  var selectedFeature = this.value;
  if (selectedFeature === 'all') {
    getallfeature();
  } else {
    featureIdbyType(selectedFeature);
  }
});


document.getElementById("refreshButton").addEventListener("click", function() {
  // Call the refresh function when the button is clicked
  getallfeature();
 });
 document.getElementById("refreshButton2").addEventListener("click", function() {
  // Call the refresh function when the button is clicked
  getallfeature();
 });


//
// pag display ng mga feature sa map na may style depende kung point,linstring, or polygon
//
var featureLayer = new ol.layer.Vector({
  source: featureLayerSource,
  style: function (feature) {
    var geometry = feature.getGeometry().getType();
    var styles = [];

    if (geometry === 'Point') {
      var type = feature.get('type'); // Assuming 'type' is the attribute containing feature type
      
      // Define a mapping between feature types and their respective icons
      var iconMap = {
          'Street Light': 'assets/img/streetlight.png',
          'Signs': 'assets/img/streetsign.png',
          // Add more mappings as needed
      };
  
      // Determine the icon path based on feature type
      var iconPath = iconMap[type] || 'assets/img/default.png'; // Default icon if type is not found
  
      // Create a new style object for the point feature
      var pointStyleIcon = new ol.style.Style({
          image: new ol.style.Icon({
              src: iconPath,
              // Adjust icon properties as needed
              scale: 0.4, // Example scale adjustment
              anchor: [0.67, 0.89] // Anchor at the middle bottom of the icon
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
      var name = feature.get('name'); // Get the name attribute of the feature
      var type = feature.get('type'); // Assuming 'type' is the attribute containing feature type
    
      var polygonCoordinates = feature.getGeometry().getCoordinates()[0]; // Get the coordinates of the polygon
      var centroid = calculateCentroid(polygonCoordinates); // Calculate centroid
    
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
        'Repair Shop': 'assets/img/repairshop.png'
        
      
        // Add more mappings as needed
      };
    
      // Determine the icon path based on feature type
      var iconPath = iconMap[type] || 'assets/img/default.png'; // Default icon if type is not found
    
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
  popupClass: "default anim", //"tooltips", "warning" "black" "default", "tips", "shadow",
  closeBox: true,
  onclose: function(){ console.log("You close the box"); },
  positioning: 'auto',
  autoPan: {
    animation: {
      duration: 100
    }
  }
});

// draw vector layer
// 1. define source
var drawSource = new ol.source.Vector()
// 2. define layer
var drawLayer = new ol.layer.Vector({
    source : drawSource
})

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
var layerArray = [baselayer,featureLayer,drawLayer] 


//Map
var map = new ol.Map({
    controls: ol.control.defaults({
        attributionOptions: {
          collapsible: false
        }
      }).extend([
        new apps.DrawingApp(),
        new appss.ModifyFeatureApp()
      ]),

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

 // FOR ADD RESIDENT MODAL
 function handleButtonClick(baranggay_no, feature_id) {
  $('#myModals').modal('show');
  $('#barangay_no_input').val(baranggay_no);
  $('#feature_id_input').val(feature_id);
}

$('#cancel').on('click', function() {
  $('#myModals').modal('hide');
});

 // FOR ADD SHOP INFO MODAL
 function forAddMoreInfo(baranggay_no, feature_id){
  $('#addShopInfo').modal('show');
  $('#shop_barangayNo').val(baranggay_no);
  $('#shop_featureID').val(feature_id);
 }

$('#canceladdShopInfo').on('click', function() {
   $('#addShopInfo').modal('hide');
});
  
$('#cancelViewMoreShopInfo').on('click', function() {
  $('#viewMoreShopInfo').modal('hide');
});


select.getFeatures().on(['add'], function (e) {
  if (!FlagisDrawingOn) {
    var feature = e.element;
    var content = 
    //'</br> <b> GEOM </b>:' + feature.getGeometry().getType() +
    // '</br><b> BRGY </b>:'
          '<b> TYPE </b>:' + feature.get("type") +
          '</br> <b> NAME </b>:' + feature.get("name") +
          '</br> <b> Feature ID </b>:' + feature.get("feature_id")+
          '</br><b> BRGY </b>:' + feature.get("baranggay_no");

    var geometryType = feature.getGeometry().getType();
    var coordinates;
    if (geometryType === 'Point') {
        coordinates = feature.getGeometry().getCoordinates();
    } else if (geometryType === 'LineString') {
        coordinates = ol.extent.getCenter(feature.getGeometry().getExtent());
    } else if (geometryType === 'Polygon') {
        coordinates = ol.extent.getCenter(feature.getGeometry().getExtent());
    }
    
    

// Check if the feature type is residential
if (feature.get("type") === "Residential") {
  content += 
  '<hr style="margin: 0;">' +
  '<button style="margin: 0; padding:0;" type="button" class="btn btn-secondary" id="yourButtonId">Add Resident</button>'+
  '<button style="margin-left: 3px; padding:0;" type="button" class="btn btn-secondary" id="viewResButtonId">View Resident</button>';
}   

 
  
// Check if the feature type is residential
if (feature.get("type") === "BarberShop" || feature.get("type") === "MilkTea Shop" || feature.get("type") === "Repair Shop") {
  content += 
  '<hr style="margin: 0;">' +
  '<button style="margin-left: 3px; padding:0;" type="button" class="btn btn-secondary" id="viewMoreShopInfoId">More info</button>'+
  '<button style="margin-left: 3px; padding:0;" type="button" class="btn btn-secondary" id="viewAddInfo">Add</button>';
}


popup.show(coordinates, content);

// Attach click event listener to the button if it's added
        if (feature.get("type") === "BarberShop" || feature.get("type") === "MilkTea Shop" || feature.get("type") === "Repair Shop") {
          $('#viewAddInfo').on('click', function() {
            var baranggay_no = feature.get("baranggay_no"); // Assuming barangay_no is part of the feature properties
            var feature_id = feature.get("feature_id"); // Assuming feature_id is part of the feature properties
            forAddMoreInfo(baranggay_no, feature_id);
          });
        }

// Attach click event listener to the button if it's added
        if (feature.get("type") === "Residential") {
          $('#yourButtonId').on('click', function() {
            var baranggay_no = feature.get("baranggay_no"); // Assuming barangay_no is part of the feature properties
            var feature_id = feature.get("feature_id"); // Assuming feature_id is part of the feature properties
            handleButtonClick(baranggay_no, feature_id);
          });
        }

        if (feature.get("type") === "BarberShop" || feature.get("type") === "MilkTea Shop" || feature.get("type") === "Repair Shop") {
          $('#viewMoreShopInfoId').on('click', function() {
            var Feature_id = feature.get("feature_id");
             console.log(Feature_id)
    
             $.ajax({
              url: 'apiFolder/viewShopInfoapi.php',
              type: 'POST',
              data: {
                  feature_id: Feature_id
              },
              success: function(response) {
                  // Handle the response data here
                  console.log(response);
                  // Assuming the response is JSON, you can parse it and process it accordingly
                  var data = JSON.parse(response);
                  var tableBod = document.querySelector('#shopinfo-tables tbody');
                  tableBod.innerHTML = ''; // Clear the table body before appending new data
                  data.forEach(shopinfo => {
                      var row = document.createElement('tr');
                      row.innerHTML = `
                          <td>${shopinfo.O_Name}</td>
                          <td>${shopinfo.O_age}</td>
                          <td>${shopinfo.O_gender}</td>
                          <td><a href="data:application/pdf;base64,${shopinfo.O_permit}" download="permit.pdf">Download Permit</a></td>
                          <td><button class="btn btn-primary" data-toggle="modal" data-target="#editinfo" onclick="editResident('${shopinfo.O_name}', '${shopinfo.O_age}', '${shopinfo.O_gender}','${shopinfo.O_permit}')">Edit</button></td>

                          
                      `;
                      tableBod.appendChild(row);
                  });
              },
              error: function(xhr, status, error) {
                  console.error('Error fetching data:', error);
              }
          });
    
          $('#viewMoreShopInfo').modal('show'); 
          });
        }


  
    if (feature.get("type") === "Residential") {
      $('#viewResButtonId').on('click', function() {
        var Feature_id = feature.get("feature_id");
         console.log(Feature_id)

         $.ajax({
          url: 'apiFolder/viewresidentapi.php',
          type: 'POST',
          data: {
              feature_id: Feature_id
          },
          success: function(response) {
              // Handle the response data here
              console.log(response);
              // Assuming the response is JSON, you can parse it and process it accordingly
              var data = JSON.parse(response);
              var tableBody = document.querySelector('#resident-tables tbody');
              tableBody.innerHTML = ''; // Clear the table body before appending new data
              data.forEach(resident => {
                  var row = document.createElement('tr');
                  row.innerHTML = `
                      <td>${resident.name}</td>
                      <td>${resident.age}</td>
                      <td>${resident.gender}</td>
                      <td>${resident.height}</td>
                      <td>${resident.weight}</td>
                      <td><button class="btn btn-primary" data-toggle="modal" data-target="#editinfo" onclick="editResident(${resident.ResidentID}, '${resident.name}', ${resident.age}, '${resident.gender}', ${resident.height}, ${resident.weight})">Edit</button></td>
                  `;
                  tableBody.appendChild(row);
              });
          },
          error: function(xhr, status, error) {
              console.error('Error fetching data:', error);
          }
      });

      $('#viewresident').modal('show'); 
      });
    }

  }

 
});

// On deselected => hide popup
select.getFeatures().on(['remove'], function (e) {
  //featureLayer.clear(true);
  popup.hide();
});



function removeViewRes() {
  $('#viewresident').modal('hide');
  $('#editinfo').modal('hide');
  $('#myModals').modal('hide');
  //$('#resident-table tbody').empty(); // Clear the table body
}

//coordinates ng boundary para sa filter mask 
/*
let dep =      {
  "type": "Feature",
  "geometry": {
      "type": "Polygon",
      "coordinates": [
          [
              [
                  13469794.274080126,
                  1660798.9084294834
              ],
              [
                  13472194.396666227,
                  1661838.4519704243
              ],
              [
                  13474907.911461934,
                  1661104.6566884161
              ],
              [
                  13476444.295613833,
                  1659652.3530052057
              ],
              [
                  13475320.671531308,
                  1658215.336348593
              ],
              [
                  13472905.261262545,
                  1657810.2207401667
              ],
              [
                  13469985.366650838,
                  1659400.1108701816
              ],
              [
                  13469794.274080126,
                  1660798.9084294834
              ]
          ]
      ]
  },
  "properties": {
      "type": "Boundary",
      "name": "TRYCROP"
  }
};
var coords = dep.geometry.coordinates;
var f = new ol.Feature(new ol.geom.Polygon(coords));

var mask= new ol.filter.Mask({ 
  feature: f, 
  wrapX: true,
  inner: false,
  fill: new ol.style.Fill({ color: [0, 0, 255, 0.2] }),
  shadowWidth: 10,
  shadowColor: [0, 0, 0, 1]
});
baselayer.addFilter(mask);

*/


// FUNCTION TO START DRAWING FEATURES
      function startDraw(geomType){
          selectedGeomType = geomType
          draw = new ol.interaction.Draw({
              type : geomType,
              source:drawSource
          }) 
        $('#startdrawModal').modal('hide')

        var snapii = new ol.interaction.SnapGuides({ 
          vectorClass: ol.layer.VectorImage 
        });
        snapii.enableInitialGuides_ = true;
        snapii.setDrawInteraction(draw);
        map.addInteraction(draw)
        map.addInteraction(snapii);
        
        FlagisDrawingOn = true
        document.getElementById('drawbtn').innerHTML = '<i class="fa-solid fa-circle-stop"></i>'
      }


//function to add types based on feature
      function defineTypeoffeature(){
          var dropdownoftype = document.getElementById('typeoffeatures')
          dropdownoftype.innerHTML = ''
          if (selectedGeomType == 'Point'){
              for (i=0; i<PointType.length; i++){
                  var op = document.createElement('option')
                  op.value = PointType[i]
                  op.innerHTML = PointType[i]
                  dropdownoftype.appendChild(op)
              }
          }else if (selectedGeomType == 'LineString'){
              for (i=0; i<LineType.length; i++){
                  var op = document.createElement('option')
                  op.value = LineType[i]
                  op.innerHTML = LineType[i]
                  dropdownoftype.appendChild(op)
              }    
          }else{
              for (i=0; i<PolygonType.length; i++){
                  var op = document.createElement('option')
                  op.value = PolygonType[i]
                  op.innerHTML = PolygonType[i]
                  dropdownoftype.appendChild(op)
              }
          }
      }


// SAVE NEW DRAWN FEATURES TO DATABASE
        function savetodb() {
          var featureArray = drawSource.getFeatures();
          var geoJSONformat = new ol.format.GeoJSON();
          var featuresGeojson = geoJSONformat.writeFeaturesObject(featureArray);
          var geojsonFeatureArray = featuresGeojson.features;
          
          console.log(geojsonFeatureArray);

          for (var i = 0; i < geojsonFeatureArray.length; i++) {
              var type = document.getElementById('typeoffeatures').value;
              var name = document.getElementById('exampleInputtext1').value;
              var barangay_no = document.getElementById('exampleInputtext2').value;
              var geom = JSON.stringify(geojsonFeatureArray[i].geometry);

              if (type !== '') {
                  if (type === 'Boundary') {
                      // Save boundary feature
                      $.ajax({
                          url: 'save_to_database\saveboundary.php',
                          type: 'POST',
                          data: {
                              typeofgeom: type,
                              nameofgeom: name,
                              barangaynoofgeom: barangay_no,
                              stringofgeom: geom
                          },
                          success: function(dataResult) {
                            try {
                                var result = JSON.parse(dataResult);
                                console.log(result); // Log the entire parsed result
                        
                                if (result.statusCode === 200) {
                                    console.log('Data added successfully');
                                } else {
                                    console.log('Data not added successfully');
                                }
                            } catch (e) {
                                console.error('Error parsing JSON:', e);
                                console.log('Original dataResult:', dataResult);
                            }
                        }
                      });
                  } else {
                      // Save non-boundary feature
                      $.ajax({
                          url: 'save_to_database/save.php',
                          type: 'POST',
                          data: {
                              typeofgeom: type,
                              nameofgeom: name,
                              barangaynoofgeom: barangay_no,
                              stringofgeom: geom
                          },
                          success: function(dataResult) {
                            try {
                                var result = JSON.parse(dataResult);
                                console.log(result); // Log the entire parsed result
                        
                                if (result.statusCode === 200) {
                                  showToast('success', 'Feature updated successfully');
                              } else {
                                  showToast('error', 'Feature not updated successfully');
                              }
                            } catch (e) {
                                console.error('Error parsing JSON:', e);
                                console.log('Original dataResult:', dataResult);
                            }
                        }
                      });
                  }
              } else {
                  alert('Please select a type');
              }
          }
          $('#enterInformationModal').modal('hide');
          drawSource.clear(); 
        }
        function clearDrawSource(){drawSource.clear()}
        function clearEditSource(){editSource.clear()}

// FUNCTION TO START EDIT FEATURES
      function startedit(){
        var editdrawLayer = new ol.layer.Vector({
          source : editSource,  
          wrapX: false
      })
        map.addLayer(editdrawLayer);

        selectInt = new ol.interaction.Select({
          wrapX: false  });
        modi = new ol.interaction.Modify({
          features: selectInt.getFeatures()  });
        modi.on('modifyend', function(e) {
          var features = e.features.getArray();
          console.log("num of fetaures",features.length);
          for (var i=0;i<features.length;i++){
          console.log("feature revision",features[i].getRevision())
          }
          console.log(features)
          var geoJSONformat = new ol.format.GeoJSON();
          var featuresGeojson = geoJSONformat.writeFeaturesObject(features);
          var geojsonFeatureArray = featuresGeojson.features;
          console.log(geojsonFeatureArray)
          for (var i = 0; i < geojsonFeatureArray.length; i++) {
          geoms = JSON.stringify(geojsonFeatureArray[i].geometry);
          console.log(geoms);
          feature_id = geojsonFeatureArray[i].properties.feature_id;
          console.log("Feature ID:", feature_id);
            
        }    
          })
          
      $('#confirmModal').modal('hide')

      var snapi = new ol.interaction.SnapGuides({ 
        vectorClass: ol.layer.VectorImage 
      });
      
      snapi.enableInitialGuides_ = true;
      snapi.setModifyInteraction(modi);
      map.addInteraction(modi);
      map.addInteraction(selectInt);
      map.addInteraction(snapi);

      FlagisModifyOn = true
      document.getElementById('editbtn').innerHTML = '<i class="fa-solid fa-circle-stop"></i>'
      }

// SAVE MODIFIED FEATURE TO DATABASE
      function saveModitodb() {
        var newgeom = geoms
        var Id = feature_id
        console.log(newgeom)
        console.log(Id)
        
            $.ajax({
                url: 'save_to_database/savemodi.php',
                type: 'POST',
                data: {
                    feature_id_ofgeom: Id,                
                    stringofgeom: newgeom
                },
                success: function(dataResult) {
                  try {
                      var result = JSON.parse(dataResult);
                      console.log(result); // Log the entire parsed result
              
                      if (result.statusCode === 200) {
                          console.log(' feature updated successfully');
                      } else {
                          console.log(' feature not updated successfully');
                      }
                  } catch (e) {
                      console.error('Error parsing JSON:', e);
                      console.log('Original dataResult:', dataResult);
                  }
              }
            });
      //close the modal
      $('#confirmFeatureModal').modal('hide')

      refresh()
      }

// Function to handle editing resident info
function editResident(id, name, age, gender, height, weight) {
  document.getElementById('editResidentID').value = id;
  document.getElementById('editName').value = name;
  document.getElementById('editAge').value = age;
  document.getElementById('editGender').value = gender;
  document.getElementById('editHeight').value = height;
  document.getElementById('editWeight').value = weight;
  $('#editinfo').modal('show');
  $('#viewResidentChart_Table').modal('hide');
}

// SAVE EDITED RESIDENT INFO TO DB
      function saveResidentChanges() {
        var residentID = document.getElementById('editResidentID').value;
        var name = document.getElementById('editName').value;
        var age = document.getElementById('editAge').value;
        var gender = document.getElementById('editGender').value;
        var height = document.getElementById('editHeight').value;
        var weight = document.getElementById('editWeight').value;

        $.ajax({
            type: "POST",
            url: "save_to_database/saveEditedResidentInfo.php",
            data: {
                ResidentID: residentID,
                name: name,
                age: age,
                gender: gender,
                height: height,
                weight: weight
            },
            success: function(dataResult) {
                try {
                    var result = JSON.parse(dataResult);
                    console.log(result); // Log the entire parsed result
            
                    if (result.statusCode === 200) {
                      showToast('success', 'Feature updated successfully');
                  } else {
                      showToast('error', 'Feature not updated successfully');
                  }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.log('Original dataResult:', dataResult);
                }
            }
          });
          $('#editinfo').modal('hide');
        }     

// SAVE ADDED RESIDENT INFO 
      function saveinfotodb() {
        var name = $("#name").val();
        var age = parseInt($("#age").val()); 
        var gender = $("#gender").val();
        var height_cm = parseFloat($("#height").val()); 
        var weight_kg = parseFloat($("#weight").val()); 
        var feature_id = $("#feature_id_input").val();
        var barangay_no = $("#barangay_no_input").val(); 
        
        var height_m = height_cm / 100; 
        var bmi = (weight_kg / (height_m * height_m)).toFixed(2);
        // Calculate BMI category based on age and BMI value
        var bmiCategory = "";
        if (age >= 20) {
          if (bmi < 18.5) {
            bmiCategory = "Underweight";
          } else if (bmi >= 18.5 && bmi < 25) {
            bmiCategory = "Normal weight";
          } else if (bmi >= 25 && bmi < 30) {
            bmiCategory = "Overweight";
          } else {
            bmiCategory = "Obesity";
          }
        }

        // Send the form data along with BMI and BMI category to the server using AJAX
        $.ajax({
          type: "POST",
          url: "save_to_database/saveresident.php",
          data: {
            name: name,
            age: age,
            gender: gender,
            height: height_cm,
            weight: weight_kg,
            bmi: bmi,
            bmi_category: bmiCategory, // Add BMI category to data sent to server
            feature_id: feature_id,
            barangay_no: barangay_no
          },
          success: function(dataResult) {
            try {
                var result = JSON.parse(dataResult);
                console.log(result); // Log the entire parsed result
        
                if (result.statusCode === 200) {
                  showToast('success', 'Feature updated successfully');
              } else {
                  showToast('error', 'Feature not updated successfully');
              }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.log('Original dataResult:', dataResult);
            }
        }

        });
        // Close the modal
        $('#myModals').modal('hide');
      }

// SAVE ADDED SHOP INFO TO DB
      function saveShopInfotodb() {
        // Get form data
        var O_name = $("#O_name").val();
        var O_age = parseInt($("#O_age").val());
        var O_gender = $("#O_gender").val();
        var O_permit = $("#O_permit").val();
        var O_barangay_no = $("#shop_barangayNo").val(); 
        var O_feature_id = $("#shop_featureID").val();

        $.ajax({
          type: "POST",
          url: "save_to_database/saveShopInfo.php",
          data: {
            O_name : O_name,
            O_age: O_age,
            O_gender: O_gender,
            O_permit: O_permit,
            O_barangay_no: O_barangay_no,
            O_feature_id:O_feature_id,
          },
          success: function(dataResult) {
            try {
                var result = JSON.parse(dataResult);
                console.log(result); // Log the entire parsed result
        
                if (result.statusCode === 200) {
                  showToast('success', 'Feature updated successfully');
              } else {
                  showToast('error', 'Feature not updated successfully');
              }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.log('Original dataResult:', dataResult);
            }
        }

        });
        $('#addShopInfo').modal('hide');
      }

// FUNCTION TO SHOW NOTIFICATION/TOAST
      function showToast(type, message) {
        var toastElement = document.getElementById('liveToast');
        toastElement.querySelector('.toast-body').textContent = message;
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
      }   