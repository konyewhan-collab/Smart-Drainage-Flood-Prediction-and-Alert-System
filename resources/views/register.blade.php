@extends("template/mylayout")

@section("aktif-register", "active") 

@section("title", "Register")

@section("badan")

<section class="d-flex align-items-center" style="min-height: 80vh; background-color: #f6f9fe;">
    <div class="container">
        
        <div class="section-title text-center mb-4">
            <h2>Register</h2>
            <p>Create a new account</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow border-0 rounded-lg">
                    <div class="card-body p-5">
                        
                        {{-- Point action to the new /register route --}}
                        <form method="POST" action="{{ url('/register') }}">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label for="name" class="form-label fw-bold">Username</label>
                                {{-- Changed name='username' to name='name' --}}
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" placeholder="Choose a username">
                                @error("name")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                {{-- Added Phone Number field required by your ERD --}}
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" placeholder="Enter your phone number">
                                @error("phone")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                {{-- Changed name='pwd' to name='password' --}}
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Create a password">
                                @error("password")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                                {{-- Laravel REQUIRES this to be exactly named 'password_confirmation' --}}
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                       placeholder="Retype password">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Register</button>
                            </div>

                            <div class="text-center mt-3">
                                <p class="mb-0 text-secondary">Already have an account? <a href="{{ url('/login') }}" class="text-primary fw-bold" style="text-decoration: none;">Login here</a></p>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection