<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false[[+key:notempty=`&key=[[+key]]`]]"></script>

<script type="text/javascript">
    var lx = {
        data: { }
    };
    lx.initMap = function (id) {
        if (!lx.data[id]) return false;
        lx.data[id].map = new google.maps.Map(document.getElementById(id), lx.data[id].mapOptions);
        lx.addMarkers(id, lx.data[id].markers);

        var bounds = new google.maps.LatLngBounds();
        for (var key in lx.data[id].markerObjs) {
            if (lx.data[id].markerObjs.hasOwnProperty(key)) {
                bounds.extend(lx.data[id].markerObjs[key].getPosition());
            }
        }
        lx.data[id].map.fitBounds(bounds);
    };
    lx.addMarkers = function (id, data) {
        for (var i = 0; i < data.length; i++) {
            var marker = data[i];

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
                    lx.data[id].markerIds.push(locationId);
               }
            }
        }
    };
</script>
