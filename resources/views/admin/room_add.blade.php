@extends('admin.layouts.master')
@section('admin-container')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" action="{{ route('room_store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Room Name"
                                        required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Room Type</label>
                                    <select name="room_type_id" class="form-select" required>
                                        @foreach ($roomTypes as $roomType)
                                            <option value="{{ $roomType->room_type_id }}">{{ $roomType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Price Base</label>
                                    <input class="form-control" type="text" name="price" placeholder="Price Base"
                                        required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Discount Percent</label>
                                    <input class="form-control" type="text" name="discount_percent"
                                        placeholder="Discount Percent" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Price Sales</label>
                                    <input class="form-control" type="text" name="sales_price" placeholder="Price Sales"
                                        readonly />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Capacity</label>
                                    <input class="form-control" type="text" name="capacity" placeholder="Capacity"
                                        required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Upload Images</label>
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div id="imagePreviewContainer" class="d-flex flex-wrap"></div>
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
                                            <option value="{{ $amenity->amenity_id }}">{{ $amenity->amenity_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="description" required></textarea>
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
    <!-- Hiện thông báo khi update thành công -->
    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2" style="color: #28a745;"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
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
    @if (session('error'))
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="errorToast">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
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
            if ({{ session('error') ? 'true' : 'false' }}) {
                var infoToast = new bootstrap.Toast(document.getElementById('errorToast'), {
                    delay: 1500
                });
                infoToast.show();
            }
        });
        window.onload = function() {
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: "path/to/upload/image" // Sửa đường dẫn này cho đúng
            });

            // Tính toán Price Sales
            var priceInput = document.querySelector('input[name="price"]');
            var discountInput = document.querySelector('input[name="discount_percent"]');
            var salesPriceInput = document.querySelector('input[name="sales_price"]');
            discountInput.addEventListener('input', function() {
                if (this.value > 100) {
                    alert('Giá trị phần trăm giảm giá không được vượt quá 100!');
                    this.value = '';
                }
            });

            function formatCurrency(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' VND'; // Định dạng số với dấu phẩy
            }

            function calculateSalesPrice() {
                var price = parseFloat(priceInput.value) || 0;
                var discountPercent = parseFloat(discountInput.value) || 0;
                var salesPrice = price * (1 - discountPercent / 100);
                salesPriceInput.value = formatCurrency(salesPrice.toFixed(
                    0)); // Hiển thị giá giảm với định dạng tiền tệ
            }

            priceInput.addEventListener('input', calculateSalesPrice);
            discountInput.addEventListener('input', calculateSalesPrice);

            // Preview ảnh
            document.getElementById('upload').addEventListener('change', function(event) {
                var imagePreviewContainer = document.getElementById('imagePreviewContainer');
                var files = event.target.files;

                // Xóa các ảnh cũ
                imagePreviewContainer.innerHTML = '';

                if (files.length === 0) {
                    alert(
                        "Vui lòng tải lên ảnh của khách sạn (PNG, JPG)"); // Hiển thị thông báo nếu không có ảnh
                    return; // Dừng lại nếu không có tệp nào
                }

                let validFiles = true; // Biến để theo dõi xem tất cả các tệp có hợp lệ không
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileExtension = file.name.split('.').pop().toLowerCase(); // Lấy phần mở rộng của tệp

                    // Kiểm tra định dạng tệp
                    if (fileExtension !== 'png' && fileExtension !== 'jpg' && fileExtension !== 'jpeg') {
                        validFiles = false; // Đánh dấu là không hợp lệ nếu có tệp không hợp lệ
                        break; // Ngừng kiểm tra khi tìm thấy tệp không hợp lệ
                    }

                    // Nếu tệp hợp lệ, hiển thị hình ảnh
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.marginRight = '10px';
                        img.style.marginBottom = '10px'; // Khoảng cách giữa các hình ảnh
                        img.style.borderRadius = '5px'; // Bo góc cho hình ảnh
                        imagePreviewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }

                // Hiển thị thông báo lỗi nếu có tệp không hợp lệ
                if (!validFiles) {
                    alert("Định dạng ảnh không hợp lệ. Vui lòng tải lên ảnh định dạng PNG hoặc JPG."); // 
                    // Xóa tất cả các ảnh đã được hiển thị
                    imagePreviewContainer.innerHTML = '';
                    // Đặt lại input file
                    event.target.value = '';
                }
            });

            // Kiểm tra khi gửi biểu mẫu
            document.getElementById('formAccountSettings').addEventListener('submit', function(event) {
                var files = document.getElementById('upload').files;
                if (files.length === 0) {
                    event.preventDefault(); // Ngăn chặn gửi biểu mẫu
                    alert("Vui lòng tải lên ảnh của khách sạn (PNG, JPG)"); // Hiển thị thông báo lỗi
                }
            });
        };
    </script>
@endsection
