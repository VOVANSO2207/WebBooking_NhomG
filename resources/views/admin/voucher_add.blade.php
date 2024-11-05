@extends('admin.layouts.master')
@section('admin-container')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <h3 style="text-align: center; font-size: 40px">ADD VOUCHER</h3>
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="post" id="promotionForm" action="{{ route('admin.promotion.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Promotion Code</label>
                                <input class="form-control" type="text" name="promotion_code" id="promotion_code"
                                    placeholder="Promotion Code" />
                                @error('promotion_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Discount Amount</label>
                                <input class="form-control" type="number" name="discount_amount" id="discount_amount"
                                    placeholder="Discount Amount" />
                                @error('discount_amount')
                                    <div class="text-danger">{{ $errors->first('discount_amount') }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Start Date</label>
                                <input class="form-control" type="date" name="start_date" id="start_date" />
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">End Date</label>
                                <input class="form-control" type="date" name="end_date" id="end_date" />
                                @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('admin.viewvoucher') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm promotion thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thêm voucher thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#promotionForm').on('submit', function (event) {
        event.preventDefault();

        // Lấy giá trị của promotion_code
        var promotionCode = $('#promotion_code').val().trim();
        var discountAmount = $('#discount_amount').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var statusValue = $('#status option:selected').val();

        // Xóa các lỗi trước đó
        $('.text-danger').remove();

        // Kiểm tra các lỗi cho promotion_code
        if (promotionCode === '') {
            $('<div class="text-danger">Vui lòng nhập tên voucher.</div>').insertAfter('#promotion_code');
            return;
        }
        if (/[^a-zA-Z0-9\s]/.test(promotionCode)) {
            $('<div class="text-danger">Tên voucher không chứa kí tự đặc biệt.</div>').insertAfter('#promotion_code');
            return;
        }
        if (promotionCode.length > 15) {
            $('<div class="text-danger">Tên voucher trên 15 ký tự vui lòng nhập lại.</div>').insertAfter('#promotion_code');
            return;
        }
        if (promotionCode.length < 10) {
            $('<div class="text-danger">Tên voucher dưới 10 ký tự vui lòng nhập lại.</div>').insertAfter('#promotion_code');
            return;
        }
        if (/\s/.test(promotionCode)) {
            $('<div class="text-danger">Vui lòng không nhập khoảng trắng.</div>').insertAfter('#promotion_code');
            return;
        }
        if (!/[a-zA-Z]/.test(promotionCode) || !/[0-9]/.test(promotionCode)) {
            $('<div class="text-danger">Tên voucher phải vừa là chữ vừa là số.</div>').insertAfter('#promotion_code');
            return;
        }
        // Kiểm tra discount_amount
        if (discountAmount === '') {
            $('<div class="text-danger">Vui lòng nhập số tiền giảm giá.</div>').insertAfter('#discount_amount');
            return;
        }
        if (/\D/.test(discountAmount)) {
            $('<div class="text-danger">Vui lòng không nhập ký tự đặc biệt hoặc khoảng trắng.</div>').insertAfter('#discount_amount');
            return;
        }
        if (parseFloat(discountAmount) <= 0) {
            $('<div class="text-danger">Số tiền giảm giá không hợp lệ.</div>').insertAfter('#discount_amount');
            return;
        }

        // Kiểm tra nếu start_date lớn hơn end_date
        if (new Date(startDate) > new Date(endDate)) {
            $('<div class="text-danger">Ngày bắt đầu không được lớn hơn ngày kết thúc.</div>').insertAfter('#start_date');
            return;
        }

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('promotion_code', promotionCode);
        formData.append('discount_amount', discountAmount);
        formData.append('start_date', startDate);
        formData.append('end_date', endDate);
        formData.append('status', statusValue);

        // Gửi dữ liệu qua AJAX
        $.ajax({
            url: "{{ route('admin.promotion.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Hiển thị modal thông báo thành công
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                setTimeout(function() {
                    window.location.href = '{{ route('admin.viewvoucher') }}';
                }, 2000); 

            },
            error: function (xhr) {
                // Xử lý lỗi phía server
                var errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        var errorDiv = $('<div class="text-danger"></div>').text(errors[key][0]);
                        $('[name="' + key + '"]').after(errorDiv);
                    }
                }
            }
        });
    });
</script>

@endsection