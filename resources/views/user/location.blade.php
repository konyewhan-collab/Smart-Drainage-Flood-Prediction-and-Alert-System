@extends("template/mylayout")

@section("aktif-location", "active")
@section("title", "Live GPS Location")

@section("badan")

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 600px; width: 100%; border-radius: 10px; z-index: 1; }
</style>

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
            <div>
                <h4 class="mb-0 fw-bold text-primary">Live Device Tracking</h4>
                <p class="mb-0 text-muted small">Viewing: <strong>{{ $currentDevice->device_name ?? 'ESP32_1' }}</strong></p>
            </div>
            
            <form method="GET" action="{{ url('/location') }}" class="d-flex align-items-center">
                <label class="me-2 fw-bold text-muted small">Location:</label>
                <select name="device_id" class="form-select form-select-sm border-primary" style="width: 250px;" onchange="this.form.submit()">
                    @foreach($myDevices as $dev)
                        <option value="{{ $dev->device_id }}" {{ ($currentDevice->device_id ?? 1) == $dev->device_id ? 'selected' : '' }}>
                            {{ $dev->device_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="card shadow border-0 mb-5">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-geo-alt-fill me-2"></i> Real-Time GPS Map</h5>
            </div>
            <div class="card-body p-2">
                <div id="map"></div>
            </div>
        </div>

    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const currentDeviceId = "{{ $currentDevice->device_id ?? 1 }}";

    // Use the database coordinates, or default to UniSZA coordinates
    const initialLat = {{ $currentDevice->latitude ?? 5.756244 }};
    const initialLng = {{ $currentDevice->longitude ?? 102.639343 }};
    
    const map = L.map('map').setView([initialLat, initialLng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let deviceMarker = L.marker([initialLat, initialLng]).addTo(map)
        .bindPopup("<b>Device #" + currentDeviceId + "</b><br>Fetching live status...")
        .openPopup();

    // --- REAL-TIME MAP UPDATE FUNCTION ---
    function updateMap() {
        const liveUrl = '{{ url("/index.php/dashboard/live-data") }}?device_id=' + currentDeviceId;
        
        fetch(liveUrl)
            .then(response => response.json())
            .then(data => {
                if(!data.latest) return;
                
                const riskLevel = data.latest.risk_level;

                // 1. ALWAYS update the popup text, even if the device hasn't moved
                deviceMarker.setPopupContent("<b>Device #" + currentDeviceId + "</b><br>Status: <b>" + riskLevel + "</b>");

                // 2. ONLY move the physical marker if we received valid GPS coordinates
                if (data.device && data.device.latitude && data.device.longitude) {
                    const newPos = [data.device.latitude, data.device.longitude];
                    deviceMarker.setLatLng(newPos);
                }
            })
            .catch(error => console.error('Map update error:', error));
    }

    // Check for movement every 5 seconds
    setInterval(updateMap, 5000);
    // Run once immediately on load
    updateMap(); 
</script>

@endsection