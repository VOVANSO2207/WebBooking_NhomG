@extends('admin.layouts.master')

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
                            <tr class="hotel-detail" data-id="{{ $hotel->hotel_id }}">
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
                                                            <img src="{{ asset('storage/images/' . $image->image_url) }}" alt="Room Image">
                                                        @else
                                                            <img src="{{ asset('images/img-upload.jpg') }}" alt="Default Image">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- Thêm điều hướng -->
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
                                <td colspan="5" class="text-center">Không có khách sạn nào để hiển thị.</td>
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
            </div>
            <div class="modal-footer">
                <a id="editHotelButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteHotelButton" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteHotelModal">Delete</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteHotelModal" tabindex="-1" aria-labelledby="confirmDeleteHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteHotelModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa khách sạn này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteHotelButton">OK</button>
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Thêm CSRF token nếu cần
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload(); // Tải lại trang nếu xóa thành công
                } else {
                    console.error('Error deleting hotel:', response.statusText);
                }
            })
            .catch(error => console.error('Error deleting hotel:', error));
        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo Swiper cho tất cả các swiper
        const swiperContainers = document.querySelectorAll('.room-swiper');

        swiperContainers.forEach(container => {
            const swiper = new Swiper(container, {
                navigation: {
                    nextEl: container.querySelector('.swiper-button-next'),
                    prevEl: container.querySelector('.swiper-button-prev'),
                },
                loop: false, // Đảm bảo không lặp lại
            });

            // Ngăn chặn click vào nút điều hướng mở modal
            container.querySelector('.swiper-button-next').addEventListener('click', function (event) {
                event.stopPropagation(); // Ngăn chặn sự kiện click bùng phát
            });

            container.querySelector('.swiper-button-prev').addEventListener('click', function (event) {
                event.stopPropagation(); // Ngăn chặn sự kiện click bùng phát
            });
        });
    });
</script>
@endsection
