@extends("template/mylayout")

@section("aktif-user", "active")
@section("title", "Flood Monitoring Dashboard")

@section("badan")

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
            <div>
                <h4 class="mb-0 fw-bold text-primary">Monitor Dashboard</h4>
                <p class="mb-0 text-muted small">Viewing: <strong>{{ $currentDevice->device_name ?? 'ESP32_1' }}</strong></p>
            </div>
            
            <form method="GET" action="{{ url('/userpage') }}" class="d-flex align-items-center">
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

        <div class="section-title text-center mb-4">
            <h2>Real-Time Monitoring</h2>
            <p>Live data from Sensor: <strong>Device #{{ $latest->device_id ?? 'Connecting...' }}</strong></p>
            
            <div class="mt-2 mb-4">
                <span class="badge bg-primary">System Online</span>
                <span id="connectionStatus" class="badge bg-secondary">Updating...</span>
            </div>

            @php
                // --- INITIAL LOGIC FOR PAGE LOAD ---
                $bannerColor = "alert-success";
                $bannerTitle = "NO RISK";
                $bannerAction = "Conditions Normal";
                $icon = "bi-check-circle-fill";
                $currentRisk = $latest->risk_level ?? 'SAFE';

                if($currentRisk == 'CRITICAL ALERT') {
                    $bannerColor = "alert-danger"; 
                    $bannerTitle = "CRITICAL DANGER";
                    $bannerAction = "Drain Clogged AND Flooding Risk! Evacuate / Clear Drain Immediately!";
                    $icon = "bi-exclamation-triangle-fill";
                } 
                elseif($currentRisk == 'FLOOD ALERT') {
                    $bannerColor = "alert-warning"; 
                    $bannerTitle = "HIGH WATER VOLUME";
                    $bannerAction = "Heavy Flow Detected. Prepare for potential flood.";
                    $icon = "bi-exclamation-circle-fill";
                } 
                elseif($currentRisk == 'BLOCKAGE ALERT') {
                    $bannerColor = "alert-info"; 
                    $bannerTitle = "DRAIN BLOCKED";
                    $bannerAction = "Water is high but stagnant. Clear blockage to prevent future flood.";
                    $icon = "bi-info-circle-fill";
                }
                elseif($currentRisk == 'SAFE (Dry Drain)') {
                    $bannerColor = "alert-secondary"; 
                    $bannerTitle = "DRY DRAIN";
                    $bannerAction = "Water level is too low to measure flow.";
                    $icon = "bi-droplet";
                }
            @endphp

            <div id="live-risk-banner" class="alert {{ $bannerColor }} shadow-sm">
                <h3 class="alert-heading fw-bold mb-1">
                    <i id="live-risk-icon" class="bi {{ $icon }}"></i> 
                    <span id="live-risk-title">{{ $bannerTitle }}</span>
                </h3>
                <p class="mb-0 fs-5" id="live-risk-action">{{ $bannerAction }}</p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card shadow border-0 text-center p-4 h-100">
                    <h5 class="text-muted mb-3">Water Level</h5>
                    <h1 class="display-4 fw-bold text-primary" id="live-water-text">
                        <span id="live-water-level">{{ number_format((float)($latest->water_level ?? 0), 2) }}</span> 
                        <span style="font-size: 20px;">%</span> </h1>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 text-center p-4 h-100">
                    <h5 class="text-muted mb-3">Flow Speed</h5>
                    <h1 class="display-4 fw-bold text-info">
                        <span id="live-flow-speed">{{ number_format((float)($latest->water_flow ?? 0), 2) }}</span> 
                        <span style="font-size: 20px;">m&sup3;/s</span> </h1>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 text-center p-4 h-100">
                    <h5 class="text-muted mb-3"><i class="bi bi-clock-history me-2"></i>Last Update</h5>
                    
                    <h2 class="display-6 fw-bold text-dark mt-2" id="live-time-text">
                        {{ $latest ? \Carbon\Carbon::parse($latest->created_at)->format('H:i:s') : '--:--:--' }}
                    </h2>
                    
                    <p class="text-muted mb-0" id="live-date-text">
                        {{ $latest ? \Carbon\Carbon::parse($latest->created_at)->format('d M Y') : 'Waiting for data...' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            
            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-water me-2"></i>Water Level</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="waterChart" width="100%" height="60"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-info"><i class="bi bi-speedometer2 me-2"></i>Flow Speed</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="flowChart" width="100%" height="60"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. GET CURRENT ID FROM PHP
    const currentDeviceId = "{{ $currentDevice->device_id ?? 1 }}";

    // 2. GET BOTH CANVAS ELEMENTS
    const ctxWater = document.getElementById('waterChart').getContext('2d');
    const ctxFlow = document.getElementById('flowChart').getContext('2d');

    // --- INITIAL DATA SETUP ---
    const initialLabels = [
        @foreach($chartData as $d) "{{ \Carbon\Carbon::parse($d->created_at)->format('H:i:s') }}", @endforeach
    ];
    const waterLevelData = [
        @foreach($chartData as $d) {{ $d->water_level }}, @endforeach
    ];
    const flowSpeedData = [
        @foreach($chartData as $d) {{ $d->water_flow }}, @endforeach
    ];

    // --- CREATE WATER CHART (LEFT) ---
    const waterChart = new Chart(ctxWater, {
        type: 'line',
        data: {
            labels: initialLabels,
            datasets: [{
                label: 'Water Level (%)',
                data: waterLevelData,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2, pointRadius: 3, tension: 0.3, fill: true
            }]
        },
        options: {
            responsive: true, animation: false,
            scales: {
                y: { 
                    beginAtZero: true, 
                    max: 100, // Water is a percentage, so lock max to 100
                    title: { display: true, text: 'Percentage (%)' } 
                }
            }
        }
    });

    // --- CREATE FLOW CHART (RIGHT) ---
    const flowChart = new Chart(ctxFlow, {
        type: 'line',
        data: {
            labels: initialLabels,
            datasets: [{
                label: 'Flow Speed (m³/s)',
                data: flowSpeedData,
                borderColor: '#dc3545', // Red theme for flow
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderWidth: 2, pointRadius: 3, tension: 0.3, fill: true
            }]
        },
        options: {
            responsive: true, animation: false,
            scales: {
                y: { 
                    beginAtZero: true, 
                    title: { display: true, text: 'Cubic Meter Per Second (m³/s)' } 
                }
            }
        }
    });

    // --- REAL-TIME UPDATE FUNCTION ---
    function updateDashboard() {
        const liveUrl = '{{ url("/index.php/dashboard/live-data") }}?device_id=' + currentDeviceId;
        
        fetch(liveUrl)
            .then(async response => {
                if (!response.ok) throw new Error('Network response was ' + response.status);
                return response.json();
            })
            .then(data => {
                if(!data.latest) return;
                
                // A. Update Text Cards (Water & Flow)
                // parseFloat ensures it's a number, toFixed(2) locks it to 2 decimal places
                document.getElementById('live-water-level').innerText = parseFloat(data.latest.water_level).toFixed(2);
                document.getElementById('live-flow-speed').innerText = parseFloat(data.latest.water_flow).toFixed(2);
                
                // B. Update the Clock
                const updateDate = new Date(data.latest.created_at);
                document.getElementById('live-time-text').innerText = updateDate.toLocaleTimeString('en-GB');
                document.getElementById('live-date-text').innerText = updateDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

                // C. Update the Big Banner Status
                const riskLevel = data.latest.risk_level;
                const banner = document.getElementById('live-risk-banner');
                const title = document.getElementById('live-risk-title');
                const action = document.getElementById('live-risk-action');
                const icon = document.getElementById('live-risk-icon');

                if (riskLevel === 'CRITICAL ALERT') {
                    banner.className = "alert alert-danger shadow-sm"; 
                    title.innerText = "CRITICAL DANGER";
                    action.innerText = "Drain Clogged AND Flooding Risk! Evacuate / Clear Drain Immediately!";
                    icon.className = "bi bi-exclamation-triangle-fill";
                } 
                else if (riskLevel === 'FLOOD ALERT') {
                    banner.className = "alert alert-warning shadow-sm"; 
                    title.innerText = "HIGH WATER VOLUME";
                    action.innerText = "Heavy Flow Detected. Prepare for potential flood.";
                    icon.className = "bi bi-exclamation-circle-fill";
                } 
                else if (riskLevel === 'BLOCKAGE ALERT') {
                    banner.className = "alert alert-info shadow-sm"; 
                    title.innerText = "DRAIN BLOCKED";
                    action.innerText = "Water is high but stagnant. Clear blockage to prevent future flood.";
                    icon.className = "bi bi-info-circle-fill";
                } 
                else if (riskLevel === 'SAFE (Dry Drain)') {
                    banner.className = "alert alert-secondary shadow-sm"; 
                    title.innerText = "DRY DRAIN";
                    action.innerText = "Water level is too low to measure flow.";
                    icon.className = "bi bi-droplet";
                }
                else {
                    banner.className = "alert alert-success shadow-sm"; 
                    title.innerText = "NO RISK";
                    action.innerText = "Conditions Normal";
                    icon.className = "bi bi-check-circle-fill";
                }

                document.getElementById('connectionStatus').innerText = "Live";
                document.getElementById('connectionStatus').className = "badge bg-success";

                // D. Update BOTH Charts
                const newLabels = data.chartData.map(item => {
                    const d = new Date(item.created_at);
                    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second:'2-digit' });
                });
                
                const newWaterValues = data.chartData.map(item => item.water_level);
                const newFlowValues = data.chartData.map(item => item.water_flow); 

                // Inject data into Water chart
                waterChart.data.labels = newLabels;
                waterChart.data.datasets[0].data = newWaterValues;
                waterChart.update();

                // Inject data into Flow chart
                flowChart.data.labels = newLabels;
                flowChart.data.datasets[0].data = newFlowValues;
                flowChart.update();
            })
            .catch(error => {
                document.getElementById('connectionStatus').innerText = "Disconnected";
                document.getElementById('connectionStatus').className = "badge bg-danger";
            });
    }

    // Run update every 5 seconds
    setInterval(updateDashboard, 5000);

</script>

@endsection