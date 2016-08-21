<!DOCTYPE html>
<html>
  <head>
    <title>Remove Markers</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div id="floating-panel">
      <!--<input onclick="clearMarkers();" type=button value="Hide Markers">
      <input onclick="showMarkers();" type=button value="Show All Markers">
      <input onclick="deleteMarkers();" type=button value="Delete Markers">
      <input onclick="showLocations();" type=button value="View Locations">
    -->
    <input onclick="isInside();" type=button value="Start">

    </div>
    <div id="map"></div>
    <p>Click on the map to add markers.</p>
    <script>
      // In the following example, markers appear when the user clicks on the map.
      // The markers are stored in an array.
      // The user can then click an option to hide, show or delete the markers.
      var map;
      var markers = [];
      var locations=[];
      var places=[];
      var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      var labelIndex = 0;
      var geocoder;
      var infoWindow;
      var nameLocation;
      var home;
      var univ;
      var currLocation;

      function initMap() {
        //var currLocation = {lat: 41.878, lng: -87.629};//chicago
        //lat: 37.769, lng: -122.446}     
                                                                                                                                                                                                                                                       
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          mapTypeId: 'terrain'
        });
        geocoder = new google.maps.Geocoder;

        initcurrLocation();//find current location based on GPS

        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
          addMarker(event.latLng);
        });


        // Adds a marker at the center of the map.            
        //addMarker(currLocation);
        

      }

      // Adds a marker to the map and push to the array.
      function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map,
          label: labels[labelIndex++ % labels.length],

        });
//alert(location);
        

        //alert(location);
               // alert(home);
        markers.push(marker);
        marker.addListener('click', function() {
          //map.setZoom(map.zoom+2);
          //map.setCenter(marker.getPosition());
          //alert(markers[markers.length-1].position);
          //deleteMarker(markers.length-1);
          //alert(marker.position);
          deleteMarker(marker.position);
          console.log(marker.position);

        });
        createCircle(location);//save for reference in text
        var stLoc = location.toString();
        var ctrLoc  = stLoc.length;
        stLoc = stLoc.substring(1,ctrLoc-1);//string location
        geocodeLatLng(stLoc);//getting the name of the street/place
        
        var latlngStr = stLoc.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
       univ = latlng;

        //marker.title = "hello";//cant show :)
/*
if(google.maps.geometry.poly.containsLocation(stLoc, location[0])){
          alert("within");
        }
        else
          alert("not");
        
*/
//{lat: 25.774, lng: -80.19},
//alert("a"+(new google.maps.Circle({center: new google.maps.LatLng(41.878, -87.629),radius: 271485600})).getBounds().contains(google.maps.LatLng(25.774, -80.19)));

      }

      function createCircle(location){
        //alert('hi');
        //locations.push(location);
        var cityCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: location,
        radius: 100,
        customInfo:'g'
        //iden = location.toString()
        });
        //isInside(cityCircle,univ);//check if point is inside
        locations.push(cityCircle);

      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {//not used
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }
      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {//not used
        //
        setMapOnAll(null);
      }
      // Shows any markers currently in the array.
      function showMarkers() { //not used
        //
        setMapOnAll(map);
      }
      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() { //not used
        //clearMarkers(); 
       //markers.remove(0); 
       //markers.splice(0,1);
       //delete markers[0];
       markers[1].setMap(null);

        //markers = [];
      }
      function showLocations(){ //not used
        //
        alert(locations.toString());
      }
      function showPlaces(){ //not used
        //
        alert(places.toString());
      }

      function deleteMarker(locIndex){
        //alert(locIndex);
        for(var marker in markers)
        {
            if(markers[marker].position==locIndex)
            {
              //alert("delete"+marker);
              markers[marker].setMap(null);
              //alert(locations[marker].center);
              locations[marker].setMap(null);
              //labels[marker
            }
        }
      }

      function initcurrLocation(){
         infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            


            infoWindow.setPosition(pos);
            infoWindow.setContent('Currently here.');
            map.setCenter(pos);
            //alert(pos.toString());
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function geocodeLatLng(input){
        
        //var input = document.getElementById('latlng').value;

        var latlngStr = input.split(',', 2);
        // alert('here');
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            
            if (results[1]) {
              places.push(results[1].formatted_address);
              /*
              map.setZoom(11);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[1].formatted_address);
              infowindow.open(map, marker);
              */
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }

      function isInside(){//latlng no parenthesis

        
        setInterval(function(){myLocation();}, 1000);
        
          
      }
      function myLocation(){
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            
           currLocation = new google.maps.LatLng(pos);
          
          for (var i = 0; i < locations.length; i++) {
              if(locations[i].getBounds().contains(currLocation) && locations[i].customInfo=='g'){
                  alert("send text. loc" +(i+1)+". ->"+locations[i].customInfo +" here at "+places[i]);
                  locations[i].customInfo = 'b';
                  sendSMS(places[i]);
              }
             
            }
           //var latlngStr = currLocation.split(',', 2);

        //currLocation = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};

           //alert(currLocation);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function sendSMS(p){
        
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            alert("SMS sent");
          }
        };
        xhttp.open("GET", "www.syngkit.tk/devcup/chikka.php?place="+p, true);
        xhttp.send();
      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHMk7Rc6Faz3k2EOd-6jRcLfBu7VrSj-w&libraries=geometry&callback=initMap">
    </script>


  </body>
</html>