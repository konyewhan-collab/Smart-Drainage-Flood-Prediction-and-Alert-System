@extends("template/mylayout")

@section("title", "IoT Data Log")
@section("aktif-manage-iot", "active") {{-- Matches your menu highlight --}}

@section("badan")

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary mb-0"><i class="bi bi-database-fill me-2"></i>IoT Sensor Log</h2>
          
        </div>

        <div class="card shadow border-0 rounded-3 mb-5">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-table me-2"></i> Historical Data Records
                </h5>
                <span class="badge bg-primary rounded-pill">Total Records: {{ $sensorLogs->total() }}</span>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-dark text-light">
                            <tr>
                                <th class="ps-4">Record ID</th>
                                <th>Device Name</th>
                                <th>Water Level (%)</th>
                                <th>Flow Speed (m³/s)</th>
                                <th>Algorithm Status</th> <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sensorLogs as $log)
                            <tr>
                                <td class="ps-4 text-muted">#{{ $log->sensor_id }}</td>
                                <td class="fw-bold text-primary">{{ $log->device_name }}</td>
                                
                                <td>
                                    <span class="badge {{ $log->water_level > 80 ? 'bg-danger' : 'bg-info' }}">
                                        {{ $log->water_level }} %
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="badge {{ $log->water_flow > 0 ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $log->water_flow }} m&sup3;/s
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
                                    <span class="badge {{ $statusClass }}">
                                        {{ $log->risk_level ?? 'No Data' }}
                                    </span>
                                </td>
                                
                                <td class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y | H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No sensor data has been recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Laravel Built-in Pagination Links --}}
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $sensorLogs->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</section>


@endsection