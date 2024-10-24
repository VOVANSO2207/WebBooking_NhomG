@extends('admin.layouts.master')
@section('admin-container')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="userForm" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                    @csrf
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ asset('images/img-upload.jpg') }}" alt="user-avatar" class="" height="100" width="100" id="fileUpload" />
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Upload</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" name="avatar" class="account-file-input" hidden accept="image/png, image/jpeg, image/jpg" />
                </label>
            </div>
        </div>
    </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Username</label>
                                <input class="form-control" type="text" name="username" id="username" placeholder="Username" required />
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email" required />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Password</label>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required />
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required />
                                @error('phone_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Role</label>
                                <select id="role_id" name="role_id" class="form-select">
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                                @error('role_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('admin.viewuser') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm người dùng thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thêm người dùng thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Sử dụng jQuery để xử lý biểu mẫu
    $('#userForm').on('submit', function (event) {
        event.preventDefault(); // Ngăn chặn gửi biểu mẫu mặc định

        // Lấy dữ liệu từ form
        var formData = new FormData(this); // Tạo FormData từ biểu mẫu

        // Gửi dữ liệu qua AJAX
        $.ajax({
            url: "{{ route('admin.user.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Hiển thị modal thông báo thành công
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Tự động điều hướng đến trang người dùng sau 2 giây
                setTimeout(function() {
                    window.location.href = '{{ route('admin.viewuser') }}';
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
        $('#userForm')[0].reset(); // Đặt lại biểu mẫu
        $("#fileUpload").attr("src", "{{ asset('/images/img-upload.jpg') }}"); // Đặt lại hình ảnh tải lên
    }

    // Xử lý sự kiện upload hình ảnh
    $('#upload').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#fileUpload").attr("src", e.target.result); // Cập nhật hình ảnh xem trước
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection
