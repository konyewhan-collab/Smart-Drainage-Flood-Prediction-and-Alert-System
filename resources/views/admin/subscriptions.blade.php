@extends("template/mylayout")

@section("aktif-admin-subs", "active") 
@section("title", "Manage Subscriptions")

@section("badan")

<section style="background-color: #f6f9fe; min-height: 80vh; padding-top: 40px;">
    <div class="container">
        
        <h2 class="text-center mb-4">Manage Subscription Requests</h2>

        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>User Name</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subs as $row)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i') }}</td>
                                <td>{{ $row->user_name }}</td>
                                <td>{{ $row->service_name }}</td>
                                <td>
                                    @if($row->status == 'Pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($row->status == 'Approved')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->status == 'Pending')
                                        <a href="{{ url('/admin/subs/update/'.$row->id.'/Approved') }}" 
                                           class="btn btn-sm btn-success"
                                           onclick="return confirm('Approve this user?');">
                                           Approve
                                        </a>
                                        <a href="{{ url('/admin/subs/update/'.$row->id.'/Rejected') }}" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Reject this request?');">
                                           Reject
                                        </a>
                                    @else
                                        <span class="text-muted">Completed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection