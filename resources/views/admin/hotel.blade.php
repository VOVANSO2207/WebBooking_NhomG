@extends('admin.layouts.master')
@php
    use App\Helpers\IdEncoder;
@endphp
@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <form action="{{ route('admin.hotels.search') }}" method="GET" class="d-flex align-items-center"
                style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." style="width: 100%;" />
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; color: #fff;">HOTELS</h5>
            <div class="add">
                <a class="btn btn-success" href="{{ route('hotel_add') }}">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>City</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hotels as $index => $hotel)
                            <tr class="hotel-detail" data-id="{{ IdEncoder::encodeId($hotel->hotel_id) }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="swiper room-swiper">
                                        <div class="swiper-wrapper">
                                            @if ($hotel->images->isEmpty())
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('images/img-upload.jpg') }}" alt="Default Image">
                                                </div>
                                            @else
                                                @foreach ($hotel->images as $image)
                                                    <div class="swiper-slide">
                                                        @if (file_exists(public_path('images/' . $image->image_url)))
                                                            <img src="{{ asset('images/' . $image->image_url) }}" alt="Room Image">
                                                        @elseif (file_exists(public_path('storage/images/' . $image->image_url)))
                                                            <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                                                alt="Room Image">
                                                        @else
                                                            <img src="{{ asset('images/img-upload.jpg') }}" alt="Default Image">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </td>
                                <td>{{ $hotel->hotel_name }}</td>
                                <td>{{ $hotel->location }}</td>
                                <td>{{ Str::limit($hotel->description, 50, '...') }}</td>
                                <td>{{ $hotel->city->city_name ?? 'N/A' }}</td>
                                <td>{{ $hotel->rating }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có khách sạn nào để hiển thị.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $hotels->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal chi tiết khách sạn -->
<div class="modal fade" id="hotelDetailModal" tabindex="-1" aria-labelledby="hotelDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hotelDetailModalLabel">Hotel Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div><strong>Name:</strong> <span id="modalHotelName"></span></div>
                <div><strong>Location:</strong> <span id="modalHotelLocation"></span></div>
                <div><strong>City:</strong> <span id="modalHotelCity"></span></div>
                <div><strong>Description:</strong> <span id="modalHotelDescription"></span></div>
                <div><strong>Rating:</strong> <span id="modalHotelRating"></span></div>

                <div class="swiper room-swiper">
                    <div class="swiper-wrapper" id="hotelImages"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div><strong>Amenities:</strong>
                    <ul id="modalHotelAmenities"></ul>
                </div>

                <div><strong>Rooms:</strong>
                    <ul id="modalHotelRooms"></ul>
                </div>
            </div>

            <div class="modal-footer">
                <a id="editHotelButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="confirmDeleteHotelButton">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hotelDetailRows = document.querySelectorAll('.hotel-detail');
        let currentHotelId = null;

        hotelDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentHotelId = this.getAttribute('data-id');

                fetch(`/hotels/${currentHotelId}/detail`)
                    .then(response => response.json())
                    .then(hotel => {
                        document.getElementById('modalHotelName').innerText = hotel.hotel_name;
                        document.getElementById('modalHotelLocation').innerText = hotel.location;
                        document.getElementById('modalHotelCity').innerText = hotel.city_id;
                        document.getElementById('modalHotelDescription').innerText = hotel.description;
                        document.getElementById('modalHotelRating').innerText = hotel.rating;

                        const editRoute = "{{ route('hotel.edit', ['hotel_id' => ':hotel_id']) }}";
                        document.getElementById('editHotelButton').setAttribute('href', editRoute.replace(':hotel_id', currentHotelId));

                        const amenitiesContainer = document.getElementById('modalHotelAmenities');
                        amenitiesContainer.innerHTML = '';
                        hotel.amenities.forEach(amenity => {
                            const listItem = document.createElement('li');
                            listItem.textContent = `${amenity.name}: ${amenity.description}`;
                            amenitiesContainer.appendChild(listItem);
                        });

                        const roomsContainer = document.getElementById('modalHotelRooms');
                        roomsContainer.innerHTML = '';
                        hotel.rooms.forEach(room => {
                            const roomItem = document.createElement('li');
                            roomItem.textContent = `${room.room_name} - Price: ${room.price}`;
                            roomsContainer.appendChild(roomItem);
                        });

                        const imageContainer = document.getElementById('hotelImages');
                        imageContainer.innerHTML = '';
                        hotel.images.forEach(image => {
                            const slide = document.createElement('div');
                            slide.classList.add('swiper-slide');
                            slide.innerHTML = `<img src="${image}" alt="Room Image">`;
                            imageContainer.appendChild(slide);
                        });

                        new Swiper('.room-swiper', {
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            loop: false,
                        });

                        const hotelDetailModal = new bootstrap.Modal(document.getElementById('hotelDetailModal'));
                        hotelDetailModal.show();
                    })
                    .catch(error => console.error('Error fetching hotel details:', error));

            });
        });

        document.getElementById('confirmDeleteHotelButton').addEventListener('click', function () {
            fetch(`/hotels/${currentHotelId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Tải lại trang nếu xóa thành công
                    } else {
                        console.error('Error deleting hotel:', response);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection
