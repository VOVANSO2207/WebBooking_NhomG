@extends('admin.layouts.master')

@section('admin-container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">Kết Quả Tìm
                Kiếm Đặt Phòng</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if ($bookings->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">Không có booking nào được tìm thấy.</td>
                            </tr>
                        @else
                            @foreach ($bookings as $index => $booking)
                                <tr class="booking-detail" data-id="{{ $booking->booking_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $booking->booking_id ?? 'N/A' }}</td>
                                    <td>{{ $booking->user->username ?? 'N/A' }}</td>
                                    <td>{{ $booking->room->room_name ?? 'N/A' }}</td>
                                    <td>{{ $booking->check_in ? \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $booking->check_out ? \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $booking->total_price !== null ? number_format($booking->total_price, 0, ',', '.') . ' VNĐ' : 'N/A' }}
                                    </td>
                                    <td class="{{ $booking->status == 'confirmed' ? 'badge bg-success' : 'badge bg-danger' }}">
                                        {{ ucfirst($booking->status ?? 'N/A') }}
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-booking">
                {{ $bookings->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookingDetailRows = document.querySelectorAll('.booking-detail');

        bookingDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                const bookingId = this.getAttribute('data-id');
                fetch(`/bookings/${bookingId}/detail`)
                    .then(response => response.json())
                    .then(booking => {
                        // Cập nhật nội dung modal
                        document.getElementById('modalBookingId').innerText = booking.booking_id;
                        document.getElementById('modalUser').innerText = booking.user.username;
                        document.getElementById('modalRoom').innerText = booking.room.room_name;
                        document.getElementById('modalCheckIn').innerText = booking.check_in;
                        document.getElementById('modalCheckOut').innerText = booking.check_out;
                        document.getElementById('modalTotalPrice').innerText = booking.total_price + ' VNĐ';
                        document.getElementById('modalStatus').innerText = booking.status === 'confirmed' ? 'Confirmed' : 'Canceled';

                        // Hiển thị modal
                        new bootstrap.Modal(document.getElementById('bookingDetailModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching booking details:', error);
                    });
            });
        });
    });
</script>
@endsection