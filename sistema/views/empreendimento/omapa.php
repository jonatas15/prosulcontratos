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
    var kmlLayer = omnivore.kml('/arquivos/passivos/doc.kml').on('ready', function() {
        map.fitBounds(kmlLayer.getBounds());
        this.eachLayer(function(layer) {
            layer.bindPopup(layer.feature.properties.name);
        });
    });
    var kmlLayer2 = omnivore.kml('/arquivos/mdulosamostraiscorrigido/doc.kml').on('ready', function() {
        map.fitBounds(kmlLayer2.getBounds());
        this.eachLayer(function(layer) {
            layer.bindPopup(layer.feature.properties.name);
        });
    });
    kmlLayer.addTo(map);
    kmlLayer2.addTo(map);

    // L.control.layers(null, { 'KML Layer': kmlLayer }).addTo(map);
    L.control.layers({ 'Satélite': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
        maxZoom: 18,
    }) }, { 
        'KML Layer': kmlLayer,
        'Polígonal': kmlLayer2,
    }).addTo(map);
</script>