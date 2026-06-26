@extends("template/mylayout")

@section("title", "Edit User")
@section("aktif-admin", "active")

@section("badan")

<section style="padding-top: 40px; min-height: 80vh; background-color: #f6f9fe;">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="card shadow border-0 rounded-3">
                    
                    <div class="card-header bg-warning text-dark py-3 text-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i> Edit User
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        
                        <form method="POST" action=""> 
                            @csrf 
                            
                            <input type="hidden" name="id" value="{{ $data->id }}">

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Full Name (Nama Pengguna)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Username (Kata Nama)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="katanama" class="form-control" value="{{ $data->katanama }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Password (Kata Laluan)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                    <input type="text" name="katalaluan" class="form-control" value="{{ $data->katalaluan }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">User Role (Jenis)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-shield-lock"></i></span>
                                    <select name="jenispengguna" class="form-select" required>
                                        <option value="" disabled>-- Select Role --</option>
                                        
                                        <option value="admin" {{ $data->jenispengguna == 'admin' ? 'selected' : '' }}>
                                            Administrator
                                        </option>
                                        
                                        <option value="user" {{ $data->jenispengguna == 'user' ? 'selected' : '' }}>
                                            End User
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid gap-2">
                                <button type="submit" name="btnEditConfirm" value="Save" class="btn btn-warning fw-bold py-2">
                                    <i class="bi bi-check-circle-fill me-2"></i> Save Changes
                                </button>
                                <a href="{{ url('/adminpage') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection