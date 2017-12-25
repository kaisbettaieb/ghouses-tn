var mark;
var map;
var posLat;
var posLng;
function initMap() {
    map = new google.maps.Map(document.getElementById('map-container'), {
        zoom: 7,
        center: {
            lat: 36.862609,
            lng: 10.332946
        },
    });
    map.addListener('click', function (e) {
        if (mark && mark.getMap()) {
            mark.setPosition(e.latLng);
        } else {
            placeMarkerAndPanTo(e.latLng, map);
        }
        posLat = e.latLng.lat();
        posLng = e.latLng.lng();
    });
}
// Delete one marker
function deleteMarker(mark) {
    mark.setMap(null);
}

function placeMarkerAndPanTo(latLng, map) {
    mark = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        title: "La positon de votre maison",
        animation: google.maps.Animation.DROP
    });
    map.panTo(latLng);
    google.maps.event.addListener(mark, 'rightclick', function (point) {
        deleteMarker(mark);
    });
}


$(document).ready(function () {

    $('#ght-navbar').removeClass("navbar-dark");
    $('#ght-navbar').addClass("navbar-light ght-add-navbar");

    $('#ajouter').click(function(){
        console.log(posLat);
        console.log(posLng);
        });
});
