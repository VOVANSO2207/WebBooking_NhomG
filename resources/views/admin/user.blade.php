@extends('admin.layouts.master')
@section('admin-container')
    <nav
        class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center" style="width: 100%;">
                <div class="nav-item d-flex align-items-center" style="width: 100%;">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input type="text" class="form-control border-0 shadow-none" id="search_post" placeholder="Search..."
                           aria-label="Search..." style="width: 100%;" />
                </div>
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
                            <th>Password</th>
                            <th>Phonenumber</th>
                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 alldata">
                            <tr>
                                <td colspan="11" class="text-center">Không có user nào để hiển thị.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>

    @if(session('success'))
        <div class="hidden" id="deleteSuccessMessage">{{ session('success') }}</div>
    @endif

    <script>
        var successMessage = document.getElementById('deleteSuccessMessage');
        if (successMessage) {
            swal(successMessage.innerText, "You clicked the button!", "success");
        }
    </script>
@endsection
