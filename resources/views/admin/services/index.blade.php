@extends("template/mylayout")
@section("aktif-admin-service", "active")
@section("title", "Manage Services")

@section("badan")
<section style="padding-top: 40px; min-height: 80vh;">
    <div class="container">
        <h2 class="mb-4">Manage IoT Services</h2>
        
        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <a href="{{ url('/admin/services/create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Add New Service
        </a>

        <div class="card shadow border-0">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Price (RM)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ Str::limit($s->description, 50) }}</td>
                            <td>{{ number_format($s->price, 2) }}</td>
                            <td>
                                <a href="{{ url('/admin/services/edit/'.$s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ url('/admin/services/delete/'.$s->id) }}" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this service?');">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection