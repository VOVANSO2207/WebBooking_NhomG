@extends('admin.layouts.master')
@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <form action="{{ route('admin.searchUsers') }}" method="GET" style="width: 100%;">
                <div class="nav-item d-flex align-items-center" style="width: 100%;">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input type="text" class="form-control border-0 shadow-none" name="query" placeholder="Search..."
                        aria-label="Search..." style="width: 100%;" />
                </div>
            </form>
        </div>
        <!-- /Search -->

    </div>
</nav>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">USER</h5>
            <div class="add">
                <a class="btn btn-success" href="{{route(name: 'user_add')}}">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phonenumber</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Avatar</th>
                            <th>Action</th> <!-- Thêm cột Action -->
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->role_id == 2 ? 'User' : ($user->role_id == 3 ? 'Admin' : 'Unknown') }}</td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ asset('images/' . $user->avatar) }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}'"
                                        alt="Avatar" style="width: 50px; height: 50px;">
                                </td>
                                <td>
                                    <!-- Thêm các nút Action -->
                                    <a href="{{ route('admin.user.show', $user->user_id) }}"
                                        class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.user.edit', $user->user_id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.user.destroy', $user->user_id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có user nào để hiển thị.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-3">
                    {{$users->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<script>
    var successMessage = document.getElementById('deleteSuccessMessage');
    if (successMessage) {
        swal(successMessage.innerText, "You clicked the button!", "success");
    }
</script>
@endsection