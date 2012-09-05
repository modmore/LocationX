<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false[[+key:notempty=`&key=[[+key]]`]]"></script>

<script type="text/javascript">
    var lx = {
        data: { }
    };
    lx.initMap = function (id) {
        if (!lx.data[id]) return false;
        lx.data[id].map = new google.maps.Map(document.getElementById(id), lx.data[id].mapOptions);

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0; i < lx.data[id].markers.length; i++) {
            var marker = lx.data[id].markers[i];

            for (var locationId in marker.items) {
                if (marker.items.hasOwnProperty(locationId)) {
                    var location = marker.items[locationId];
                    var locationMarker = {
                        position: new google.maps.LatLng(location.latitude, location.longitude),
                        map: lx.data[id].map,
                        draggable: false,
                        animation: google.maps.Animation.DROP
                    };
                    if (marker.image != '') locationMarker.icon = marker.image;
                    lx.data[id].markerObjs.push(new google.maps.Marker(locationMarker));
                    bounds.extend(locationMarker.position);
               }
            }
        }

        lx.data[id].map.fitBounds(bounds);
        /*markers.push(new google.maps.Marker({
          position: neighborhoods[iterator],
          map: lx.data[id].map,
          draggable: false
        }));*/
    }
</script>
