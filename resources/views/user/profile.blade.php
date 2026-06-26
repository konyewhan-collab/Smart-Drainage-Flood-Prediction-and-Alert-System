@extends("template/mylayout")

@section("title", "My Profile")
@section("aktif-user-profile", "active")

@section("badan")

<?php 
    $user = Auth::user();
    // Get all pictures uploaded by this user
    $pictures = DB::table('picture')->where('username', $user->name)->get();
?>

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <h2 class="fw-bold text-primary mb-4">Account Dashboard</h2>

        <div class="row g-4">
            
            {{-- LEFT COLUMN: PROFILE SETTINGS --}}
            <div class="col-lg-5">
                <div class="card shadow border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-person-circle me-2"></i> Edit Profile
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            @if($user->profile_pic)
                                <img src="{{ asset('pictures/'.$user->name.'/'.$user->profile_pic) }}" 
                                     alt="Profile" 
                                     class="rounded-circle border shadow-sm" 
                                     width="120" height="120" 
                                     style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border shadow-sm" style="width: 120px; height: 120px;">
                                    <i class="bi bi-person text-primary" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <p class="text-muted small mt-2">Role: <strong>{{ $user->userlevel }}</strong></p>
                        </div>

                        <form action="{{ url('/save-profile') }}" method="POST">
                            @csrf
                            
                            {{-- New Avatar Dropdown --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Select Avatar</label>
                                <select name="profile_pic" class="form-select">
                                    <option value="">-- No Avatar --</option>
                                    @foreach($pictures as $p)
                                        <option value="{{ $p->picture_name }}" {{ $user->profile_pic == $p->picture_name ? 'selected' : '' }}>
                                            {{ $p->picture_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Select an image from your Gallery below.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Username (Read Only)</label>
                                <input type="text" name="name" class="form-control bg-light" value="{{ $user->name }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    <i class="bi bi-save me-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: PHOTO GALLERY --}}
            <div class="col-lg-7">
                
                {{-- Upload New Card --}}
                <div class="card shadow border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-cloud-upload-fill me-2"></i> Upload New Image
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ url('/picture/upload') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-3">
                            @csrf
                            <input type="file" name="picture" class="form-control" accept="image/*" required>
                            <button type="submit" class="btn btn-success fw-bold text-nowrap">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Gallery Grid Card --}}
                <div class="card shadow border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-images me-2"></i> My Collection
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($pictures->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No pictures yet</h5>
                                <p class="text-muted small">Upload your first photo above!</p>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($pictures as $pic)
                                <div class="col-sm-6 col-md-4">
                                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                        <div style="height: 150px; overflow: hidden; background-color: #f8f9fa;">
                                            <img src="{{ asset('pictures/'.$user->name.'/'.$pic->picture_name) }}" 
                                                 class="w-100 h-100" 
                                                 style="object-fit: cover; transition: transform 0.3s ease;"
                                                 onmouseover="this.style.transform='scale(1.1)'"
                                                 onmouseout="this.style.transform='scale(1)'"
                                                 alt="Gallery Image">
                                        </div>
                                        <div class="card-footer bg-white border-0 text-center p-2">
                                            <form action="{{ url('/picture/delete/'.$pic->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Delete this picture?')">
                                                    <i class="bi bi-trash-fill"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</section>

@endsection