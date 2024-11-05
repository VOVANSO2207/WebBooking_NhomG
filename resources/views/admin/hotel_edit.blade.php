@extends('admin.layouts.master') 
@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="hotelForm" action="{{ route('hotel.update', $hotel->hotel_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Thêm phương thức PUT để cập nhật -->
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Hotel Name</label>
                                <input class="form-control" type="text" name="hotel_name" id="hotel_name"
                                    value="{{ old('hotel_name', $hotel->hotel_name) }}" placeholder="Hotel Name" />
                                @error('hotel_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Location</label>
                                <input class="form-control" type="text" name="location" id="location"
                                    value="{{ old('location', $hotel->location) }}" placeholder="Location" />
                                @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">City ID</label>
                                <select class="form-control" name="city_id" id="city_id">
                                    <option value="">Chọn thành phố</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->city_id }}" {{ $city->city_id == $hotel->city_id ? 'selected' : '' }}>
                                            {{ $city->city_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label">Hotel Amenities</label>
                                <select name="amenities[]" class="form-select select2" id="amenities" multiple="multiple">
                                    @php
                                        $amenityNames = []; // Mảng để theo dõi tên tiện nghi đã hiển thị
                                    @endphp
                                    @foreach ($hotelAmenities as $amenity)
                                        @if (!in_array($amenity->amenity_name, $amenityNames)) // Kiểm tra nếu tên chưa được thêm vào
                                            <option value="{{ $amenity->amenity_id }}" 
                                            @if(in_array($amenity->amenity_id, $currentAmenities)) selected @endif 
                                            data-name="{{ $amenity->amenity_name }}" data-description="{{ $amenity->description }}">
                                                {{ $amenity->amenity_name }}
                                            </option>
                                            @php
                                                $amenityNames[] = $amenity->amenity_name; // Thêm tên tiện nghi vào mảng
                                            @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Các trường ẩn để lưu trữ thông tin tiện nghi -->
                            <input type="hidden" name="amenity_names[]" id="amenity_names">
                            <input type="hidden" name="descriptions[]" id="descriptions">

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Rating</label>
                                <input class="form-control" type="number" name="rating" id="rating" 
                                    min="1" max="5" step="0.1"
                                    value="{{ old('rating', $hotel->rating) }}" placeholder="Rating" />
                                @error('rating')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-5">
                                <label class="form-label">Hotel Rooms</label>
                                <select name="rooms[]" class="form-select select2" id="rooms" multiple="multiple">
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->room_id }}" data-name="{{ $room->name }}" data-price="{{ $room->price }}"
                                            @if(in_array($room->room_id, $currentRooms)) selected @endif>
                                            {{ $room->name }} - Giá: {{ $room->price }} - Số người tối đa: {{ $room->capacity }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Upload Images</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <div id="imagePreviewContainer" class="d-flex flex-wrap">
                                        <!-- Hiển thị ảnh hiện tại nếu có -->
                                        @foreach($hotel->images as $image)
                                            <div class="position-relative me-2">
                                                <img src="{{ asset('images/' . $image->image_url) }}" class="img-thumbnail me-2" style="width: 100px; height: auto;">
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
                        </div>

                        <div class="mb-3 col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Description">{{ old('description', $hotel->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='{{ route('admin.viewhotel') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<script>
// Xem trước hình ảnh khi chọn file
document.getElementById('upload').addEventListener('change', function(event) {
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const files = event.target.files;

    // Xóa tất cả ảnh hiện tại
    imagePreviewContainer.innerHTML = '';

    // Giới hạn số lượng ảnh upload là 4
    if (files.length > 4) {
        alert("Bạn chỉ có thể upload tối đa 4 ảnh.");
        return;
    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail me-2';
            img.style.width = '100px';
            img.style.height = 'auto';

            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.appendChild(img);

            imagePreviewContainer.appendChild(wrapper);
        }
        reader.readAsDataURL(file);
    }
});

// Cập nhật mô tả tiện nghi
document.getElementById('amenities').addEventListener('change', updateDescriptions);

function updateDescriptions() {
    const descriptionsInput = document.getElementById('descriptions');
    const amenitiesSelect = document.getElementById('amenities');
    const selectedOptions = Array.from(amenitiesSelect.selectedOptions);
    const descriptions = selectedOptions.map(option => option.getAttribute('data-description')).filter(Boolean);

    descriptionsInput.value = descriptions.join(', ');
}

// Cập nhật mô tả khi tải trang
window.onload = function () {
    CKEDITOR.replace('description', {
        filebrowserUploadUrl: "path/to/upload/image" // Sửa đường dẫn này cho đúng
    });

    // Tính toán Price Sales
    var priceInput = document.querySelector('input[name="price"]');
    var discountInput = document.querySelector('input[name="discount_percent"]');
    var salesPriceInput = document.querySelector('input[name="sales_price"]');

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
    document.getElementById('upload').addEventListener('change', function (event) {
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
            reader.onload = function (e) {
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
    document.getElementById('formAccountSettings').addEventListener('submit', function (event) {
        var files = document.getElementById('upload').files;
        if (files.length === 0) {
            event.preventDefault(); // Ngăn chặn gửi biểu mẫu
            alert("Vui lòng tải lên ảnh của khách sạn (PNG, JPG)"); // Hiển thị thông báo lỗi
        }
    });
};

</script>

@endsection
