// Init map
mapboxgl.accessToken = 'pk.eyJ1IjoiYXJuaWk1IiwiYSI6ImNrMm9saDBrcDA2eHEzbXBwcWp1dDF1bXoifQ.E-X_zNMBO2_RyWWWZpuY5g';
var map = new mapboxgl.Map({
container: 'mapContainer', // Container id
style: 'mapbox://styles/mapbox/streets-v11',
center: [4.465269, 51.021694], // Starting position
zoom: 17 // Starting zoom
});

//Init GLOBAL variables
let currentPosMarkers = []; //Current position markers (we can clear this on updating to prevent drawing a line)
var cars = [];
var lat;
var lng;
 
//Add geolocate control to the map.
map.addControl(new mapboxgl.GeolocateControl({
positionOptions: {
enableHighAccuracy: true
},
trackUserLocation: true
}));

//WatchPosition: function settings
var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
};

//Start location tracking and watch position
var mylocation = navigator.geolocation;
watchId = mylocation.watchPosition(updatePosition, positionError, options);

//Function to actually update the users position marker on success
function updatePosition(pos){
    //Set center of map and save coords
    lat = pos.coords.latitude;
    lng = pos.coords.longitude;
    
    //Clear all old current markers
    if (currentPosMarkers !== null) {
        for (let i = 0; i < currentPosMarkers.length; i++) {

            //Remove marker from map view
            currentPosMarkers[i].remove();
        }
        //Reset currentMarkers array after removing the markers on the map
        currentPosMarkers = [];
    }

    //Create and add current position marker
    var myPos = document.createElement('a');
    myPos.className = "myPos";
    currentPos = new mapboxgl.Marker(myPos).setLngLat([lng, lat]).addTo(map);
    currentPosMarkers.push(currentPos);   
}

//Function to show error in console when updating the users position does not succeed
function positionError(err) {
    console.warn('ERROR(' + err.code + '): ' + err.message);
}
  
function deg2rad(deg) {
    return deg * (Math.PI/180) //Convert degrees to radial
}

var draw = new MapboxDraw({
displayControlsDefault: false,
controls: {
polygon: true,
trash: false
}
});
map.addControl(draw);
 
map.on('draw.create', updateArea);
map.on('draw.delete', updateArea);
map.on('draw.update', updateArea);
 
function updateArea(e) {
var data = draw.getAll();
var answer = document.getElementById('calculated-area');
if (data.features.length > 0) {
var area = turf.area(data);
console.log(data.features[0].geometry.coordinates[0])
// restrict to area to 2 decimal points
var rounded_area = Math.round(area * 100) / 100;
answer.innerHTML =
'<p><strong>' +
rounded_area +
'</strong></p><p>square meters</p>';
} else {
answer.innerHTML = '';
if (e.type !== 'draw.delete')
alert('Use the draw tools to draw a polygon!');
}
}





map.on('load', function() {
    map.addSource('Gary', {
    'type': 'geojson',
    'data': {
    'type': 'Feature',
    'geometry': {
    'type': 'Polygon',
    'coordinates': [
    [
    [4.465629730950667, 51.02155666327056],
    [4.465678064026349, 51.02149399607427],
    [4.46576190717883, 51.02151757383976],
    [4.46571061490431, 51.021579000049],
    [4.465629730950667, 51.02155666327056]
    ]
    ]
    }
    }
    });
    map.addLayer({
    'id': 'Gary',
    'type': 'line',
    'source': 'Gary',
    'layout': {},
    'paint': {
    'line-color': '#7DD429',
    'line-width': 3
    }
    });
    });