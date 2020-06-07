var imgError = false
var imgUpload = false
// Init map
mapboxgl.accessToken = 'pk.eyJ1IjoidGltb3RoeWsiLCJhIjoiY2s5YjQzc3VpMGl4djNlbzAwbDJnM3EwbyJ9.Q9r-ZxP6xrDkeEg0PLu9Sw';
var map = new mapboxgl.Map({
container: 'mapContainer', // Container id
style: 'mapbox://styles/timothyk/ck9h30yyg0n471iqwryimh56t',
center: [4.475269, 51.021694], // Starting position
zoom: 13 // Starting zoom
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
if (data.features.length > 0) {
var area = turf.area(data);
// restrict to area to 2 decimal points
var rounded_area = Math.round(area * 100) / 100;
console.log(rounded_area)
    if(rounded_area <= 700) {
        test(data.features[0].geometry.coordinates[0]);
    }else {
        document.querySelector('.blur').style.display = "block"
        document.querySelector('.community__popup__deny').style.display = "block"
    }
    }
}

let JsonCommunities = { // json for making communities
    'type': 'geojson',
    'data': {
        'type': 'FeatureCollection',
        'features': [
        ]
    }
}

for (var varName in window) {
    if (varName.substring(0,4) == 'item') {
      JsonCommunities.data.features.push(window[varName]) // add js variables that where made from php to the json
    }
}

map.on('load', function() {
    map.addSource('Gary', JsonCommunities);
    
    map.addLayer({
    'id': 'Gary',
    'type': 'fill',
    'source': 'Gary',
    'layout': {},
    'paint': {
    'fill-color': 'rgba(125, 212, 41, 0.4)',
    'fill-outline-color': '#7DD429',
    }
    });

    // When a click event occurs on a feature in the states layer, open a popup at the
    // location of the click, with description HTML from its properties.
    map.on('click', 'Gary', function(e) {
        new mapboxgl.Popup()
        .setLngLat(e.lngLat)
        .setHTML(`<a href='community.php?com=${e.features[0].properties.id}'><img src='images/${e.features[0].properties.img}' alt=''></a><a href='community.php?com=${e.features[0].properties.id}'><h2 class='map__popup__name'>${e.features[0].properties.name}</h2></a>`)
        .addTo(map);
        });
        // Change the cursor to a pointer when the mouse is over the states layer.
        map.on('mouseenter', 'Gary', function() {
        map.getCanvas().style.cursor = 'pointer';
        });
         
        // Change it back to a pointer when it leaves.
        map.on('mouseleave', 'Gary', function() {
        map.getCanvas().style.cursor = '';
        });
});

function isEmpty(value){
    return (value == null || value.length === 0);
}
var polyV1 = ""
var poly
function test(place) {
    document.querySelector('.blur').style.display = "block"
    document.querySelector('.community__popup').style.display = "flex"
    place.forEach(element => {
        polyV1 += `[${element}],`
    });
    poly = polyV1.substring(0, polyV1.length - 1);
}

document.querySelector('.blur').addEventListener('click', (e) => {
    document.querySelector('.blur').style.display = "none"
    document.querySelector('.community__popup').style.display = "none"
    document.querySelector('.community__popup__confirm').style.display = "none"
    document.querySelector('.community__popup__deny').style.display = "none"
    
})
let exits = document.querySelectorAll('.exit__community__popup')
exits.forEach(element => {
    element.addEventListener('click', (e) => {
        document.querySelector('.blur').style.display = "none"
        document.querySelector('.community__popup').style.display = "none"
        document.querySelector('.community__popup__confirm').style.display = "none"
        document.querySelector('.community__popup__deny').style.display = "none"
    })
});

document.querySelector('.nudge__popup__send').addEventListener('click', (e) => {
    let communityName = document.querySelector('#name').value 
    let crop1 = document.querySelector('#crops1').value 
    let crop2 = document.querySelector('#crops2').value 
    let img = document.querySelector('#avatar').value
    userId = document.querySelector('.nudge__popup__send').dataset.userid

    if(isEmpty(img)) {
        document.querySelector('.white').innerHTML = "please upload an image for your community"
        document.querySelector('.white').classList.add('red')
    }else if(isEmpty(communityName)) {
        document.querySelector('.white').innerHTML = "please enter a name for your community"
        document.querySelector('.white').classList.add('red')
    }else if(isEmpty(crop1) && isEmpty(crop2)) {
        document.querySelector('.white').innerHTML = "your community must have at least 1 crop"
        document.querySelector('.white').classList.add('red')
    }else if(imgError) {
        document.querySelector('.white').innerHTML = "your image must be a jpeg, png or gif"
        document.querySelector('.white').classList.add('red')
    }else {
        //save img to upload folder

        //make form
        let formData = new FormData();
        formData.append('userId', userId)  
        formData.append('communityName', communityName)
        formData.append('crop1', crop1)
        formData.append('crop2', crop2)
        formData.append('img', image)
        formData.append('polygon1', poly)

        //fetch
        fetch('ajax/makeCommunity.php', {
            method: 'POST',
            body: formData
            })
            .then((response) => response.json())
            .then((result) => {
                document.querySelector('.community__popup').style.display = "none"
                document.querySelector('.community__popup__confirm').style.display = "flex"
            })
            .catch((error) => {
            console.error('Error:', error);
            });  
    }
})
var image
document.querySelector('#avatar').addEventListener('change', () => {
    const file = document.querySelector('#avatar').files[0]
    if(file) {
        const reader = new FileReader()
        reader.addEventListener('load', () => {
            if(reader.result.includes('image/gif') || reader.result.includes('image/jpeg') || reader.result.includes('image/png')) {
                imgError = false
                document.querySelector('.form__avatar').setAttribute('src', reader.result)
                let splitted = document.querySelector('#avatar').value.split("C:\\fakepath\\")
                image = splitted[1]
                imgUpload = true
            } else {
                imgError = true
                imgUpload = false
            }
        })
        reader.readAsDataURL(file)
    }
})

document.querySelector('.community__popup__deny').addEventListener('click', () => {
    document.querySelector('.blur').style.display = "none"
    document.querySelector('.community__popup__deny').style.display = "none"
})