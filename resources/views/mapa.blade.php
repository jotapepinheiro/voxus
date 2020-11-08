<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voxus Locations</title>

    <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />

    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
    </style>

    <script>
        window.Laravel = {!! json_encode([
                'latitude' => $data->locationUser->latitude,
                'longitude' => $data->locationUser->longitude,
                'cidade' => $data->locationUser->cidade,
                'estado' => $data->locationUser->estado,
                'locations' => $data->locations,

            ]) !!};
    </script>

</head>
<body>
<div id='map'></div>
<script src="https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoiam9hb3BhdWxvcGluaGVpcm8iLCJhIjoiY2tnOTBjbGF4MDNkejJ3cDV0ZmdnajF5aSJ9.DfLWBIHlrL2HhXqyhnWy9w';
    var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
    mapboxClient.geocoding
        .forwardGeocode({
            query: `${window.Laravel.cidade}, ${window.Laravel.estado}`,
            autocomplete: false,
            limit: 1
        })
        .send()
        .then(function (response) {
            if (
                response &&
                response.body &&
                response.body.features &&
                response.body.features.length
            ) {
                var feature = response.body.features[0];

                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: feature.center,
                    zoom: 5
                });

                var popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
                    `<h3>${feature.place_name}</h3>
                    <div style="text-align: center">
                        <p>Latitude</p>
                        <p>Web: ${feature.geometry.coordinates[1]}</p>
                        <p>API : ${window.Laravel.latitude}</p>
                        <p>Longitude</p>
                        <p>Web: ${feature.geometry.coordinates[0]}</p>
                        <p>API: ${window.Laravel.longitude}</p>
                    </div>`
                );

                new mapboxgl.Marker({color: 'red'})
                    .setLngLat(feature.center)
                    .setPopup(popup)
                    .addTo(map);

                window.Laravel.locations.forEach(marker => {
                    new mapboxgl.Marker()
                        .setLngLat([marker.longitude, marker.latitude])
                        .addTo(map);
                });
            }
        });

</script>
</body>
</html>
