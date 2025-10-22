"use strict";
var map;

function initMap() {
  var inputs = document.getElementsByClassName('search-address');
  Array.prototype.forEach.call(inputs, function (input) {
    var searchBox = new google.maps.places.SearchBox(input);
  });
}

$(document).ready(function () {
  $('#search-button').on('click',function () {
    var input = $('.search-address').val();
    $('.search-address').val('');

    var request = {
      query: input,
      fields: ['name', 'geometry']
    };

    var service = new google.maps.places.PlacesService(map);
    service.findPlaceFromQuery(request, function (results, status) {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        var bounds = new google.maps.LatLngBounds();
        results.forEach(function (place) {
          if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
      } else {
        console.error('Search failed with status: ' + status);
      }
    });
  });
});
