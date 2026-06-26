@extends("template/mylayout")

@section("title", "PageAdmin")
@section("aktif-admin", "active")

@section("badan")

<section style="background-color: #f6f9fe; min-height: 90vh; padding-top: 40px;">
    <div class="container">

        <h2 class="fw-bold text-primary mb-4">Admin Page</h2>

        <div class="card shadow border-0 rounded-3">
            
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-people-fill me-2"></i> User List
                </h5>
                
                <form method="POST" class="d-inline">
                    @csrf 
                    <button type="submit" name="btnInsert" value="Add new" class="btn btn-primary btn-sm fw-bold">
                        <i class="bi bi-plus-lg"></i> Add New
                    </button>
                </form>
            </div>
            
            <div class="card-body p-4">
                
                <form method="POST" class="row g-2 mb-4 justify-content-end align-items-center">
                    @csrf 
                    <div class="col-auto">
                        <label class="col-form-label text-muted fw-bold">Search:</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" name="searchTxt" class="form-control" placeholder="Search name...">
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="btnSearch" value="Cari" class="btn btn-secondary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>State</th>
                                <th>Picture</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                            <tr>
                                <td class="text-center">{{$row->id}}</td>
                                <td class="fw-bold">{{$row->nama}}</td>
                                <td>{{$row->katanama}}</td>
                                
                                <td class="text-center">
                                    <span class="badge {{ $row->jenispengguna == 'admin' ? 'bg-danger' : 'bg-info text-dark' }}">
                                        {{ ucfirst($row->jenispengguna) }}
                                    </span>
                                </td>

                                <td class="text-center">{{$row->state_name}}</td>
                                
                                <td class="text-center">
                                    @if($row->picture_name)
                                        <img src="{{ asset('storage/'.$row->picture_name) }}" alt="pic" width="40" height="40" class="rounded-circle border">
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        
                                        <form method="POST">
                                            @csrf 
                                            <input type='hidden' name='id' value='{{$row->id}}'>
                                            <button type='submit' name='btnEdit' value='Edit' class="btn btn-warning btn-sm text-dark" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </form>

                                        <form method="POST">
                                            @csrf 
                                            <input type='hidden' name='id' value='{{$row->id}}'>
                                            <button type='submit' name='btnDelete' value='Delete' class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Confirm delete?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(count($data) == 0)
                    <div class="text-center py-4 text-muted">
                        No records found.
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection