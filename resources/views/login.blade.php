@extends("template/mylayout")

@section("aktif-login", "active")

@section("title","Login")

@section("badan")

<section class="d-flex align-items-center" style="min-height: 70vh; background-color: #f6f9fe;">
    <div class="container">
        
        <div class="section-title text-center mb-4">
            <h2>Login</h2>
            <p>Please sign in to continue</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow border-0 rounded-lg">
                    <div class="card-body p-5">
                        
                        {{-- Check if the user is already logged in securely --}}
                        @if(Auth::check())
                            <div class="text-center">
                                <h4 class="mb-4">Welcome, {{ Auth::user()->name }}!</h4>
                                
                                {{-- Logout must be a POST request for security --}}
                                <form method="POST" action="{{ url('/logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Logout</button>
                                </form>
                            </div>
                        @else
                            {{-- Point action to the new /login route --}}
                            <form method="POST" action="{{ url('/login') }}">
                                @csrf
                                
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label fw-bold">Username</label>
                                    {{-- Changed name from 'username' to 'name' --}}
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" placeholder="Enter your username">
                                    @error("name")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    {{-- Changed name from 'pwd' to 'password' --}}
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter your password">
                                    @error("password")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                                </div>

                                <div class="text-center mt-3">
                                    <p class="mb-0 text-secondary">
                                        Don't have an account? 
                                        <a href="{{ url('/register') }}" class="text-primary fw-bold" style="text-decoration: none;">Register</a>
                                    </p>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection