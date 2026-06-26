@extends("template/mylayout")

@section("aktif-home","active")
@section("title","Home")

@section("badan")


<!-- ===================== -->
<!-- HERO / WELCOME SECTION -->
<!-- ===================== -->
<section class="py-5 bg-light">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="mb-3">
            Welcome to <span class="text-primary">Flood Monitoring System</span>
        </h1>
        <p class="text-muted">
            A web-based system for monitoring drainage conditions and providing early flood alerts.
        </p>
    </div>
</section>

<!-- ===================== -->
<!-- PROBLEM SECTION -->
<!-- ===================== -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="text-danger mb-3">Problem</h3>
                        <p class="text-muted mb-0">
                            Urban areas often experience flooding due to poor drainage management 
                            and heavy rainfall. Flood warnings are usually delayed, and residents 
                            lack access to real-time drainage information, increasing risks to 
                            property and public safety.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== -->
<!-- SOLUTION SECTION -->
<!-- ===================== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="text-success mb-3">Solution</h3>
                        <p class="text-muted mb-0">
                            This web-based system uses IoT concepts to monitor drainage water levels 
                            and provide early flood risk alerts. Administrators manage users, drainage 
                            services, and subscriptions, while users can view drainage status and 
                            receive alerts. Flood prediction is simulated using rule-based conditions, 
                            making the system suitable as a functional prototype.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===================== -->
<!-- TARGET USERS SECTION -->
<!-- ===================== -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="text-primary mb-3">Target Users</h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Local authorities</li>
                            <li class="list-group-item">Municipal councils</li>
                            <li class="list-group-item">Disaster management agencies</li>
                            <li class="list-group-item">Residents living in flood-prone areas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ===================== -->
<!-- SYSTEM UNIQUENESS -->
<!-- ===================== -->
<section id="featured-services" class="featured-services section">

    <!-- Section Title -->
    <div class="container text-center mb-5" data-aos="fade-up">
        <h2>System Uniqueness</h2>
        <p class="text-muted">
            Key features that make the system efficient and user-friendly
        </p>
    </div>

    <div class="container">
        <div class="row gy-4">

            
            
            <!-- Feature 1 -->
            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-activity fs-1"></i></div>
              <h4><a href="" class="stretched-link">Real-Time Dashboard</a></h4>
              <p>Centralized dashboard displaying live drainage water levels.</p>
            </div>
          </div><!-- End Service Item -->
          
          <!-- Feature 2 -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-bell fs-1"></i></div>
              <h4><a href="" class="stretched-link">Early Flood Alerts</a></h4>
              <p>Rule-based alert system to notify users before critical conditions.</p>
            </div>
          </div><!-- End Service Item -->
          
          <!-- Feature 3 -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-graph-up fs-1"></i></div>
              <h4><a href="" class="stretched-link">Visual Reports</a></h4>
              <p>Easy-to-understand charts and reports for decision making.</p>
            </div>
          </div><!-- End Service Item -->
          
          <!-- Feature 4 -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-phone fs-1"></i></div>
              <h4><a href="" class="stretched-link">User-Friendly Interface</a></h4>
              <p>Simple web interface accessible on desktop and mobile devices.</p>
            </div>
          </div><!-- End Service Item -->


        </div>
    </div>
</section>

@endsection
