@extends('admin.layouts.master')
@php
    use App\Helpers\IdEncoder;
@endphp
@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <form action="{{ route('admin.booking.search') }}" method="GET" class="d-flex align-items-center"
                style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." style="width: 100%;" />
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
         <!-- Success/Failure Messages -->
         @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="card">
            <h5 class="card-header text-white" style="background-color: #696cff; border-color: #696cff;">BOOKING</h5>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>User</th>
                            <th>Room</th>
                            <th>Promotion</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($bookings as $index => $booking)
                            <tr class="booking-detail" data-id="{{ IdEncoder::encodeId($booking->booking_id ) }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $booking->user->username ?? 'Không có người dùng' }}</td> <!-- Hiển thị tên người dùng -->
                                <td>{{ $booking->room->name ?? 'N/A' }}</td> <!-- Hiển thị tên phòng -->
                                <td>{{ $booking->promotion->promotion_code ?? 'Không có khuyến mãi' }}</td> <!-- Hiển thị mã khuyến mãi -->
                                <td>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td>{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td>{{ $booking->total_price !== null ? number_format($booking->total_price, 0, ',', '.') . ' VNĐ' : 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge d-inline" style="{{ $booking->status === 'confirmed' ? 'background-color: green; color: white; padding: 5px;' : ($booking->status === 'cancelled' ? 'background-color: red; color: white; padding: 5px;' : 'background-color: orange; color: white; padding: 5px;') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
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
<!-- Modal chi tiết đặt phòng -->
<div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-labelledby="bookingDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingDetailModalLabel">Booking Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="room-info-grid mt-3">
                    <div class="info-card">
                        <div class="info-label">User ID:</div>
                        <div class="info-value" id="modalUserId"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Room ID:</div>
                        <div class="info-value" id="modalRoomId"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Promotion ID:</div>
                        <div class="info-value" id="modalPromotionId"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Check-In:</div>
                        <div class="info-value" id="modalCheckIn"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Check-Out:</div>
                        <div class="info-value" id="modalCheckOut"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Total Price:</div>
                        <div class="info-value" id="modalTotalPrice"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Status:</div>
                        <div class="info-value" id="modalStatus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <a id="editBookingButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookingDetailRows = document.querySelectorAll('.booking-detail');
        let currentBookingId = null;

        // Khi người dùng nhấn vào một dòng đặt phòng
        bookingDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentBookingId = this.getAttribute('data-id');

                // Fetch thông tin chi tiết đặt phòng
                fetch(`/bookings/${currentBookingId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(booking => {
                        // Cập nhật thông tin vào modal
                        document.getElementById('modalUserId').innerText = booking.user_id;
                        document.getElementById('modalRoomId').innerText = booking.room_id;
                        document.getElementById('modalPromotionId').innerText = booking.promotion_id;
                        document.getElementById('modalCheckIn').innerText = booking.check_in;
                        document.getElementById('modalCheckOut').innerText = booking.check_out;
                        document.getElementById('modalTotalPrice').innerText = booking.total_price;
                        document.getElementById('modalStatus').innerText = booking.status.charAt(0).toUpperCase() + booking.status.slice(1);

                        // Đặt link Edit
                        const editRoute = "{{ route('booking.edit', ['booking_id' => ':id']) }}".replace(':id', currentBookingId);
                        document.getElementById('editBookingButton').setAttribute('href', editRoute);

                        // Hiển thị modal chi tiết đặt phòng
                        new bootstrap.Modal(document.getElementById('bookingDetailModal')).show();
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy thông tin đặt phòng:', error);
                    });
            });
        });

        // Xác nhận xóa
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (currentBookingId) {
                const deleteRoute = "{{ route('booking.delete', ['booking_id' => ':id']) }}".replace(':id', currentBookingId);

                fetch(deleteRoute, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                if (!confirm('Bạn có chắc chắn muốn đơn đặt phòng này?')) return;
                location.reload();
            }
        });
        const bookingDetailModal = document.getElementById('bookingDetailModal');

        // Lắng nghe sự kiện đóng modal
        bookingDetailModal.addEventListener('hidden.bs.modal', function () {
            // Tự động reload lại trang khi modal đóng
            location.reload();
        });
    });
</script>

@endsection