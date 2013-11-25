{if isset($fields.geo) && $fields.geo.geo_type eq 'yandex'}
    <div id="ymaps-map-id_13401264085565651343" style="width: 350px; height: 300px;"></div>

    <script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=loadMap"></script>
    <script type="text/javascript">
        function getAddress() {ldelim}
            var address = '';
            var part = '';
            {foreach from=$fields.geo.address item=g}
            {if $fields.fields[$g].type neq 'select'}
            part = jQuery('#{$g}').val() + ' ';
            {else}
            part = jQuery('#{$g} :selected').text() + ' ';
            {/if}
            address += part;
            {/foreach}
            return jQuery.trim(address);
            {rdelim}

        function changeAddress() {ldelim}
            var address = getAddress();

            if (address != '') {ldelim}
                ymaps.geocode(address, {ldelim}results: 1, json: true{rdelim}).then(function (res) {ldelim}
                    var object = res.GeoObjectCollection.featureMember[0].GeoObject;
                    var points = object.Point.pos.split(' ');
                    var lat = points[0];
                    var long = points[1];

                    jQuery('#{$fields.geo.latitude}').val(lat);
                    jQuery('#{$fields.geo.longitude}').val(long);

                    schoolsCollection.removeAll();
                    placemark = new ymaps.Placemark([lat, long]);
                    schoolsCollection.add(placemark);
                    map.geoObjects.add(schoolsCollection);

                    map.setCenter([lat, long]);
                    {rdelim});
                {rdelim}
            {rdelim}

        var schoolsCollection = null;
        var map = null;

        function loadMap(ymaps) {ldelim}
            changeAddress();

            schoolsCollection = new ymaps.GeoObjectCollection ();

            {literal}
            var latitude = 82.92159699999996;
            var longitude = 55.029909999994665;

            if (ymaps.geolocation) {
                latitude = ymaps.geolocation.latitude;
                longitude = ymaps.geolocation.longitude;
            }

            map = new ymaps.Map("ymaps-map-id_13401264085565651343", {
                center: [longitude, latitude],
                zoom: 12,
                type: "yandex#map"
            });

            map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));

            placemark = new ymaps.Placemark([longitude, latitude]);
            schoolsCollection.add(placemark);
            map.geoObjects.add(schoolsCollection);

            {/literal}
            {rdelim}


        {if isset($field.info_fields)}
        setInfoFields();
        {/if}

    </script>
{/if}