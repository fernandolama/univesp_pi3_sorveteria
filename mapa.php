<!DOCTYPE html>
<html>
<head>
    <title>Mapa de Itamogi</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 600px; width: 100%; }
    </style>
</head>
<body>
    <h3>Mapa de Itamogi</h3>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-21.0764, -47.0497], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.marker([-21.0764, -47.0497]).addTo(map)
            .bindPopup('Itamogi')
            .openPopup();
    </script>
</body>
</html>
