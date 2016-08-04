
          /*document.getElementById('see_position').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
                // also monitor position as it changes
                navigator.geolocation.watchPosition(showPosition);
            } else {
              console.log("no geolocation support");
            }

            function showPosition(position) {
              var lat = position.coords.latitude;
              var lng = position.coords.longitude;
              var options = { zoom: 13, center: new google.maps.LatLng(lat, lng), mapTypeId: google.maps.MapTypeId.ROADMAP }
              var map = new google.maps.Map(document.getElementById("content"), options);
              var marker = new google.maps.Marker({ position: new google.maps.LatLng(lat, lng) });
              marker.setMap(map);
            }
          }, false);
          */
function getCoordPosition(){
	if(navigator.geolocation){
	    navigator.geolocation.getCurrentPosition(function(position){
	        var latitude = position.coords.latitude;
	        var longitude = position.coords.longitude;
	        var altitude = position.coords.altitude;
	        document.getElementById('geolocation').innerHTML = 'latitude : ' + latitude + '<br />' + 'longitude : ' + longitude + '<br />' + 'altitude : ' + altitude + '<br />';
	    });
	}
}
function showGoogleMap(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        // also monitor position as it changes
        navigator.geolocation.watchPosition(showPosition);
    } else {
      console.log("no geolocation support");
    }

    function showPosition(position) {
    	var lat = position.coords.latitude;
    	var lng = position.coords.longitude;
    	var options = { zoom: 13, center: new google.maps.LatLng(lat, lng), mapTypeId: google.maps.MapTypeId.ROADMAP };
    	var map = new google.maps.Map(document.getElementById("contentMap"), options);
    	var marker = new google.maps.Marker({ position: new google.maps.LatLng(lat, lng) });
    	marker.setMap(map);
    }
}

showGoogleMap();