@extends("template/mylayout")

@section("aktif-services", "active")
@section("title", "Available Services")

@section("badan")

<section style="background-color: #f6f9fe; min-height: 80vh; padding-top: 40px;">
    <div class="container">
        
        <div class="section-title text-center mb-5">
            <h2>Our Services</h2>
            <p>Subscribe to our IoT monitoring packages</p>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success shadow-sm text-center">{{ Session::get('success') }}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger shadow-sm text-center">{{ Session::get('error') }}</div>
        @endif

        <div class="row">
            @foreach($services as $svc)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow border-0 h-100 rounded-3">
                    <div class="card-body p-4 text-center">
                        
                        <div class="mb-3">
                            <i class="bi bi-speedometer2 text-primary" style="font-size: 3rem;"></i>
                        </div>
                        
                        <h4 class="card-title fw-bold">{{ $svc->name }}</h4>
                        <p class="card-text text-muted">{{ $svc->description }}</p>
                        <h3 class="text-primary fw-bold my-3">RM {{ number_format($svc->price, 2) }}</h3>
                        
                        <hr class="my-4">

                        @php 
                            // Check the status of this specific service
                            // If key doesn't exist, it means 'New' (null)
                            $status = $mySubs[$svc->id] ?? null; 
                        @endphp

                        @if($status == 'Approved') 
                            <button class="btn btn-success w-100 mb-2" disabled>
                                <i class="bi bi-check-circle-fill me-1"></i> Active (Subscribed)
                            </button>
                            
                            <form action="{{ url('/service/cancel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $svc->id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Are you sure you want to cancel subscription?')">
                                    Cancel Subscription
                                </button>
                            </form>

                        @elseif($status == 'Pending')
                            <button class="btn btn-warning w-100 mb-2 text-dark" disabled>
                                <i class="bi bi-clock-fill me-1"></i> Pending Approval
                            </button>

                            <form action="{{ url('/service/cancel') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $svc->id }}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm w-100" onclick="return confirm('Cancel this request?')">
                                    Cancel Request
                                </button>
                            </form>

                        @elseif($status == 'Rejected')
                            <div class="alert alert-danger py-2 mb-2 small fw-bold">
                                <i class="bi bi-x-circle-fill"></i> Request Rejected
                            </div>

                            <form action="{{ url('/service/subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $svc->id }}">
                                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                    <i class="bi bi-arrow-repeat me-1"></i> Try Again
                                </button>
                            </form>

                        @else
                            <form action="{{ url('/service/subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $svc->id }}">
                                <button type="submit" class="btn btn-outline-primary w-100 fw-bold">
                                    Subscribe Now
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection