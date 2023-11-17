<style>
    #map {
        width: 100% !important;
        min-height: 1000px !important;
    }
</style>

<?php
    function randomColorRGB() {
        $red = mt_rand(0, 255);
        $green = mt_rand(0, 255);
        $blue = mt_rand(0, 255);

        return "rgb($red, $green, $blue)";
    }
    $i = 1;
    $j = 1;
    $kmz_omnivore = "";
    $kmz_kmls = "";
    $legendas_kml = "";
    foreach ($mapas as $mapa) {
        // echo $mapa;
        $pos = strpos($mapa, 'kmz');
        if ($pos) {
            $pasta = str_replace('.kmz', '', $mapa);
            $kmz_omnivore .= "var kmlLayer_$i = omnivore.kml('/arquivos/$pasta/doc.kml').on('ready', function() {
                map.fitBounds(kmlLayer_$i.getBounds());
                this.eachLayer(function(layer) {
                    layer.bindPopup(layer.feature.properties.description + ' ');
                    console.log(layer.feature.properties);
                });
                this.setStyle({color: \"".randomColorRGB()."\"});
            });
            kmlLayer_$i.addTo(map);";
            
            // $legendas_kml .= 'kmlLayer_'.$i.'.eachLayer(function(layer) {
            //     div.innerHTML += \'<p>\' + layer.feature.properties.name + \'</p>\';
            // });';

            $kmz_kmls .= "
                '$i: $pasta': kmlLayer_$i,
            ";
            $i++;
        }
    }
?>

<div id="map" style="height: 400px;"></div>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>

<script>
    var latitude = -15.7801;
    var longitude = -47.9292;
    var zoom = 12;
    var map = L.map('map').setView([latitude, longitude], zoom);

    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Carregue o arquivo KML usando leaflet-omnivore
    // var kmlLayer = omnivore.kml('/arquivos/passivos/doc.kml').on('ready', function() {
    //     map.fitBounds(kmlLayer.getBounds());
    //     this.eachLayer(function(layer) {
    //         layer.bindPopup(layer.feature.properties.name);
    //     });
    // });
    // var kmlLayer2 = omnivore.kml('/arquivos/mdulosamostraiscorrigido/doc.kml').on('ready', function() {
    //     map.fitBounds(kmlLayer2.getBounds());
    //     this.eachLayer(function(layer) {
    //         layer.bindPopup(layer.feature.properties.name);
    //     });
    // });
    // kmlLayer.addTo(map);
    // kmlLayer2.addTo(map);
    // Adicione um controle de legenda
    /*
    var legendControl = L.control({ position: 'bottomright' });
    legendControl.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML += '<h4>Legenda</h4>';

        // Adicione nomes dos pontos à legenda
        <?php //=$legendas_kml?>

        return div;
    };
    */

    <?= $kmz_omnivore; ?>
    

    // L.control.layers(null, { 'KML Layer': kmlLayer }).addTo(map);
    L.control.layers({ 'Arquivos': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
        maxZoom: 18,
    }) }, { 
        <?= $kmz_kmls; ?>
    }).addTo(map);
</script>