@extends("template/mylayout")
@section("aktif-contact","active")
@section("title","Contact")

@section("badan")
<!-- ===================== -->
<!-- CONTACT SECTION -->
<!-- ===================== -->
<section id="contact" class="contact section py-5">

    <!-- Section Title -->
    <div class="container section-title text-center" data-aos="fade-up">
        <h2>Contact</h2>
        <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">

            <!-- Address -->
            <div class="col-lg-6">
                <div class="info-wrap p-4 shadow-sm rounded text-center">

                    <div class="info-item d-flex align-items-center justify-content-start mb-3">
                        <i class="bi bi-geo-alt fs-3"></i>
                        <div class="text-start ms-3"> 
                            <h5 class="mb-1">Address</h5> <p class="mb-0">Tembila, Terengganu, UniSZA, Malaysia</p>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex align-items-center justify-content-start mb-3">
                        <i class="bi bi-telephone fs-3"></i>
                        <div class="text-start ms-3">
                            <h5 class="mb-1">Phone</h5>
                            <p class="mb-0">0123456789</p>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex align-items-center justify-content-start mb-3">
                        <i class="bi bi-envelope fs-3"></i>
                        <div class="text-start ms-3">
                            <h5 class="mb-1">Email</h5>
                            <p class="mb-0">info@example.com</p>
                        </div>
                    </div>

                    <!-- Google Map -->
                    <div class="mt-4">
                        <iframe 
                            src="https://www.google.com/maps?q=Tembila,+Terengganu,+UniSZA&output=embed" 
                            frameborder="0" 
                            style="border:0; width: 100%; height: 270px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section><!-- /Contact Section -->
@endsection
