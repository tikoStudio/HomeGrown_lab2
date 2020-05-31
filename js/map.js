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
test(data.features[0].geometry.coordinates[0]);
// restrict to area to 2 decimal points
var rounded_area = Math.round(area * 100) / 100;
}
}

map.on('load', function() {
    map.addSource('Gary', {
        'type': 'geojson',
        'data': {
            'type': 'FeatureCollection',
            'features': [
                {
                    'type': 'Feature1',
                    'properties': {
                        'name': 'De Mechelse kwekers',
                        'img': 'cucumber.png',
                        'id': 1
                    },
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
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "De Mechelse kwekers",
                        'img': 'cucumber.png',
                        'id': 1
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.463185663879898, 51.02399895177513],
                                    [4.463238580872513, 51.024056100622346],
                                    [4.463324446180991, 51.02408059296431],
                                    [4.463366380401368, 51.02404919252385],
                                    [4.46324057774018, 51.023974459390416],
                                    [4.463185663879898, 51.02399895177513]
                                ]
                            ]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "tomaten kwekertjes Be",
                        'img': 'tomatoes.jpg',
                        'id': 2
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.465804384511387, 51.019479739475344],
                                    [4.465874223528033, 51.01930389648365],
                                    [4.465640414646515, 51.01927237944403],
                                    [4.465564502671725, 51.01945097571988],
                                    [4.465804384511387, 51.019479739475344]
                                ]
                            ]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "oregano boerenbond mechelen",
                        'img': 'oregano.jpg',
                        'id': 3
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.475469342642128, 51.019343685565474],
                                    [4.475574771988704, 51.01927038315927],
                                    [4.475619163293771, 51.01928783612365],
                                    [4.47584111981331, 51.01914472162153],
                                    [4.4760519785065185, 51.01928783612365],
                                    [4.475646907857993, 51.01947283714205],
                                    [4.475469342642128, 51.019343685565474]
                                ]
                            ]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "de tomatenplukkers",
                        'img': 'tomatoes.jpg',
                        'id': 4
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.672929055175871, 51.06352237952055],
                                    [4.6721549293971805, 51.06319398690687],
                                    [4.672038810530097, 51.06262233494817],
                                    [4.671167919029273, 51.061758762220364],
                                    [4.670277674383556, 51.06090733671792],
                                    [4.670045436650611, 51.06026267556442],
                                    [4.670413146395589, 51.05992209623673],
                                    [4.670722796707054, 51.059265257600856],
                                    [4.671342097329955, 51.059338240131865],
                                    [4.672716170586597, 51.05909496458179],
                                    [4.674206362710294, 51.05961800543432],
                                    [4.674903075911658, 51.06045729119822],
                                    [4.673761240388046, 51.06263449782958],
                                    [4.6732193523423575, 51.06254935759446],
                                    [4.672929055175871, 51.06352237952055]
                                ]
                            ]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "de groene handjes Be",
                        'img': 'cucumber.png',
                        'id': 5
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.488747465222275, 51.023776165295686],
                                    [4.488386746198984, 51.02381398052785],
                                    [4.488845159958203, 51.02447101526829],
                                    [4.489048064408848, 51.02443792741096],
                                    [4.488747465222275, 51.023776165295686]
                                ]
                            ]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "yet another farm here",
                        'img': 'oregano.jpg',
                        'id': 6
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.700483761852382, 50.99487089062558],
                                    [4.70038403322846, 50.99486847646415],
                                    [4.700378279653847, 50.99491434550873],
                                    [4.700294007089212, 50.994908286364904],
                                    [4.700315103529334, 50.994983125245],
                                    [4.700476203613391, 50.99498433232273],
                                    [4.700483761852382, 50.99487089062558]
                                ]
                            ]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'name': "the raspberry club van mechelen",
                        'img': 'raspberry.jpg',
                        'id': 7
                    },
                    'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [4.470409299869829, 51.02395817774939],
                                    [4.47050105886882, 51.02398342848622],
                                    [4.470581347994056, 51.02398342848622],
                                    [4.4706386973687415, 51.02389685447335],
                                    [4.470208577057491, 51.02374534956144],
                                    [4.470019324120443, 51.023878818200274],
                                    [4.470409299869829, 51.02395817774939]
                                ]
                            ]
                    }
                }
            ]
        }
    });
    
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
var poly
function test(place) {
    console.log(place)
    document.querySelector('.blur').style.display = "block"
    document.querySelector('.community__popup').style.display = "flex"
    poly = place
}

document.querySelector('.blur').addEventListener('click', (e) => {
    document.querySelector('.blur').style.display = "none"
    document.querySelector('.community__popup').style.display = "none"
    document.querySelector('.community__popup__confirm').style.display = "none"
})
let exits = document.querySelectorAll('.exit__community__popup')
exits.forEach(element => {
    element.addEventListener('click', (e) => {
        document.querySelector('.blur').style.display = "none"
        document.querySelector('.community__popup').style.display = "none"
        document.querySelector('.community__popup__confirm').style.display = "none"
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
        console.log("fetch hier")

        //save img to upload folder

        //make form
        let formData = new FormData();
        formData.append('userId', userId)  
        formData.append('communityName', communityName)
        formData.append('crop1', crop1)
        formData.append('crop2', crop2)
        formData.append('img', image)
        formData.append('polygon1', poly)
        
        console.log(image)

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