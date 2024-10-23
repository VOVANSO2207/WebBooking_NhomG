@extends('admin.layouts.master')

@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <div class="nav-item d-flex align-items-center" style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" id="search_booking" name="search_booking" placeholder="Search..." aria-label="Search..." style="width: 100%;" />
            </div>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">BOOKING</h5>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>User ID</th>
                            <th>Room ID</th>
                            <th>Promotion ID</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($bookings as $index => $booking)
                            <tr class="booking-detail" data-id="{{ $booking->booking_id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $booking->user_id }}</td>
                                <td>{{ $booking->room_id }}</td>
                                <td>{{ $booking->promotion_id }}</td>
                                <td>{{ $booking->check_in }}</td>
                                <td>{{ $booking->check_out }}</td>
                                <td>{{ $booking->total_price }}</td>
                                <td class="{{ $booking->status === 'confirmed' ? 'badge bg-success' : ($booking->status === 'cancelled' ? 'badge bg-danger' : 'badge bg-warning') }}">
                                    {{ ucfirst($booking->status) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có đặt phòng nào để hiển thị.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-booking">
                {{ $bookings->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal chi tiết đặt phòng -->
<div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-labelledby="bookingDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingDetailModalLabel">Booking Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="booking-detail">
                    <div class="booking-detail-item">
                        <strong>User ID:</strong>
                        <span id="modalUserId"></span>
                    </div>
                    <div class="booking-detail-item">
                        <strong>Room ID:</strong>
                        <span id="modalRoomId"></span>
                    </div>
                    <div class="booking-detail-item">
                        <strong>Promotion ID:</strong>
                        <span id="modalPromotionId"></span>
                    </div>
                    <div class="booking-detail-item">
                        <strong>Check In:</strong>
                        <span id="modalCheckIn"></span>
                    </div>
                    <div class="booking-detail-item">
                        <strong>Check Out:</strong>
                        <span id="modalCheckOut"></span>
                    </div>
                    <div class="booking-detail-item">
                        <strong>Total Price:</strong>
                        <span id="modalTotalPrice"></span>
                    </div>
                    <div class="booking-detail-item">
                        <strong>Status:</strong>
                        <span id="modalStatus"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="editBookingButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteBookingButton" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</button>
            </div>
            <div class="modal-footer" style="width: 100%; position: relative; bottom: 0;">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa đặt phòng này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookingDetailRows = document.querySelectorAll('.booking-detail');
        let currentBookingId = null; // Lưu ID đặt phòng hiện tại

        // Khi người dùng nhấn vào một đặt phòng
        bookingDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentBookingId = this.getAttribute('data-id'); // Lưu ID đặt phòng hiện tại

                // Gọi AJAX để lấy thông tin chi tiết đặt phòng
                fetch(`/bookings/${currentBookingId}/detail`)
                    .then(response => response.json())
                    .then(booking => {
                        // Cập nhật nội dung modal
                        document.getElementById('modalUserId').innerText = booking.user_id;
                        document.getElementById('modalRoomId').innerText = booking.room_id;
                        document.getElementById('modalPromotionId').innerText = booking.promotion_id;
                        document.getElementById('modalCheckIn').innerText = booking.check_in;
                        document.getElementById('modalCheckOut').innerText = booking.check_out;
                        document.getElementById('modalTotalPrice').innerText = booking.total_price;
                        document.getElementById('modalStatus').innerText = booking.status.charAt(0).toUpperCase() + booking.status.slice(1);

                        // Thiết lập đường dẫn cho nút Edit
                        const editRoute = "{{ route('booking.edit', ['booking_id' => ':id']) }}".replace(':id', currentBookingId);
                        document.getElementById('editBookingButton').setAttribute('href', editRoute);

                        // Hiển thị modal
                        const modal = new bootstrap.Modal(document.getElementById('bookingDetailModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Có vấn đề với yêu cầu fetch:', error);
                    });
            });
        });

        // Khi người dùng nhấn nút "Delete"
        document.getElementById('deleteBookingButton').addEventListener('click', function () {
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            confirmDeleteModal.show();
        });

        // Khi người dùng nhấn nút "OK" trong modal xác nhận
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (currentBookingId) {
                const deleteRoute = "{{ route('booking.delete', ['booking_id' => ':id']) }}".replace(':id', currentBookingId);

                fetch(deleteRoute, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Tải lại trang để cập nhật danh sách đặt phòng
                    } else {
                        console.error('Có vấn đề khi xóa đặt phòng:', response.statusText);
                    }
                })
                .catch(error => {
                    console.error('Có vấn đề với yêu cầu fetch:', error);
                });
            }
        });
    });
</script>
@endsection
