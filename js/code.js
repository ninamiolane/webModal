function toggle(){
$(document).ready(function(){
    $("#tc1").toggle();
    $("#c1").click(function() {
        $("#tc1").slideToggle("slow");
    });
});
}

function success(position) {
    var s = document.querySelector('#status');

    if (s.className == 'success') {
        return;
    }

    s.innerHTML = "found you!";
    s.className = 'success';

    var mapcanvas = document.createElement('div');
    mapcanvas.id = 'mapcanvas';
    mapcanvas.style.height = '400px';
    mapcanvas.style.width = '560px';

    document.querySelector('article').appendChild(mapcanvas);

    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    var myOptions = {
        zoom: 15,
        center: latlng,
        mapTypeControl: false,
        navigationControlOptions: {
            style: google.maps.NavigationControlStyle.SMALL
            },
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title:"You are here!"
    });
}

function error(msg) {
    var s = document.querySelector('#status');
    s.innerHTML = typeof msg == 'string' ? msg : "failed";
    s.className = 'fail';

// console.log(arguments);
}

//if (navigator.geolocation) { // lignes pour mettre en oeuvre la géolocalisation
//    navigator.geolocation.getCurrentPosition(success, error);
//} else {
//    error('not supported');
//}
