@extends('admin.layouts.master')

@php
    use App\Helpers\IdEncoder;
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">

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
                <div class="nav-item d-flex align-items-center" style="width: 100%;">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input type="text" class="form-control border-0 shadow-none" id="search_roomType"
                        placeholder="Search..." aria-label="Search..." style="width: 100%;" onkeyup="searchRoomType()" />
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
                <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">ROOM TYPE</h5>
                <div class="add">
                    <a href="{{ route(name: 'roomType_add') }}" class="btn btn-success">Add</a>
                </div>
                <div class="table-responsive text-nowrap content1">
                    <table class="table">
                        <thead>
                            <tr class="color_tr">
                                <th>STT</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 alldata">
                            @if ($roomType->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center">Không tìm thấy kết quả</td>
                                </tr>
                            @else
                                @foreach ($roomType as $key => $roomTypes)
                                    <tr>
                                        <td style="width: 10%;">{{ $key + 1 }}</td>
                                        <td style="width: 70%;">{{ $roomTypes->name }}</td>
                                        <td style="width: 20%;">
                                            <div class="d-flex justify-content-around align-items-center">
                                                <a href="{{ route('admin.roomtype.edit', IdEncoder::encodeId($roomTypes->room_type_id)) }}"
                                                    class="btn btn-info btn-sm" title="Edit">
                                                    <i class="bi bi-pencil-fill" style="margin-right: 5px"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal"
                                                    onclick="setDeleteAction('{{ route('admin.roomtype.delete', IdEncoder::encodeId($roomTypes->room_type_id)) }}')">
                                                    <i class="bi bi-x-circle" style="margin-right: 5px;"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                        </tbody>

                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3 pagination-roomtype">
                    {{ $roomType->appends(['query' => request('query')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for confirm delete -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">XÁC NHẬN XOÁ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa loại phòng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">OK</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiện thông báo khi update thành công -->
    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2" style="color: #28a745;"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    @if (session('info'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="infoToast" class="toast align-items-center text-bg-info border-0" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-info-circle-fill me-2" style="color: #0dcaf0;"></i>
                    {{ session('info') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
    <script>
          document.addEventListener('DOMContentLoaded', function() {
            if ({{ session('success') ? 'true' : 'false' }}) {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'), {
                    delay: 1500
                });
                successToast.show();
            }
            if ({{ session('info') ? 'true' : 'false' }}) {
                var infoToast = new bootstrap.Toast(document.getElementById('infoToast'), {
                    delay: 1500
                });
                infoToast.show();
            }
        });
        function searchRoomType() {
            const query = document.getElementById('search_roomType').value;

            // Gửi yêu cầu AJAX
            fetch(`/admin/room-types/search?query=${query}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.text())
                .then(data => {
                    // Cập nhật nội dung bảng với kết quả tìm kiếm
                    document.querySelector('tbody.table-border-bottom-0').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
