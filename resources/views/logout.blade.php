@extends("template/mylayout")

@section("title", "Logout Confirmation")

@section("badan")

<section class="d-flex align-items-center" style="min-height: 60vh; background-color: #f6f9fe;">
    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow border-0 rounded-lg">
                    <div class="card-body p-5 text-center">
                        
                        <div class="mb-4">
                            <i class="bi bi-box-arrow-right text-danger" style="font-size: 3rem;"></i>
                        </div>

                        <h3 class="mb-3">Sign Out</h3>
                        <p class="text-muted mb-4">Are you sure you want to log out of your account?</p>

                        <div class="d-grid gap-2">
                            
                            {{-- CHANGED: Must be a secure POST form, not a simple <a> link --}}
                            <form method="POST" action="{{ url('/logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-lg w-100 mb-2">Yes, Logout</button>
                            </form>
                            
                            {{-- Cancel safely returns to the dashboard --}}
                            <a href="{{ url('/userpage') }}" class="btn btn-outline-secondary">Cancel</a>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection