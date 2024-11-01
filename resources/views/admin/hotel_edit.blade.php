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
                                    value="{{ old('hotel_name', $hotel->hotel_name) }}" placeholder="Hotel Name" required />
                                @error('hotel_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Location</label>
                                <input class="form-control" type="text" name="location" id="location"
                                    value="{{ old('location', $hotel->location) }}" placeholder="Location" required />
                                @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">City ID</label>
                                <select class="form-control" name="city_id" id="city_id" required>
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
                                <select name="amenities[]" class="form-select select2" id="amenities" multiple="multiple" required>
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
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description" required>{{ old('description', $hotel->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="mb-3 col-md-5">
    <label class="form-label">Hotel Rooms</label>
    <select name="rooms[]" class="form-select select2" id="rooms" multiple="multiple" required>
        @foreach ($rooms as $room)
            <option value="{{ $room->room_id }}" data-name="{{ $room->name }}" data-price="{{ $room->price }}"
                @if(in_array($room->room_id, $currentRooms)) selected @endif>
                {{ $room->name }} - Giá: {{ $room->price }} - Số người tối đa: {{ $room->capacity }}
            </option>
        @endforeach
    </select>
</div>



<div class="mb-3 col-md-6">
    <label class="form-label">Rating</label>
    <input class="form-control" type="number" name="rating" id="rating" 
        min="1" max="5" step="0.1"
        value="{{ old('rating', $hotel->rating) }}" placeholder="Rating" required />
    @error('rating')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


                            <div class="mb-3 col-md-6">
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
<!-- / Modal -->

<script>
// Xem trước hình ảnh khi chọn file
document.getElementById('upload').addEventListener('change', function(event) {
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    imagePreviewContainer.innerHTML = ''; // Xóa hình ảnh cũ

    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail me-2';
            img.style.width = '100px';
            img.style.height = 'auto';

            // Tùy chọn xóa ảnh xem trước
            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm';
            removeBtn.innerText = 'X';
            removeBtn.style.position = 'absolute';
            removeBtn.style.marginLeft = '-20px';
            removeBtn.onclick = () => imagePreviewContainer.removeChild(wrapper);

            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);

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
window.onload = updateDescriptions;

</script>

@endsection
