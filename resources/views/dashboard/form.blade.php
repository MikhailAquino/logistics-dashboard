@extends('layouts.app')

@section('content')
<div
    x-data="{ modalOpen: {{ session('alertData') ? 'true' : 'false' }} }"
    class="flex items-center justify-center min-h-screen"
>
    <div class="bg-white shadow-lg rounded-xl p-10 w-[600px] max-w-full">
        <h2 class="text-3xl font-bold mb-6 text-[#3b167c] text-center">Proximity Alert</h2>
        {{-- Interactive Map --}}
        <div
            id="map"
            :class="{ 'blur-sm pointer-events-none': modalOpen }"
            style="height: 320px; border-radius: 12px; margin-bottom: 1.5rem; transition: filter 0.3s;"
        ></div>
        <form method="POST" action="{{ route('check.proximity') }}" class="space-y-4" id="proximity-form">
            @csrf
            <div>
                <label class="block text-gray-700 font-medium mb-1">Delivery Latitude</label>
                <input type="text" name="lat" id="delivery-lat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3b167c]" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Longitude</label>
                <input type="text" name="lng" id="delivery-lng" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3b167c]" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Alert Radius (m)</label>
                <select name="radius" id="radius" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3b167c]">
                    <option value="100">100m</option>
                    <option value="250" selected>250m</option>
                    <option value="500">500m</option>
                </select>
            </div>
            <button type="submit"
                class="w-full py-2 px-4 bg-[#3b167c] text-white font-semibold rounded-lg shadow hover:bg-purple-800 transition">
                Check Proximity
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-[#3b167c] hover:underline">← Back to Welcome</a>
        </div>
    </div>

    {{-- Modal for Alerts, with blurred background --}}
    @if(session('alertData'))
        <div
            x-show="modalOpen"
            x-transition.opacity
            @keydown.escape.window="modalOpen = false"
            class="fixed inset-0 flex items-center justify-center z-50 bg-white/40 backdrop-blur"
        >
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm relative">
                <button @click="modalOpen = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                @php $data = session('alertData') @endphp
                @if (isset($data['within_range']) && isset($data['distance']))
                    @if ($data['within_range'])
                        <p class="text-green-600 font-semibold">Delivery is within {{ $data['distance'] }} meters!</p>
                    @else
                        <p class="text-red-600 font-semibold">Delivery is {{ $data['distance'] }} meters away.</p>
                    @endif
                @elseif (isset($data['error']))
                    <p class="text-red-600 font-semibold">Error: {{ $data['error'] }}</p>
                @else
                    <p class="text-gray-500">No result received from the API.</p>
                @endif
            </div>
        </div>
    @endif
</div>
{{-- Leaflet.js CDN --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Default coordinates (e.g., Manila)
    const defaultWarehouse = [14.5995, 120.9842];
    const defaultDelivery = [14.6000, 120.9850];

    let map, warehouseMarker, deliveryMarker, radiusCircle;

    function initMap(warehouseCoords = defaultWarehouse, deliveryCoords = defaultDelivery, radius = 250) {
        if (map) {
            map.remove();
        }
        map = L.map('map').setView(warehouseCoords, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        warehouseMarker = L.marker(warehouseCoords, { draggable: false, icon: L.icon({iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png', iconSize: [30, 30]}) })
            .addTo(map)
            .bindPopup('Warehouse')
            .openPopup();

        deliveryMarker = L.marker(deliveryCoords, { draggable: true })
            .addTo(map)
            .bindPopup('Delivery')
            .openPopup();

        radiusCircle = L.circle(warehouseCoords, {
            radius: radius,
            color: '#7c3aed',
            fillColor: '#c4b5fd',
            fillOpacity: 0.3
        }).addTo(map);

        // Initial form fill on page load
        document.getElementById('delivery-lat').value = deliveryCoords[0];
        document.getElementById('delivery-lng').value = deliveryCoords[1];

        // Update form fields when delivery marker is dragged
        deliveryMarker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            document.getElementById('delivery-lat').value = pos.lat.toFixed(6);
            document.getElementById('delivery-lng').value = pos.lng.toFixed(6);
        });

        // Update map when radius changes
        document.getElementById('radius').addEventListener('change', function() {
            const newRadius = parseFloat(this.value);
            radiusCircle.setRadius(newRadius);
        });

        // Also update marker when form fields change
        document.getElementById('delivery-lat').addEventListener('input', updateDeliveryMarker);
        document.getElementById('delivery-lng').addEventListener('input', updateDeliveryMarker);
    }

    function updateDeliveryMarker() {
        const lat = parseFloat(document.getElementById('delivery-lat').value);
        const lng = parseFloat(document.getElementById('delivery-lng').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            deliveryMarker.setLatLng([lat, lng]);
            map.panTo([lat, lng]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const radius = parseFloat(document.getElementById('radius').value) || 250;
        initMap(defaultWarehouse, defaultDelivery, radius);
    });
</script>
@endsection