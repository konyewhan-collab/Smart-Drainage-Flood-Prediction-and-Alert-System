@extends("template/mylayout")

@section("title", "Manage IoT Devices")
@section("aktif-admin-service", "active") {{-- Matches your menu highlight --}}

@section("badan")

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <h2 class="fw-bold text-primary mb-4"><i class="bi bi-cpu-fill me-2"></i>Manage IoT Devices</h2>

        {{-- Show Success Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            
            {{-- LEFT COLUMN: ADD NEW DEVICE FORM --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-plus-circle-fill me-2"></i> Register New Device
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ url('/admin/services/add') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Device Name</label>
                                <input type="text" name="device_name" class="form-control" placeholder="e.g., ESP32_Zone_A" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Default Latitude (Optional)</label>
                                <input type="text" name="latitude" class="form-control" placeholder="e.g., 5.756244">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">Default Longitude (Optional)</label>
                                <input type="text" name="longitude" class="form-control" placeholder="e.g., 102.639343">
                                <div class="form-text small">If left blank, the GPS module will update this automatically once powered on.</div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    <i class="bi bi-save me-2"></i> Save Device
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: DEVICE TABLE --}}
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-list-ul me-2"></i> Registered Devices
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Device Name</th>
                                        <th>Coordinates</th>
                                        <th>Registered Date</th>
                                        <th class="text-center pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($devices as $dev)
                                    <tr>
                                        <td class="ps-4 fw-bold">#{{ $dev->device_id }}</td>
                                        <td>
                                            <span class="badge bg-primary rounded-pill px-3">{{ $dev->device_name }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                Lat: {{ $dev->latitude ?? 'Waiting for GPS...' }} <br>
                                                Lng: {{ $dev->longitude ?? 'Waiting for GPS...' }}
                                            </small>
                                        </td>
                                        <td><small class="text-muted">{{ \Carbon\Carbon::parse($dev->created_at)->format('d M Y') }}</small></td>
                                        <td class="text-center pe-4">
                                            <form action="{{ url('/admin/services/delete/'.$dev->device_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('WARNING: This will delete the device and ALL of its sensor history! Are you sure?')">
                                                    <i class="bi bi-trash-fill"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No devices found in the database.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection