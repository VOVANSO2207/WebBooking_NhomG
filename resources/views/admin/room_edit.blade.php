@extends('admin.layouts.master')
@section('admin-container')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" action="{{ route('room_update', $room->room_id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Chỉ định phương thức PUT để cập nhật -->
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Room Name"
                                        value="{{ $room->name }}" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Room Type</label>
                                    <select name="room_type_id" class="form-select" required>
                                        @foreach ($roomTypes as $roomType)
                                            <option value="{{ $roomType->room_type_id }}"
                                                {{ $roomType->room_type_id == $room->room_type_id ? 'selected' : '' }}>
                                                {{ $roomType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Price Base</label>
                                    <input class="form-control" type="text" name="price" placeholder="Price Base"
                                        value="{{ $room->price }}" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Discount Percent</label>
                                    <input class="form-control" type="text" name="discount_percent"
                                        placeholder="Discount Percent" value="{{ $room->discount_percent }}" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Price Sales</label>
                                    <input class="form-control" type="text" name="sales_price" placeholder="Price Sales"
                                        value="{{ $room->sales_price }}" readonly />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Capacity</label>
                                    <input class="form-control" type="text" name="capacity" placeholder="Capacity"
                                        value="{{ $room->capacity }}" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Upload Images</label>
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div id="imagePreviewContainer" class="d-flex flex-wrap">
                                            @foreach ($room->room_images as $image)
                                                <div class="image-preview-wrapper" data-id="{{ $image->image_id }}"
                                                    style="position: relative; margin-right: 10px; margin-bottom: 10px;">
                                                    <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                                        alt="Room Image" style="width: 100px; border-radius: 5px;">
                                                    <!-- Nút x để xóa ảnh -->
                                                    <span class="remove-image"
                                                        style="position: absolute; top: -10px; right: 73px; cursor: pointer; color: red; font-size: 32px;">&times;</span>
                                                    <input type="hidden" name="existing_images[]"
                                                        value="{{ $image->image_id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Upload</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="upload" name="images[]" multiple
                                                    class="account-file-input" hidden
                                                    accept="image/png, image/jpeg, image/jpg" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Room Amenities</label>
                                    <select name="amenities[]" class="form-select select2" multiple="multiple" required>
                                        @foreach ($amenities as $amenity)
                                            <option value="{{ $amenity->amenity_id }}"
                                                {{ in_array($amenity->amenity_name, $room->amenities->pluck('amenity_name')->toArray()) ? 'selected' : '' }}>
                                                {{ $amenity->amenity_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="description" required>{{ $room->description }}</textarea>
                                </div>
                            </div>
                            <div class="mt-2" style="text-align: right">
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="window.location.href='{{ route('admin.viewroom') }}'">Close</button>
                                <button type="submit" class="btn btn-outline-success me-2">Save</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <!-- Hiện thông báo khi update thành công -->
    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2" style="color: #28a745;"></i> 
                    {{ session('success') }}    
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
@if (session('info'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div id="infoToast" class="toast align-items-center text-bg-info border-0" role="alert"
        aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-info-circle-fill me-2" style="color: #0dcaf0;"></i>
                {{ session('info') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
    <script>
           document.addEventListener('DOMContentLoaded', function() {
            if ({{ session('success') ? 'true' : 'false' }}) {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'), {
                    delay: 1500
                });
                successToast.show();
            }
            if ({{ session('info') ? 'true' : 'false' }}) {
                var infoToast = new bootstrap.Toast(document.getElementById('infoToast'), {
                    delay: 1500
                });
                infoToast.show();
            }
        });
        window.onload = function() {
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: "path/to/upload/image"
            });

            // Tính toán Price Sales
            var priceInput = document.querySelector('input[name="price"]');
            var discountInput = document.querySelector('input[name="discount_percent"]');
            var salesPriceInput = document.querySelector('input[name="sales_price"]');

            function formatCurrency(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VND';
            }

            function calculateSalesPrice() {
                var price = parseFloat(priceInput.value) || 0;
                var discountPercent = parseFloat(discountInput.value) || 0;
                var salesPrice = price * (1 - discountPercent / 100);
                salesPriceInput.value = formatCurrency(salesPrice.toFixed(0));
            }

            priceInput.addEventListener('input', calculateSalesPrice);
            discountInput.addEventListener('input', calculateSalesPrice);

            // Xử lý xóa ảnh bằng Ajax
            function handleImageDelete() {
                document.querySelectorAll('.remove-image').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const imageWrapper = this.closest('.image-preview-wrapper');
                        const imageId = imageWrapper.getAttribute('data-id');

                        if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
                            // Gửi request Ajax để xóa ảnh
                            fetch(`/admin/room/delete-image/${imageId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'Accept': 'application/json',
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        imageWrapper.remove();
                                        if (document.querySelectorAll('.image-preview-wrapper')
                                            .length === 0 &&
                                            document.getElementById('upload').files.length === 0) {
                                            document.getElementById('imagePreviewContainer')
                                                .innerHTML =
                                                '<p class="text-muted">No images uploaded</p>';
                                        }
                                    } else {
                                        alert(data.message ||
                                            'Không thể xóa ảnh. Vui lòng thử lại!');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Đã xảy ra lỗi khi xóa ảnh: ' + error.message);
                                });
                        }
                    });
                });
            }

            // Khởi tạo xử lý xóa ảnh cho các ảnh hiện có
            handleImageDelete();

            // Xử lý preview ảnh mới
            document.getElementById('upload').addEventListener('change', function(event) {
                var files = event.target.files;

                if (files.length === 0) {
                    alert("Vui lòng tải lên ảnh của khách sạn (PNG, JPG)");
                    return;
                }

                let validFiles = true;
                // Tạo container tạm thời để lưu các ảnh mới
                const newImagesContainer = document.createElement('div');

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileExtension = file.name.split('.').pop().toLowerCase();

                    if (fileExtension !== 'png' && fileExtension !== 'jpg' && fileExtension !== 'jpeg') {
                        validFiles = false;
                        break;
                    }

                    let reader = new FileReader();
                    reader.onload = function(e) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'image-preview-wrapper';
                        previewWrapper.style.position = 'relative';
                        previewWrapper.style.marginRight = '10px';
                        previewWrapper.style.marginBottom = '10px';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.borderRadius = '5px';

                        const removeBtn = document.createElement('span');
                        removeBtn.className = 'remove-image';
                        removeBtn.innerHTML = '&times;';
                        removeBtn.style.position = 'absolute';
                        removeBtn.style.top = '-10px';
                        removeBtn.style.right = '73px';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.color = 'red';
                        removeBtn.style.fontSize = '32px';

                        removeBtn.addEventListener('click', function() {
                            previewWrapper.remove();
                        });

                        previewWrapper.appendChild(img);
                        previewWrapper.appendChild(removeBtn);
                        newImagesContainer.appendChild(previewWrapper);
                    };
                    reader.readAsDataURL(file);
                }

                if (!validFiles) {
                    alert("Định dạng ảnh không hợp lệ. Vui lòng tải lên ảnh định dạng PNG hoặc JPG.");
                    event.target.value = '';
                    return;
                }

                // Thêm ảnh mới vào sau các ảnh hiện có
                const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                imagePreviewContainer.appendChild(newImagesContainer);
            });

            // Kiểm tra form submit
            document.getElementById('formAccountSettings').addEventListener('submit', function(event) {
                const existingImages = document.querySelectorAll('input[name="existing_images[]"]').length;
                const newImages = document.getElementById('upload').files.length;

                if (existingImages === 0 && newImages === 0) {
                    event.preventDefault();
                    alert("Vui lòng tải lên ít nhất một ảnh cho khách sạn.");
                }
            });
        };
    </script>
@endsection
