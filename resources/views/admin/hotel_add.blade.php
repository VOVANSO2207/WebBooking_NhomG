@extends('admin.layouts.master') 
@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="hotelForm" action="{{ route('admin.hotel.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Hotel Name</label>
                                <input class="form-control" type="text" name="hotel_name" id="hotel_name"
                                    value="{{ old('hotel_name') }}" placeholder="Hotel Name" />
                                @error('hotel_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Location</label>
                                <input class="form-control" type="text" name="location" id="location"
                                    value="{{ old('location') }}" placeholder="Location" />
                                @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">City</label>
                                <select class="form-control" name="city_id" id="city_id">
                                    <option value="{{ $cities->first()->city_id ?? '' }}" selected>{{ $cities->first()->city_name ?? 'Chọn thành phố' }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
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
                                        $firstAmenityId = null; // Biến để lưu ID của tiện nghi đầu tiên
                                    @endphp
                                    @foreach ($hotelAmenities as $index => $amenity)
                                        @if (!in_array($amenity->amenity_name, $amenityNames)) // Kiểm tra nếu tên chưa được thêm vào
                                            <option value="{{ $amenity->amenity_id }}" data-name="{{ $amenity->amenity_name }}"
                                                data-description="{{ $amenity->description }}"
                                                @if ($index === 0) selected @endif> <!-- Chọn tiện nghi đầu tiên -->
                                                {{ $amenity->amenity_name }}
                                            </option>
                                            @php
                                                $amenityNames[] = $amenity->amenity_name; // Thêm tên tiện nghi vào mảng
                                            @endphp
                                        @endif
                                    @endforeach
                                </select>
                                @error('amenities')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Các trường ẩn để lưu trữ thông tin tiện nghi -->
                            <input type="hidden" name="amenity_names[]" id="amenity_names">
                            <input type="hidden" name="descriptions[]" id="descriptions">

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Rating</label>
                                <input class="form-control" type="number" name="rating" id="rating" min="1" max="5"
                                    step="0.1" value="{{ old('rating', 2) }}" placeholder="Rating" />
                                @error('rating')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-5">
                            <label class="form-label">Hotel Rooms</label>
                            <select name="rooms[]" class="form-select select2" id="rooms" onchange="addSelectedRooms()">
                                @php
                                    $roomNames = []; // Mảng để theo dõi tên phòng đã hiển thị
                                    $firstRoomSelected = false; // Biến để kiểm tra xem phòng đầu tiên đã được chọn hay chưa
                                @endphp
                                @foreach ($hotelRooms as $room)
                                    @if (!in_array($room->name, $roomNames)) // Kiểm tra nếu tên chưa được thêm vào
                                        <option value="{{ $room->room_id }}" data-name="{{ $room->name }}" data-price="{{ $room->price }}" data-image="{{ $room->room_images->isNotEmpty() ? asset('storage/images/' . $room->room_images[0]->image_url) : asset('/storage/images/default_image.jpg') }}" @if (!$firstRoomSelected) selected @endif> <!-- Chọn phòng đầu tiên -->
                                            {{ $room->name }} - Giá: {{ $room->price }} - Số người tối đa: {{ $room->capacity }}
                                        </option>
                                        @php
                                            $roomNames[] = $room->name; // Thêm tên phòng vào mảng
                                            $firstRoomSelected = true; // Đánh dấu là phòng đầu tiên đã được chọn
                                        @endphp
                                    @endif
                                @endforeach
                            </select>
                            @error('rooms')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Khu vực hiển thị các phòng đã chọn -->
                        <div class="col-md-12 mt-4">
                            <h5>Selected Rooms</h5>
                            <div id="selectedRoomsContainer" class="d-flex flex-wrap"></div>
                        </div>

                        <!-- Input ẩn chứa danh sách phòng đã chọn -->
                        <input type="hidden" name="selected_rooms" id="selectedRoomsInput" value="{{ old('selected_rooms', json_encode($selectedRooms ?? [])) }}">

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Upload Images</label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <div id="imagePreviewContainer" class="d-flex flex-wrap">
                                        <!-- Hiển thị hình ảnh mặc định -->
                                        <div class="image-preview">
                                            <img src="{{ asset('images/img-upload.jpg') }}" alt="Default Image" class="img-thumbnail" style="width: 100px; height: auto;">
                                        </div>
                                    </div>
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" name="images[]" multiple class="account-file-input" hidden accept="image/png, image/jpeg, image/jpg" />
                                        </label>
                                    </div>
                                </div>
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror 
                            </div>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description"></textarea>
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
    document.getElementById('upload').addEventListener('change', function (event) {
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        imagePreviewContainer.innerHTML = ''; // Clear previous images

        const files = event.target.files; // Get the selected files
        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Create a FileReader to read the file
            const reader = new FileReader();
            reader.onload = function (e) {
                // Create an image element and set its source
                const img = document.createElement('img');
                img.src = e.target.result; // Set the source to the FileReader result
                img.className = 'img-thumbnail me-2'; // Add styling classes
                img.style.width = '100px'; // Set width for preview
                img.style.height = 'auto'; // Maintain aspect ratio

                // Append the image to the preview container
                imagePreviewContainer.appendChild(img);
            }
            // Read the file as a data URL
            reader.readAsDataURL(file);
        }
    });

    function updateDescriptions() {
        const descriptionsInput = document.getElementById('descriptions');
        const amenitiesSelect = document.getElementById('amenities');
        const selectedOptions = Array.from(amenitiesSelect.selectedOptions); // Lấy tất cả các tùy chọn đã chọn
        const descriptions = []; // Khởi tạo mảng để lưu trữ mô tả

        // Lấy mô tả từ các tùy chọn đã chọn
        selectedOptions.forEach(option => {
            descriptions.push(option.getAttribute('data-description')); // Lấy description từ bảng tiện nghi
        });

        // Gán các mô tả vào trường ẩn
        descriptionsInput.value = descriptions.join(', '); // Nối các mô tả với dấu phẩy
    }

    window.onload = function () {
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "path/to/upload/image" // Sửa đường dẫn này cho đúng
        });
    };

    let selectedRooms = [];

function addSelectedRooms() {
    const roomsSelect = document.getElementById('rooms');
    const selectedOptions = roomsSelect.selectedOptions;
    
    // Duyệt qua các phòng được chọn
    for (let option of selectedOptions) {
        const roomId = option.value;
        const roomImageUrl = option.getAttribute('data-image') || "{{ asset('storage/images/default_image.jpg') }}";
        const roomName = option.getAttribute('data-name');
        const roomPrice = option.getAttribute('data-price');
        
        if (selectedRooms.includes(roomId)) {
            continue; // Bỏ qua nếu phòng đã chọn
        }

        // Thêm phòng vào danh sách tạm thời
        selectedRooms.push(roomId);
        document.getElementById('selectedRoomsInput').value = JSON.stringify(selectedRooms);

        // Tạo một thẻ div để chứa thông tin phòng đã chọn
        const roomDiv = document.createElement('div');
        roomDiv.classList.add('selected-room', 'p-2', 'm-2', 'border', 'position-relative', 'text-center');
        roomDiv.style.width = '150px';
        roomDiv.id = `selected-room-${roomId}`;

        roomDiv.innerHTML = `
            <button type="button" class="btn-close position-absolute" style="top: 5px; right: 5px;" onclick="removeSelectedRoom('${roomId}')"></button>
            <img src="${roomImageUrl}" alt="Room Image" style="width: 100%; height: auto;">
            <div style="font-weight: bold; margin-top: 5px;">${roomName}</div>
            <div>Giá: ${roomPrice} VND</div>
        `;

        document.getElementById('selectedRoomsContainer').appendChild(roomDiv);
    }
}

// Hàm xóa phòng đã chọn
function removeSelectedRoom(roomId) {
    selectedRooms = selectedRooms.filter(id => id !== roomId);
    document.getElementById('selectedRoomsInput').value = JSON.stringify(selectedRooms);
    document.getElementById(`selected-room-${roomId}`).remove();
}

// Gọi hàm addSelectedRooms() khi trang tải xong để cập nhật phòng mặc định (phòng đầu tiên)
document.addEventListener("DOMContentLoaded", function() {
    addSelectedRooms(); // Gọi hàm để thêm phòng đầu tiên vào danh sách đã chọn
});

// Hàm gửi dữ liệu qua Ajax
function submitSelectedRooms() {
    const selectedRoomsData = JSON.stringify(selectedRooms); // Đảm bảo dữ liệu là chuỗi JSON hợp lệ

    $.ajax({
        url: '/store-rooms', // Đường dẫn route lưu trữ
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            selected_rooms: JSON.stringify(selectedRooms)  // Gửi dưới dạng chuỗi JSON
        },
        success: function(response) {
            alert('Rooms saved successfully');
        },
        error: function(error) {
            console.log(error);
            alert('There was an error saving the rooms');
        }
    });

}
</script>

@endsection