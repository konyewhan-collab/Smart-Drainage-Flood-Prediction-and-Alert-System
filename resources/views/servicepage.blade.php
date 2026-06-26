@extends("template/mylayout")

@section("title","Services")
@section("aktif-service","active")

@section("badan")

<!-- ===================== -->
<!-- SERVICES SECTION -->
<!-- ===================== -->
<section id="services" class="services section py-5">

    <!-- Section Title -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2>Services</h2>
        <p><span>Check Our</span> <span class="description-title">Services</span></p>
    </div>

    <div class="container">
        <div class="row gy-4">

            <!-- Service 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative text-center p-4 shadow-sm rounded h-100">
                    <div class="icon mb-3"><i class="bi bi-activity fs-2"></i></div>
                    <h5>Real-Time Drainage Monitoring</h5>
                    <p class="text-muted">
                        Monitor water levels in drainage systems continuously through IoT sensors.
                    </p>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative text-center p-4 shadow-sm rounded h-100">
                    <div class="icon mb-3"><i class="bi bi-broadcast fs-2"></i></div>
                    <h5>Early Flood Alerts</h5>
                    <p class="text-muted">
                        Users receive instant notifications when drainage water levels exceed safe limits.
                    </p>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative text-center p-4 shadow-sm rounded h-100">
                    <div class="icon mb-3"><i class="bi bi-graph-up fs-2"></i></div>
                    <h5>Visual Reports & Analytics</h5>
                    <p class="text-muted">
                        Generate charts and reports to analyze drainage patterns and flood risk trends.
                    </p>
                </div>
            </div>

            <!-- Service 4 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item position-relative text-center p-4 shadow-sm rounded h-100">
                    <div class="icon mb-3"><i class="bi bi-person-lines-fill fs-2"></i></div>
                    <h5>User Management</h5>
                    <p class="text-muted">
                        Admins can manage user accounts, subscriptions, and access levels efficiently.
                    </p>
                </div>
            </div>

            <!-- Service 5 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item position-relative text-center p-4 shadow-sm rounded h-100">
                    <div class="icon mb-3"><i class="bi bi-phone fs-2"></i></div>
                    <h5>Mobile-Friendly Interface</h5>
                    <p class="text-muted">
                        Access real-time data and alerts conveniently from desktop or mobile devices.
                    </p>
                </div>
            </div>

            <!-- Service 6 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item position-relative text-center p-4 shadow-sm rounded h-100">
                    <div class="icon mb-3"><i class="bi bi-shield-check fs-2"></i></div>
                    <h5>Secure System</h5>
                    <p class="text-muted">
                        Data is protected with secure protocols to ensure privacy and integrity.
                    </p>
                </div>
            </div>

        </div>
    </div>

</section>

@endsection
