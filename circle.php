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
      <input onclick="clearMarkers();" type=button value="Hide Markers">
      <input onclick="showMarkers();" type=button value="Show All Markers">
      <input onclick="deleteMarkers();" type=button value="Delete Markers">
      <input onclick="showLocations();" type=button value="View Locations">

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

      function initMap() {
        var haightAshbury = {lat: 41.878, lng: -87.629};
//lat: 37.769, lng: -122.446}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: haightAshbury,
          mapTypeId: 'terrain'
        });

        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
          addMarker(event.latLng);
        });


        // Adds a marker at the center of the map.            
        addMarker(haightAshbury);
        

      }

      // Adds a marker to the map and push to the array.
      function addMarker(location) {
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
        
        markers.push(marker);
        marker.addListener('click', function() {
          //map.setZoom(map.zoom+2);
          //map.setCenter(marker.getPosition());
          //alert(markers[markers.length-1].position);
          //deleteMarker(markers.length-1);
          //alert(marker.position);
          deleteMarker(marker.position);

        });
        

        createCircle(location);//save for reference in text
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
      radius: 300,
      //iden = location.toString()
    });
locations.push(cityCircle);

      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        //clearMarkers();
       //markers.remove(0); 
       //markers.splice(0,1);
       //delete markers[0];
       markers[1].setMap(null);

        //markers = [];
      }
      function showLocations(){
        alert(locations.toString());
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
            }
        }


      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHMk7Rc6Faz3k2EOd-6jRcLfBu7VrSj-w&callback=initMap">
    </script>
  </body>
</html>