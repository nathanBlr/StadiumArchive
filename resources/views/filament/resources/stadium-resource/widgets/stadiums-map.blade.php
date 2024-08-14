<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([20, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var stadiums = @json($stadiums);

        stadiums.forEach(function (stadium) {
            var city = stadium.city;
            var total = stadium.total;

            // Dummy coordinates for example purposes, replace with real data
            var coordinates = getCityCoordinates(city);

            var marker = L.marker(coordinates).addTo(map);
            marker.bindPopup('<b>' + city + '</b><br>Total stadiums: ' + total);
        });

        function getCityCoordinates(city) {
            // Add real coordinates for each city
            var coordinates = {
                'New York': [40.7128, -74.0060],
                'London': [51.5074, -0.1278],
                // Add more cities as needed
            };

            return coordinates[city] || [0, 0]; // Default to [0, 0] if city not found
        }
    });
</script>
    </x-filament::section>
</x-filament-widgets::widget>
