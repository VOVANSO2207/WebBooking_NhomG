@extends('admin.layouts.master')
@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="postForm" action="{{ route('admin.post.update', $post->post_id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ asset('images/' . $post->img) }}" alt="user-avatar" class="d-block rounded"
                                    height="100" width="100" id="fileUpload" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="fileUpload" class="account-file-input"
                                            hidden accept="image/png, image/jpeg, image/jpg" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Title</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{ old('title', $post->title) }}" placeholder="Title" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description"
                                    required>{{ old('title', $post->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Content</label>
                                <textarea name="content1" id="content1"
                                    required>{{ old('title', $post->content) }}</textarea>
                                @error('content1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Meta Desc</label>
                                <input class="form-control" type="text" id="meta_desc" name="meta_desc"
                                    value="{{ old('meta_desc', $post->meta_desc) }}" placeholder="Meta Desc" />
                                @error('meta_desc')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="select2 form-select">
                                    <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Show</option>
                                    <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Hidden</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Url Seo</label>
                                <input class="form-control" type="text" id="url_seo" name="url_seo"
                                    value="{{ old('url_seo', $post->url_seo) }}" placeholder="Url Seo" readonly />
                            </div>
                            <input class="form-control" type="hidden" id="updated_at" name="updated_at"
                                value="{{ old('update_at', $post->updated_at) }}" />
                        </div>

                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='{{ route('admin.viewpost') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<!-- Modal xung đột cập nhật -->
<div class="modal fade" id="conflictModal" tabindex="-1" aria-labelledby="conflictModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="conflictModalLabel">Thông báo xung đột cập nhật</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bài viết đã được cập nhật bởi một người dùng khác. Vui lòng tải lại và thử lại.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-secondary" style="#3B79C9 !important" onclick="location.reload()">Tải lại trang</button>
            </div>
        </div>
    </div>
</div>

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
<div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSuccessModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Cập nhật bài viết thành công.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>  CKEDITOR.replace('content1', {
        filebrowserUploadUrl: "path/to/upload/image"
    });

    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "path/to/upload/image"
    });
</script>
<script>
    let initialContent = '';
    let initialDescription1 = '';
    // Lưu nội dung ban đầu khi CKEditor được tải lần đầu
    CKEDITOR.instances.content1.on('instanceReady', function () {
        initialContent = CKEDITOR.instances.content1.getData();
    });
    CKEDITOR.instances.description.on('instanceReady', function () {
        initialDescription1 = CKEDITOR.instances.description.getData();
    });


    $(document).ready(function () {
        let isChanged = false; // Biến để theo dõi sự thay đổi

        function resetForm() {
            $('#postForm')[0].reset();
            CKEDITOR.instances['content1'].setData('');
            CKEDITOR.instances['description'].setData('');
            $("#upload").val(''); // Reset input file
            $("#url_seo").val('');
            isChanged = false; // Reset biến isChanged khi reset form
        }

        $("#title").on("keyup input", function () {
            var inputValue = $(this).val();
            var trimmedValue = inputValue.replace(/\s+$/, "");
            var formattedValue = trimmedValue
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/\s+/g, "-");
            $("#url_seo").val(formattedValue);
        });

        function checkForChanges() {
            var title = $('#title').val();
            var description = CKEDITOR.instances.description.getData();
            var content = CKEDITOR.instances.content1.getData();
            var meta_desc = $('#meta_desc').val();
            var statusValue = $('#status option:selected').val();
            var updated_at = $('#updated_at').val();

            if (
                title !== '{{ addslashes(old('title', $post->title)) }}' ||
                description !== initialDescription1 ||
                content !== initialContent ||
                meta_desc !== '{{ addslashes(old('meta_desc', $post->meta_desc)) }}' ||
                statusValue !== '{{ $post->status }}'
            ) {
                isChanged = true;
            } else {
                isChanged = false;
            }
        }


        $('#title, #meta_desc, #status').on('input change', function () {
            checkForChanges();
        });


        CKEDITOR.instances['description'].on('change', checkForChanges);
        CKEDITOR.instances['content1'].on('change', checkForChanges);

        $('#upload').on('change', function () {
            isChanged = true;
        });


        $('#postForm').on('submit', function (event) {
            event.preventDefault();
            if (!isChanged) {
                console.log(updated_at);
                const noUpdateModal = new bootstrap.Modal(document.getElementById('noUpdateModal'));
                noUpdateModal.show();
                return;
            }


            var formData = new FormData(this);
            // Lấy dữ liệu từ CKEditor và thêm vào FormData
            formData.append('description', CKEDITOR.instances['description'].getData());
            formData.append('content1', CKEDITOR.instances['content1'].getData());

            $.ajax({
                url: "{{ route('admin.post.update', $post->post_id) }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {

                    const updateSuccessModal = new bootstrap.Modal(document.getElementById('updateSuccessModal'));
                    updateSuccessModal.show();

                    setTimeout(function () {
                        window.location.href = '{{ route('admin.viewpost') }}';
                    }, 2000);
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