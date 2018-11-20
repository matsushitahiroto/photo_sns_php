function initMap() {
  'use strict';

  var target = document.getElementById('target');
  var map;
  var lat = document.getElementById('lat').value;
  var lng = document.getElementById('lng').value;
  var centerPosition = new google.maps.LatLng(lat, lng);
  var contentString = '<p>' + '<strong>' + document.getElementById('title').value + '</strong>' + '</br>' + document.getElementById('description').value + '</p>';
  var marker;
  var infoWindow
  var geocoder = new google.maps.Geocoder();

  map = new google.maps.Map(target, {
    center: centerPosition,
    zoom: 15
  });

  marker = new google.maps.Marker({
    position: centerPosition,
    map: map,
    title: document.getElementById('title').value,
    animation: google.maps.Animation.BOUNCE
  });

  infoWindow = new google.maps.InfoWindow({
    position: centerPosition,
    content: contentString
  });

  marker.addListener('click', function() {
    infoWindow.open(map, marker);
  });

}
