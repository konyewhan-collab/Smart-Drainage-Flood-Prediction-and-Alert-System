@extends("template/mylayout")

@section("title", "Sensor History Log")
@section("aktif-history", "active")

@section("badan")

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        {{-- TOP HEADER & DROPDOWN --}}
        <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
            <div>
                <h4 class="mb-0 fw-bold text-primary"><i class="bi bi-clock-history me-2"></i>History Log</h4>
                <p class="mb-0 text-muted small">Viewing Data For: <strong>{{ $currentDevice->device_name ?? 'ESP32_1' }}</strong></p>
            </div>
            
            <form method="GET" action="{{ url('/history') }}" class="d-flex align-items-center">
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

        {{-- HISTORY TABLE --}}
        <div class="card shadow border-0 rounded-3 mb-5">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-table me-2"></i> Historical Readings
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>Timestamp</th>
                                <th>Water Level (%)</th>
                                <th>Flow Speed (m&sup3;/s)</th>
                                <th>Algorithm Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historyLogs as $log)
                            <tr>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d | H:i:s') }}</td>
                                
                                <td>
                                    <span class="badge {{ $log->water_level > 80 ? 'bg-danger' : 'bg-primary' }} bg-opacity-75">
                                        {{ $log->water_level }} %
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="badge {{ $log->water_flow > 0 ? 'bg-info text-dark' : 'bg-secondary' }}">
                                        {{ number_format($log->water_flow / 60000, 5) }} m&sup3;/s
                                    </span>
                                </td>
                                
                                <td>
                                    @php
                                        $statusClass = 'bg-success';
                                        if($log->risk_level == 'CRITICAL ALERT') $statusClass = 'bg-danger';
                                        elseif($log->risk_level == 'FLOOD ALERT') $statusClass = 'bg-warning text-dark';
                                        elseif($log->risk_level == 'BLOCKAGE ALERT') $statusClass = 'bg-info text-dark';
                                        elseif($log->risk_level == 'SAFE (Dry Drain)') $statusClass = 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-3 py-2 shadow-sm">
                                        {{ $log->risk_level ?? 'No Data' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">No historical data available for this device.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Pagination Links --}}
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $historyLogs->withQueryString()->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>

    </div>
</section>

@endsection