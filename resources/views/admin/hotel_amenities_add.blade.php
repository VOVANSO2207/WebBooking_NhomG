@extends('admin.layouts.master')
@section('admin-container')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="amenityForm" action="{{ route('admin.hotel_amenities.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Amenity Name</label>
                                <input class="form-control" type="text" name="amenity_name" id="amenity_name"
                                    placeholder="Enter Amenity Name" required />
                                @error('amenity_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Enter Description" rows="4"></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='{{ route('admin.hotel_amenities.index') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm tiện ích thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thêm tiện ích thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Sử dụng jQuery để xử lý biểu mẫu
    $('#amenityForm').on('submit', function (event) {
        event.preventDefault(); // Ngăn chặn gửi biểu mẫu mặc định

        // Lấy dữ liệu từ form
        var formData = new FormData(this); // Tạo FormData từ biểu mẫu

        // Gửi dữ liệu qua AJAX
        $.ajax({
            url: "{{ route('admin.hotel_amenities.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Hiển thị modal thông báo thành công
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Tự động điều hướng đến trang tiện ích sau 2 giây
                setTimeout(function () {
                    window.location.href = '{{ route('admin.hotel_amenities.index') }}';
                }, 2000);
            },
            error: function (xhr) {
                // Xóa lỗi cũ trước đó
                $('.text-danger').remove();

                // Xử lý lỗi
                var errors = xhr.responseJSON.errors;
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        // Tạo phần tử thông báo lỗi mới
                        var errorDiv = $('<div class="text-danger"></div>').text(errors[key][0]);
                        // Thêm thông báo lỗi vào trường input tương ứng
                        $('[name="' + key + '"]').after(errorDiv);
                    }
                }
            }
        });
    });

    function resetForm() {
        $('#amenityForm')[0].reset(); // Đặt lại biểu mẫu
    }
</script>

@endsection
