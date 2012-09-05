<script type="text/javascript">
    lx.data['[[+id]]'] = {
        markers: [[+data]],
        markerObjs: [],
        markerIds: [],
        mapOptions: {
            center: new google.maps.LatLng([[+center_lat]], [[+center_lng]]),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        },
        map: null
    };
    lx.initMap('[[+id]]');

    google.maps.event.addListener(lx.data['[[+id]]'].map, 'idle', function() {
        var bounds = lx.data['[[+id]]'].map.getBounds();
        if (typeof jQuery != 'undefined') {
            $.ajax({
                data: {
                    northeast: bounds.getNorthEast().toString(),
                    southwest: bounds.getSouthWest().toString(),
                    exclude: lx.data['[[+id]]'].markerIds,
                    [[+id]]Ajax: true
                },
                success: function(data) {
                    data = jQuery.parseJSON(data);
                    lx.addMarkers('[[+id]]', data);
                }
            });
        }
    });
</script>
