
@extends('admin.layouts.master')
@section('admin-container')
    <!-- Layout wrapper -->

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            
            <!-- @if(Auth::check()) -->
                <a class="btn btn-outline-danger" role="button" style="margin: 10px;" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#confirmLogoutModal">
                    <i class='bx bx-log-out' style="vertical-align: text-top;"></i> Logout
                </a>
                <!-- Modal -->
                <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmLogoutModalLabel">Xác nhận </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn muốn đăng xuất không?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <a href="" class="btn btn-danger">Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            
        </ul>
    </div>
    </nav>

  
@endsection
                            
              