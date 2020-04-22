// Init map
mapboxgl.accessToken = 'pk.eyJ1IjoiYXJuaWk1IiwiYSI6ImNrMm9saDBrcDA2eHEzbXBwcWp1dDF1bXoifQ.E-X_zNMBO2_RyWWWZpuY5g';
var map = new mapboxgl.Map({
container: 'mapContainer', // Container id
style: 'mapbox://styles/mapbox/streets-v11',
center: [4.632103, 51.003601], // Starting position
zoom: 18 // Starting zoom
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


//Get all cars and show them on the map
getAllCars();

//Start location tracking and watch position
var mylocation = navigator.geolocation;
watchId = mylocation.watchPosition(updatePosition, positionError, options);


//Creation of car objects within a car array for demo purposes
function getAllCars(){
  let cars = [
    {
      brand:"Tesla",
      model:"S",
      lat: 51.003142,
      lng: 4.632210
    },
    {
      brand:"Mercedes",
      model:"Future",
      lat: 51.00414,
      lng: 4.6320
    }
  ]

  //make html elements for these objects (loop, foreach?) <i class="fas fa-car"></i>
  let i = 0
  singleCar = [];
  cars.forEach(function(car){
        i++;
        let carMarker = document.createElement("i");
        carMarker.classList.add("car", "fas","fa-car");
        singleCar[i] = new mapboxgl.Marker(carMarker).setLngLat([car.lng, car.lat]).addTo(map);
  });

  function animateMarker() {
    // Update the lat and lng of the marker
    singleCar[1].setLngLat([
    cars[0].lng -= 0.0000001,
    cars[0].lat += 0.0000005
    ]);

    singleCar[2].setLngLat([
      cars[1].lng += 0.0000001,
      cars[1].lat -= 0.0000005
    ])
     
    // Ensure it's added to the map. This is safe to call if it's already added.
    singleCar[1].addTo(map);
    singleCar[2].addTo(map);
  
    let safetyIcon = document.querySelector('.safetyIcon');
    let safetyText = document.querySelector('.safetyText');
    
    let n = 0;
    for (n = 0; n < cars.length; n++) {
      //Check if carDistance is within allowed capture range (100 meter)
      var carDistance = getDistanceFromLatLonInKm(lat, lng, cars[n].lat, cars[n].lng);
      if(carDistance <= 0.015){
        console.log('you are near a car: ' + cars[n].brand + " " + cars[n].model);
        //**TODO: Toon melding! */
        
        //safetyIcon.src = "images/warning.png"
        safetyText.innerHTML = "Phone beeps and buzzes!"
      }
      else{
        //safetyIcon.src = "images/safe.png"
        safetyText.innerHTML = "No notifications!"
      }
    }
    

    // Request the next frame of the animation.
    requestAnimationFrame(animateMarker);
    }
     
    // Start the animation.
    requestAnimationFrame(animateMarker);

  
}

//Function to actually update the users position marker on success
function updatePosition(pos){
    //Set center of map and save coords
    lat = pos.coords.latitude;
    lng = pos.coords.longitude;
    //map.setCenter([lng, lat]); //may center map every couple seconds when moving, preventing user to move his overview
    
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

    //Loop over all cars and determine if within capture distance of user's location
    cars.forEach(function(car){
        var carDistance = getDistanceFromLatLonInKm(lat, lng, car.lat, car.lng);
        //Check if carDistance is within allowed capture range (100 meter)
        if(carDistance <= 0.05){
            console.log('you are near a car: ' + car.brand + " " + car.model);

            //**TODO: Toon melding! */
           
            
        }
        
    });
    
}

//Function to show error in console when updating the users position does not succeed
function positionError(err) {
    console.warn('ERROR(' + err.code + '): ' + err.message);
}

//Check user's distance away from a cars's location in KM
function getDistanceFromLatLonInKm(lat1, lng1, lat2, lng2) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2-lat1);  // deg2rad below
    var dLng = deg2rad(lng2-lng1); 
    var a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
      Math.sin(dLng/2) * Math.sin(dLng/2)
      ; 
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    var d = R * c; // Distance in KM
    return d; //Resturn distance in KM
  }
  
  function deg2rad(deg) {
    return deg * (Math.PI/180) //Convert degrees to radial
  }