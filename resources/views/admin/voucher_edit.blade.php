@extends('admin.layouts.master')
@php
    use Carbon\Carbon;
@endphp
@section('admin-container')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
        <h3 style="text-align: center; font-size: 40px">EDIT VOUCHER</h3>
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="post" id="editVoucherForm"
                        action="{{ route('admin.voucher.update', $voucher->promotion_id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Sử dụng phương thức PUT cho việc sửa -->
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Promotion Code</label>
                                <input class="form-control" type="text" name="promotion_code" id="promotion_code"
                                    placeholder="Promotion Code"
                                    value="{{ old('promotion_code', $voucher->promotion_code) }}" required />
                                @error('promotion_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Discount Amount</label>
                                <input class="form-control" type="number" name="discount_amount" id="discount_amount"
                                    placeholder="Discount Amount"
                                    value="{{ old('discount_amount', $voucher->discount_amount) }}" required />
                                @error('discount_amount')
                                    <div class="text-danger">{{ $errors->first('discount_amount') }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Start Date (Y-m-d)</label>
                                <input class="form-control" type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $start_date) }}" required />
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">End Date (Y-m-d)</label>
                                <input class="form-control" type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $end_date) }}" required />
                                @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <input class="form-control" type="hidden" id="updated_at" name="updated_at"
                                value="{{ old('update_at', $voucher->updated_at) }}" />

                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='{{ route('admin.viewvoucher') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa promotion thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Cập nhật voucher thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal xung đột cập nhật -->
<div class="modal fade" id="conflictModal" tabindex="-1" aria-labelledby="conflictModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="conflictModalLabel">Thông báo xung đột cập nhật</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Voucher đã được cập nhật bởi một người dùng khác. Vui lòng tải lại và thử lại.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="location.reload()">Tải lại trang</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Không có cập nhật mới -->
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

<script>
    $(document).ready(function () {
        // Lưu dữ liệu ban đầu của form để so sánh
        var originalPromotionCode = $('#promotion_code').val();
        var originalDiscountAmount = $('#discount_amount').val();
        var originalStartDate = $('#start_date').val();
        var originalEndDate = $('#end_date').val();
        var updated_at = $('updated_at').val();
        $('#editVoucherForm').on('submit', function (event) {
            event.preventDefault();

            // Lấy giá trị mới của form
            var promotionCode = $('#promotion_code').val().trim();
            var discountAmount = $('#discount_amount').val();
            var startDate = $('#start_date').val(); // Định dạng YYYY-MM-DD
            var endDate = $('#end_date').val(); // Định dạng YYYY-MM-DD

            // Kiểm tra nếu không có thay đổi
            if (promotionCode === originalPromotionCode &&
                discountAmount === originalDiscountAmount &&
                startDate === originalStartDate &&
                endDate === originalEndDate) {
                // Hiển thị modal "Không có cập nhật mới"
                const noUpdateModal = new bootstrap.Modal(document.getElementById('noUpdateModal'));
                noUpdateModal.show();
                return; // Ngăn việc gửi form nếu không có thay đổi
            }

            // Lưu ý kiểm tra ngày bắt đầu và ngày kết thúc
            if (new Date(startDate) > new Date(endDate)) {
                alert('Ngày bắt đầu không được lớn hơn ngày kết thúc.');
                return;
            }

            // Xóa các thông báo lỗi cũ (nếu có)
            $('.text-danger').remove();

            var formData = new FormData(this); // Dữ liệu form tự động

            // Gửi dữ liệu qua AJAX nếu có thay đổi
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Hiển thị modal thông báo thành công
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                },
                error: function (xhr) {
                    if (xhr.status === 409) {
                        const conflictModal = new bootstrap.Modal(document.getElementById('conflictModal'));
                        conflictModal.show();
                    } else {
                        // Xử lý các lỗi khác
                        $('.text-danger').remove();
                        var errors = xhr.responseJSON.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                var errorDiv = $('<div class="text-danger"></div>').text(errors[key][0]);
                                $('[name="' + key + '"]').after(errorDiv);
                            }
                        }
                    }
                }
            });
        });
    });


</script>

@endsection