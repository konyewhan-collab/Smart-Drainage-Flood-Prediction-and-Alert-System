@extends("template/mylayout")

@section("title", "Manage System Users")
@section("aktif-admin", "active") {{-- Highlights 'Manage User' in the menu --}}

@section("badan")

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">
        
        <h2 class="fw-bold text-primary mb-4"><i class="bi bi-people-fill me-2"></i>Manage System Users</h2>

        {{-- Show Success & Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-list-ul me-2"></i> Registered Accounts
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Avatar</th>
                                <th>Username</th>
                                <th>Phone Number</th>
                                <th>Access Role</th>
                                <th class="text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $u->user_id }}</td>
                                
                                <td>
                                    @if($u->profile_pic)
                                        <img src="{{ asset('pictures/'.$u->name.'/'.$u->profile_pic) }}" alt="Avatar" class="rounded-circle border" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-secondary fs-5"></i>
                                        </div>
                                    @endif
                                </td>

                                <td class="fw-bold">{{ $u->name }}</td>
                                <td>{{ $u->phone }}</td>
                                
                                {{-- Change Role Form --}}
                                <td style="width: 200px;">
                                    <form action="{{ url('/admin/users/role/'.$u->user_id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        <select name="userlevel" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                            <option value="User" {{ strtolower($u->userlevel) == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="Admin" {{ strtolower($u->userlevel) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>

                                {{-- Delete Button --}}
                                <td class="text-center pe-4">
                                    <form action="{{ url('/admin/users/delete/'.$u->user_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to permanently delete this user?')">
                                            <i class="bi bi-trash-fill"></i> Remove
                                        </button>
                                    </form>
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