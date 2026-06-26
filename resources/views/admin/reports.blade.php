@extends("template/mylayout")

@section("title", "System Overview Report")
@section("aktif-admin-report", "active")

@section("badan")

<section style="background-color: #f4f7fc; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <h2 class="fw-bold text-primary mb-4">System Overview Report</h2>

        {{-- TOP SECTION: 3 STATISTIC CARDS --}}
        <div class="row mb-5">
            
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-people-fill text-primary fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 fw-bold">Registered Users</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalUsers }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-cpu-fill text-success fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 fw-bold">Active IoT Devices</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalDevices }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-bell-fill text-danger fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 fw-bold">Total Alerts Triggered</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalAlerts }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- BOTTOM SECTION: ALERT HISTORY TABLE --}}
        <div class="card shadow-sm border-0 rounded-3 mb-5">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Recent System Alerts
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-dark">
                            <tr>
                                <th class="ps-4">Date & Time</th>
                                <th>Location / Device</th>
                                <th>Algorithm Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAlerts as $alert)
                            <tr>
                                <td class="ps-4 text-muted">{{ \Carbon\Carbon::parse($alert->created_at)->format('d M Y | h:i A') }}</td>
                                <td class="fw-bold text-dark">{{ $alert->device_name }}</td>
                                <td>
                                    @php
                                        $badgeColor = 'bg-secondary';
                                        if($alert->risk_level == 'CRITICAL ALERT') $badgeColor = 'bg-danger';
                                        elseif($alert->risk_level == 'FLOOD ALERT') $badgeColor = 'bg-warning text-dark';
                                        elseif($alert->risk_level == 'BLOCKAGE ALERT') $badgeColor = 'bg-info text-dark';
                                    @endphp
                                    <span class="badge {{ $badgeColor }} px-3 py-2 shadow-sm">
                                        {{ $alert->risk_level }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>
                                    No alerts have been triggered yet. The system is operating normally.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Pagination --}}
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                {{ $recentAlerts->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</section>

@endsection