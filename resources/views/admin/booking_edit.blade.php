@extends('admin.layouts.master')

@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="bookingForm" action="{{ route('admin.booking.update', $booking->booking_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">User ID</label>
                                <input class="form-control" type="number" name="user_id" id="user_id"
                                    value="{{ old('user_id', $booking->user_id) }}" placeholder="User ID" required />
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Room ID</label>
                                <input class="form-control" type="number" name="room_id" id="room_id"
                                    value="{{ old('room_id', $booking->room_id) }}" placeholder="Room ID" required />
                                @error('room_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Promotion ID</label>
                                <input class="form-control" type="number" name="promotion_id" id="promotion_id"
                                    value="{{ old('promotion_id', $booking->promotion_id) }}" placeholder="Promotion ID" />
                                @error('promotion_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Check-In Date</label>
                                <input class="form-control" type="date" name="check_in" id="check_in"
                                    value="{{ old('check_in', $booking->check_in) }}" required />
                                @error('check_in')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Check-Out Date</label>
                                <input class="form-control" type="date" name="check_out" id="check_out"
                                    value="{{ old('check_out', $booking->check_out) }}" required />
                                @error('check_out')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Total Price</label>
                                <input class="form-control" type="number" name="total_price" id="total_price"
                                    value="{{ old('total_price', $booking->total_price) }}" placeholder="Total Price" required />
                                @error('total_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('admin.viewpost') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<!-- Modal Không có cập nhật nào -->
<div class="modal fade" id="noUpdateModal" tabindex="-1" aria-labelledby="noUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noUpdateModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Không có cập nhật mới.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cập nhật thành công -->
<div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSuccessModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Cập nhật booking thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        let isChanged = false; // Biến để theo dõi sự thay đổi

        function resetForm() {
            $('#bookingForm')[0].reset();
            isChanged = false; // Reset biến isChanged khi reset form
        }

        function checkForChanges() {
            var userId = $('#user_id').val();
            var roomId = $('#room_id').val();
            var promotionId = $('#promotion_id').val();
            var checkIn = $('#check_in').val();
            var checkOut = $('#check_out').val();
            var totalPrice = $('#total_price').val();
            var statusValue = $('#status option:selected').val();

            if (
                userId !== '{{ addslashes(old('user_id', $booking->user_id)) }}' ||
                roomId !== '{{ addslashes(old('room_id', $booking->room_id)) }}' ||
                promotionId !== '{{ addslashes(old('promotion_id', $booking->promotion_id)) }}' ||
                checkIn !== '{{ addslashes(old('check_in', $booking->check_in)) }}' ||
                checkOut !== '{{ addslashes(old('check_out', $booking->check_out)) }}' ||
                totalPrice !== '{{ addslashes(old('total_price', $booking->total_price)) }}' ||
                statusValue !== '{{ $booking->status }}'
            ) {
                isChanged = true;
            } else {
                isChanged = false;
            }
        }

        $('#user_id, #room_id, #promotion_id, #check_in, #check_out, #total_price, #status').on('input change', function () {
            checkForChanges();
        });

        $('#bookingForm').on('submit', function (event) {
            event.preventDefault();

            if (!isChanged) {
                const noUpdateModal = new bootstrap.Modal(document.getElementById('noUpdateModal'));
                noUpdateModal.show();
                return;
            }

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('admin.booking.update', $booking->booking_id) }}",
                method: 'POST',
                data: formData,
                success: function (response) {
                    const updateSuccessModal = new bootstrap.Modal(document.getElementById('updateSuccessModal'));
                    updateSuccessModal.show();

                    setTimeout(function () {
                        window.location.href = '{{ route('admin.viewpost') }}';
                    }, 2000);
                },
                error: function (xhr) {
                    // Xóa lỗi cũ trước đó
                    $('.text-danger').remove();

                    // Xử lý lỗi
                    var errors = xhr.responseJSON.errors;
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            var errorDiv = $('<div class="text-danger"></div>').text(errors[key][0]);
                            $('#' + key).after(errorDiv);
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
