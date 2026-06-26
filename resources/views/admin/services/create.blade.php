@extends("template/mylayout")
@section("aktif-admin-service", "active")
@section("title", "Add Service")

@section("badan")
<section style="padding-top: 40px; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">Add New Service</div>
                    <div class="card-body">
                        <form action="{{ url('/admin/services/store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Service Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Price (RM)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Save Service</button>
                            <a href="{{ url('/admin/services') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection