@extends('admin.layouts.master')
@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="postForm" action="{{ route('admin.post.update', $post->post_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ asset('images/' . $post->img) }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="fileUpload" />
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
                                <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $post->title) }}" placeholder="Title" required />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description" required>{{ old('description', $post->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Content</label>
                                <textarea name="content1" id="content1" required>{{ old('content1', $post->content) }}</textarea>
                                @error('content1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Meta Desc</label>
                                <input class="form-control" type="text" id="meta_desc" name="meta_desc" value="{{ old('meta_desc', $post->meta_desc) }}" placeholder="Meta Desc" />
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
                                <input class="form-control" type="text" id="url_seo" name="url_seo" value="{{ old('url_seo', $post->url_seo) }}" placeholder="Url Seo" readonly />
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
<script>
    $(document).ready(function () {
        CKEDITOR.replace('content1', {
            filebrowserUploadUrl: "path/to/upload/image"
        });

        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "path/to/upload/image"
        });

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

            if (
                title !== '{{ addslashes(old('title', $post->title)) }}' ||
                description !== '{{ addslashes(old('description', $post->description)) }}' ||
                content !== '{{ addslashes(old('content1', $post->content)) }}' ||
                meta_desc !== '{{ addslashes(old('meta_desc', $post->meta_desc)) }}' ||
                statusValue !== '{{ $post->status }}'
            ) {
                isChanged = true;
            } else {
                isChanged = false;
            }
        }

      
        $('#title, #meta_desc, #status').on('input change', function() {
            checkForChanges(); 
        });

   
        CKEDITOR.instances['description'].on('change', checkForChanges);
        CKEDITOR.instances['content1'].on('change', checkForChanges);

   
        $('#upload').on('change', function() {
            isChanged = true; 
        });

 
        $('#postForm').on('submit', function (event) {
            event.preventDefault();

        
            if (!isChanged) {
             
                const noUpdateModal = new bootstrap.Modal(document.getElementById('noUpdateModal'));
                noUpdateModal.show(); 
                return; 
            }

         
            var formData = new FormData(this);
          
            $.ajax({
                url: "{{ route('admin.post.update', $post->post_id) }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    const updateSuccessModal = new bootstrap.Modal(document.getElementById('updateSuccessModal'));
                    updateSuccessModal.show(); 
                    
                    setTimeout(function() {
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
                            $('[name="' + key + '"]').after(errorDiv);
                        }
                    }
                }
            });
        });
    });
</script>

@endsection
