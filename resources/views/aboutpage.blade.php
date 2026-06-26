@extends("template/mylayout")

@section("aktif-about","active")
@section("title","About")

@section("badan")

<!-- ===================== -->
<!-- ABOUT SECTION -->
<!-- ===================== -->
<section id="about" class="about section light-background py-5">

    <!-- Section Title -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2>About Us</h2>
        <p>Welcome {{ Session::get("username") ?? 'Guest' }}</p>
        <p>
            <span>Find Out More</span>
            <span class="description-title">About Our System</span>
        </p>
    </div>

    <div class="container">
        <div class="row gy-4 align-items-center">

            <!-- Image -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('assets/img/flood.png') }}" 
                     alt="Flood Monitoring System" 
                     class="img-fluid rounded shadow"
                     style="max-height:380px; object-fit:cover;">
            </div>

            <!-- Content -->
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="about-content ps-lg-4">

                    <h3 class="mb-3">
                        Flood Monitoring & Early Warning System
                    </h3>

                    <p class="fst-italic text-muted">
                        This system is developed to address flooding issues in urban areas 
                        by providing early alerts and real-time drainage monitoring.
                    </p>

                    <ul class="list-unstyled mt-4">
                        <li class="d-flex mb-3">
                            <i class="bi bi-diagram-3 text-primary fs-4 me-3"></i>
                            <div>
                                <h5>System Architecture</h5>
                                <p class="text-muted mb-0">
                                    Uses IoT-based concepts and rule-based logic to simulate 
                                    flood prediction and drainage monitoring.
                                </p>
                            </div>
                        </li>

                        <li class="d-flex mb-3">
                            <i class="bi bi-broadcast text-primary fs-4 me-3"></i>
                            <div>
                                <h5>Real-Time Monitoring</h5>
                                <p class="text-muted mb-0">
                                    Displays drainage water level information through a centralized 
                                    web dashboard for better decision-making.
                                </p>
                            </div>
                        </li>
                    </ul>

                    <p class="text-muted mt-3">
                        The system allows administrators to manage users, drainage services, 
                        and subscriptions, while users can access drainage status and receive 
                        early flood alerts. This project serves as a functional prototype 
                        suitable for academic and demonstration purposes.
                    </p>

                </div>
            </div>
        </div>
    </div>

</section>

@endsection
