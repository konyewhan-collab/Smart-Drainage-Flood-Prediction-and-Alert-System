@extends("template/mylayout")

@section("title", "Manage Pictures")
@section("aktif-picture", "active")

@section("badan")

<?php 
    $username = Session::get("username");
    $pictures = DB::table("picture")->where("username", $username)->get();
?>

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <h2 class="fw-bold text-primary mb-4">My Photo Gallery</h2>

        <div class="row">
            
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-cloud-upload-fill me-2"></i> Upload New
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ url('/picture/upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Select Image</label>
                                <input type="file" name="picture" class="form-control" accept="image/*" required>
                                <div class="form-text small">Supported formats: JPG, PNG, JPEG.</div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success fw-bold">
                                    <i class="bi bi-upload me-2"></i> Upload Picture
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-images me-2"></i> My Collection
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        
                        @if($pictures->isEmpty())
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                                <h5 class="text-muted">No pictures yet</h5>
                                <p class="text-muted small">Upload your first photo to see it here!</p>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($pictures as $pic)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                        
                                        <div style="height: 180px; overflow: hidden; background-color: #f8f9fa;">
                                            <img src="{{ asset('pictures/'.$username.'/'.$pic->picture_name) }}" 
                                                 class="w-100 h-100" 
                                                 style="object-fit: cover; transition: transform 0.3s ease;"
                                                 onmouseover="this.style.transform='scale(1.1)'"
                                                 onmouseout="this.style.transform='scale(1)'"
                                                 alt="User Image">
                                        </div>

                                        <div class="card-footer bg-white border-0 text-center py-3">
                                            <form action="{{ url('/picture/delete/'.$pic->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Are you sure you want to delete this picture?')">
                                                    <i class="bi bi-trash-fill me-1"></i> Delete
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