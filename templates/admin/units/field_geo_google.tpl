<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
{literal}
    <style>
        #map-canvas {
            height: 400px;
            width: 500px;
            margin: 0px;
            padding: 0px
        }
    </style>
{/literal}

<input type="text" id="point"/>
<input type="button" onclick="lookOnMap()" value="Find" />
<input type="hidden" name="{$field.fields.latitude.name}" id="latitude" value="{$field.fields.latitude.value}" />
<input type="hidden" name="{$field.fields.longitude.name}" id="longitude" value="{$field.fields.longitude.value}" />
<br>

<div id="map-canvas"></div>

{literal}
    <script>

    var map;
    var geocoder;
    var marker = null;

    function lookOnMap () {
        var address = $('#point').val();
        if (address != '') {
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    addMarker(results[0].geometry.location);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    }

    function addMarker(position) {
        $('#latitude').val(position.ob);
        $('#longitude').val(position.pb);

        map.setCenter(position);
        if (marker != null) {
            marker.setMap(null);
        }
        marker = new google.maps.Marker({
            map: map,
            draggable:true,
            position: position
        });
        map.setZoom(11);

        google.maps.event.addListener(marker, 'dragend', function()
        {
            markerDragEnd(marker.getPosition());
        });
    }

    function markerDragEnd(position) {
        $('#latitude').val(position.ob);
        $('#longitude').val(position.pb);
    }

    function initialize() {
        geocoder = new google.maps.Geocoder();

{/literal}
{if isset($field.fields.latitude.value)}
        var position = new google.maps.LatLng({$field.fields.latitude.value}, {$field.fields.longitude.value});
        var mapOptions = {ldelim}
            zoom: 11,
            center: position
        {rdelim};

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        addMarker(position);
{else}
{literal}
        var mapOptions = {
            zoom: 11,
            center: new google.maps.LatLng(34.7071301, 33.022617399999945)
        };

        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = new google.maps.LatLng(position.coords.latitude,
                        position.coords.longitude);
                map.setCenter(pos);
            });
        }

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
{/literal}
{/if}
{literal}
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
{/literal}