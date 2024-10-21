@extends('admin.layouts.master')
@section('admin-container')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="post" id="postForm" action="{{ route('admin.post.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ asset('/images/img-upload.jpg') }}" alt="user-avatar" class="" height="100" width="100" id="fileUpload" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="fileUpload" class="account-file-input" hidden accept="image/png, image/jpeg, image/jpg" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Title</label>
                                <input class="form-control" type="text" name="title" id="title" placeholder="Title" required />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description" required></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Content</label>
                                <textarea name="content1" id="content1"></textarea>
                                @error('content1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Meta Desc</label>
                                <input class="form-control" type="text" id="meta_desc" name="meta_desc" placeholder="Meta Desc"  />
                                @error('meta_desc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="select2 form-select">
                                    <option value="1" selected>Show</option>
                                    <option value="0">Hidden</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Url Seo</label>
                                <input class="form-control" type="text" id="url_seo" name="url_seo" placeholder="Url Seo" readonly />
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

<!-- Modal Thêm bài viết thành công -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thêm bài viết thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        CKEDITOR.replace('content1', {
            filebrowserUploadUrl: "path/to/upload/image"
        });
    };

    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "path/to/upload/image"
    });

    $("#title").on("keyup input", function () {
        var inputValue = $(this).val();
        var trimmedValue = inputValue.replace(/\s+$/, "");
        var formattedValue = trimmedValue
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/\s+/g, "-");

        $("#url_seo").val(formattedValue);
    });

    $('#postForm').on('submit', function (event) {
        event.preventDefault();
        var img = $('#upload')[0].files[0];

        var title = $('#title').val();
        var description = CKEDITOR.instances.description.getData();
        var content = CKEDITOR.instances.content1.getData();
        var meta_desc = $('#meta_desc').val();
        var statusValue = $('#status option:selected').val();
        var url_seo = $('#url_seo').val();

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('title', title);
        formData.append('description', description);
        formData.append('content1', content);
        formData.append('meta_desc', meta_desc);
        formData.append('status', statusValue);
        formData.append('url_seo', url_seo);
        if (img) {
            formData.append('fileUpload', img);
        }

        // Gửi dữ liệu qua AJAX
        $.ajax({
            url: "{{ route('admin.post.store') }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Hiển thị modal thông báo thành công
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Tùy chọn: tự động điều hướng đến trang bài viết sau một khoảng thời gian
                setTimeout(function() {
                    window.location.href = '{{ route('admin.viewpost') }}';
                }, 2000); // Thay đổi thời gian (ms) nếu cần
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
        $('#postForm')[0].reset();
        CKEDITOR.instances['content1'].setData('');
        CKEDITOR.instances['description'].setData('');
        $("#fileUpload").attr("src", "{{ asset('/images/img-upload.jpg') }}");
        $("#url_seo").val('');
    }
</script>

@endsection
