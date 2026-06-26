@extends("template/mylayout")

@section("title", "Add New User")
@section("aktif-admin", "active")

@section("badan")

<section style="padding-top: 40px; min-height: 80vh; background-color: #f6f9fe;">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="card shadow border-0 rounded-3">
                    
                    <div class="card-header bg-primary text-white py-3 text-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New User
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        
                        <form method="POST" action=""> 
                            @csrf 
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Full Name (Nama Pengguna)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" name="nama" class="form-control" placeholder="e.g. Ali Bin Abu" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Username (Kata Nama)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="katanama" class="form-control" placeholder="Enter username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Password (Kata Laluan)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                    <input type="text" name="katalaluan" class="form-control" placeholder="Enter password" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">User Role (Jenis)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-shield-lock"></i></span>
                                    <select name="jenispengguna" class="form-select" required>
                                        <option value="" disabled selected>-- Select Role --</option>
                                        <option value="admin">Administrator</option>
                                        <option value="user">End User</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid gap-2">
                                <button type="submit" name="btnInsertConfirm" value="Add" class="btn btn-primary fw-bold py-2">
                                    <i class="bi bi-save me-2"></i> Create User
                                </button>
                                <a href="{{ url('/admin/page') }}" class="btn btn-outline-secondary">
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