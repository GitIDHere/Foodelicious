function initMap()
{
    // https://snazzymaps.com/explore
    // https://github.com/atmist/snazzy-info-window

    var mapStyle = [ { "featureType": "all", "elementType": "labels", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.park", "elementType": "geometry.fill", "stylers": [ { "color": "#aadd55" } ] }, { "featureType": "road.highway", "elementType": "labels", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.arterial", "elementType": "labels.text", "stylers": [ { "visibility": "on" } ] }, { "featureType": "road.local", "elementType": "labels.text", "stylers": [ { "visibility": "on" } ] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [ { "color": "#0099dd" } ] } ]

    // Create the map
    var map = new google.maps.Map($('.gMap')[0], {
        zoom: 15,
        scrollwheel: false,
        styles: mapStyle,
        center: new google.maps.LatLng(51.5280422, -0.0070519)
    });

    var icon = {
        url: 'img/core-img/map_pin.png', // url
        scaledSize: new google.maps.Size(40, 50), // scaled size
        origin: new google.maps.Point(0,0), // origin
        anchor: new google.maps.Point(0, 0) // anchor
    };

    var marker = new google.maps.Marker({
        map: map,
        icon: icon,
        position: new google.maps.LatLng(51.5280422, -0.0070519)
    });
}
