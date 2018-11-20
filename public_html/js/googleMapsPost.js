function initMap() {
  'use strict';

  var target = document.getElementById('target');
  var map = map;
  var tokyo = {lat:35.681167, lng:139.767052};
  var geocoder = new google.maps.Geocoder();

  if (!navigator.geolocation) {
    alert('Geolocation not supported!');
    return;
  }

  map = new google.maps.Map(target, {
    center: tokyo,
    zoom: 15
  });

  // navigator.geolocation.getCurrentPosition(function (position) {
  //   map.setCenter({
  //       lat: position.coords.latitude,
  //       lng: position.coords.longitude
  //   });
  // }, function () {
  //   alert('Geolocation failed!');
  //   return;
  // });
  //
  // document.getElementById('search').addEventListener('click', function() {
  //   geocoder.geocode({
  //     address: document.getElementById('keyword').value
  //   }, function(results, status) {
  //     if (status !== 'OK') {
  //       alert('Failed: ' + status);
  //       return;
  //     }
  //     if (results[0]) {
  //       map.setCenter(results[0].geometry.location);
  //     } else {
  //       alert('No results found!');
  //       return;
  //     }
  //   });
  // });

  map.addListener('click', function(e) {
    geocoder.geocode({
      location: e.latLng
    }, function(results, status) {
      if (status !== 'OK') {
        alert('Failed: ' + status);
        return;
      }
      if (results[0]) {
        map.setCenter(results[0].geometry.location);
        document.getElementById('address').value = results[0].formatted_address;
        document.getElementById('lat').value = e.latLng.lat();
        document.getElementById('lng').value = e.latLng.lng();
      } else {
        alert('No results found!');
        return;
      }
    });
  });

}
