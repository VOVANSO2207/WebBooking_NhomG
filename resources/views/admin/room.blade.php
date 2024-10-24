    @extends('admin.layouts.master')
    @section('admin-container')
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="bx bx-menu bx-sm"></i>
                </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <div class="navbar-nav align-items-center" style="width: 100%;">
                    <div class="nav-item d-flex align-items-center" style="width: 100%;">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="form-control border-0 shadow-none" id="search_post"
                            placeholder="Search..." aria-label="Search..." style="width: 100%;" />
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div id="successMessage" class="alert alert-success d-none" role="alert">
                    Xóa phòng thành công!
                </div>
                <div class="card">
                    <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">ROOM</h5>
                    <div class="add">
                        <a class="btn btn-success" href="{{ route('room_add') }}">Add</a>
                    </div>
                    <div class="table-responsive text-nowrap content1">
                        <table class="table">
                            <thead>
                                <tr class="color_tr">
                                    <th>STT</th>
                                    <th>Image</th>
                                    <th>Name Room</th>
                                    <th>Capacity</th>
                                    <th>Room Type</th>
                                    <th>Price Base</th>
                                    <th>Discount Percent</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0 alldata">
                                @forelse($rooms as $key => $room)
                                    <tr data-room="{{ $room->toJson() }}" style="cursor: pointer;">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <div class="swiper room-swiper">
                                                <div class="swiper-wrapper">
                                                    @foreach ($room->room_images as $image)
                                                        <div class="swiper-slide">
                                                            @if (file_exists(public_path('images/' . $image->image_url)))
                                                                <img src="{{ asset('images/' . $image->image_url) }}"
                                                                    alt="Room Image">
                                                            @elseif (file_exists(public_path('storage/images/' . $image->image_url)))
                                                                <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                                                    alt="Room Image">
                                                            @else
                                                                <img src="{{ asset('images/img-upload.jpg') }}"
                                                                    alt="Default Image">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!-- Thêm điều hướng -->
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </td>
                                        <td>{{ $room->name }}</td>
                                        <td>{{ $room->capacity }}</td>
                                        <td>{{ $room->roomType ? $room->roomType->name : 'N/A' }}</td>
                                        <td>{{ $room->price }}</td>
                                        <td>{{ $room->discount_percent }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có room nào để hiển thị.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3 pagination-room">
                        {{ $rooms->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade room-detail-modal" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="roomModalLabel">Room Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="room-detail-container">
                            <!-- Image Gallery -->
                            <div class="gallery-section">
                                <div class="swiper room-image-swiper">
                                    <div class="swiper-wrapper" id="modalImages">
                                        <!-- Dynamic image slides -->
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </div>

                            <!-- Room Information Grid -->
                            <div class="room-info-grid">
                                <div class="info-card">
                                    <div class="info-label">Name Room</div>
                                    <div class="info-value" id="modalName"></div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">Capacity</div>
                                    <div class="info-value" id="modalCapacity"></div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">Room Type</div>
                                    <div class="info-value" id="modalRoomType"></div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">Price Base</div>
                                    <div class="info-value" id="modalPriceBase"></div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">Price Sales</div>
                                    <div class="info-value" id="modalPriceSales"></div>
                                </div>
                                <div class="info-card">
                                    <div class="info-label">Discount</div>
                                    <div class="info-value" id="modalDiscountPercent"></div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="description-section">
                                <h6 class="info-label">Description</h6>
                                <div class="description-content" id="modalDescription"></div>
                            </div>

                            <!-- Amenities Section -->
                            <div class="amenities-section" id="modalAmenities">
                                <!-- Dynamic amenity tags -->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <form id="deleteRoomForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-action btn-delete">Delete Room</button>
                        </form>
                        <button id="editRoomButton" type="button" class="btn btn-action btn-edit">Edit Room</button>
                        <button type="button" class="btn btn-action btn-close-modal"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- JavaScript -->
        <script>
            document.querySelectorAll('.table tbody tr').forEach(function(row) {
                row.addEventListener('click', function(e) {
                    if (e.target.tagName === 'IMG' || e.target.closest('.swiper-button-next') || e.target
                        .closest('.swiper-button-prev')) {
                        return;
                    }

                    const room = JSON.parse(this.getAttribute('data-room'));
                    console.log(room);

                    // Update modal information
                    document.getElementById('modalName').innerText = room.name;
                    document.getElementById('modalCapacity').innerText = `${room.capacity} người`;
                    document.getElementById('modalDescription').innerHTML = room.description || '';
                    document.getElementById('modalRoomType').innerText = room.room_type ? room.room_type.name :
                        'N/A';
                    document.getElementById('modalPriceBase').innerText = `${room.price} VND`;
                    document.getElementById('modalPriceSales').innerText =
                        `${room.price * (1 - room.discount_percent / 100)} VND`;
                    document.getElementById('modalDiscountPercent').innerText = `${room.discount_percent}%`;
                    // Edit Room Button Event
                    document.getElementById('editRoomButton').addEventListener('click', function() {
                        window.location.href = `{{ url('admin/room/edit') }}/${room.room_id}`;
                    });
                    // Update amenities
                    const amenitiesContainer = document.getElementById('modalAmenities');
                    amenitiesContainer.innerHTML = room.amenities.map(amenity =>
                        `<span class="amenity-tag">${amenity.amenity_name}</span>`).join(',');

                    // Update image slider
                    const imagesContainer = document.getElementById('modalImages');
                    imagesContainer.innerHTML = '';
                    
                    const imagePromises = room.room_images.map(image => {
                        return new Promise((resolve) => {
                            const imgUrl = `/images/${image.image_url}`;
                            const storageImgUrl = `/storage/images/${image.image_url}`;
                            const slideDiv = document.createElement('div');
                            slideDiv.className = 'swiper-slide';
                            const imgElement = document.createElement('img');

                            checkImageExists(imgUrl, exists => {
                                imgElement.src = exists ? imgUrl : storageImgUrl;
                                imgElement.style.width =
                                    '100%'; // Adjust width as necessary
                                slideDiv.appendChild(imgElement);
                                imagesContainer.appendChild(slideDiv);
                                resolve();
                            });
                        });
                    });

                    // Wait for all images to load before initializing Swiper
                    Promise.all(imagePromises).then(() => {
                        // Initialize Swiper for modal
                        new Swiper(imagesContainer.closest('.swiper'), {
                            slidesPerView: 1,
                            spaceBetween: 10,
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                        });
                    });

                    // Update delete form action
                    document.getElementById('deleteRoomForm').action =
                        `{{ url('admin/room') }}/${room.room_id}`;

                    // Show modal
                    const roomModal = new bootstrap.Modal(document.getElementById('roomModal'));
                    roomModal.show();
                });
            });

            // Check if image exists
            function checkImageExists(url, callback) {
                const img = new Image();
                img.src = url;
                img.onload = () => callback(true);
                img.onerror = () => callback(false);
            }

            // Confirm delete action
            document.getElementById('deleteRoomForm').addEventListener('submit', function(e) {
                if (!confirm("Are you sure you want to delete this room?")) {
                    e.preventDefault();
                } else {
                    setTimeout(() => {
                        const successMessage = document.getElementById('successMessage');
                        successMessage.classList.remove('d-none');
                        setTimeout(() => successMessage.classList.add('d-none'), 3000);
                    }, 100);
                }
            });

            // Initialize existing Swipers
            document.querySelectorAll('.room-swiper').forEach(element => {
                new Swiper(element, {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            });
        </script>

    @endsection
