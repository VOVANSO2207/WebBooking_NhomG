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
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">HOTELS</h5>
            <div class="add">
                <a class="btn btn-success" href="{{ route('hotel_add') }}">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>City</th>
                            <th>Description</th>
                            <th>Rating</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($results ?? $hotels as $index => $hotel)
                            <tr class="hotel-detail" data-id="{{ $hotel->hotel_id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('images/' . $hotel->avatar) }}" alt="{{ $hotel->hotel_name }}"
                                        style="width: 100px; height: auto;">
                                </td>
                                <td>{{ $hotel->hotel_name }}</td>
                                <td>{{ $hotel->location }}</td>
                                <td>{{ $hotel->city_id }}</td>
                                <td>{{ $hotel->description }}</td>
                                <td>{{ $hotel->rating }}</td>
                                <td class="{{ $hotel->status ? 'badge bg-success' : 'badge bg-danger' }}">
                                    {{  $hotel->status ? 'Active' : 'Inactive' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có khách sạn nào để hiển thị.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-hotel">
                {{ (isset($results) ? $results : $hotels)->links('pagination::bootstrap-4') }}
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
                <div class="hotel-detail">
                    <div class="hotel-detail-item">
                        <strong>Name:</strong>
                        <span id="modalHotelName"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>Location:</strong>
                        <span id="modalHotelLocation"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>City:</strong>
                        <span id="modalHotelCity"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>Description:</strong>
                        <span id="modalHotelDescription"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>Rating:</strong>
                        <span id="modalHotelRating"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>Phone Number:</strong>
                        <span id="modalHotelPhoneNumber"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>Status:</strong>
                        <span id="modalHotelStatus"></span>
                    </div>
                    <div class="hotel-detail-item">
                        <strong>Avatar:</strong>
                        <img id="modalHotelAvatar" style="width: 100%; height: auto; max-width: 200px;" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <a id="editHotelButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteHotelButton" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteHotelModal">Delete</button>
            </div>
            <div class="modal-footer" style="width: 100%; position: relative; bottom: 0;">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteHotelModal" tabindex="-1" aria-labelledby="confirmDeleteHotelModalLabel"
    aria-hidden="true">
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
        let currentHotelId = null; // Lưu ID khách sạn hiện tại

        // Khi người dùng nhấn vào một khách sạn
        hotelDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentHotelId = this.getAttribute('data-id'); // Lưu ID khách sạn hiện tại

                // Gọi AJAX để lấy thông tin chi tiết khách sạn
                fetch(`/hotels/${currentHotelId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(hotel => {
                        // Cập nhật nội dung modal
                        document.getElementById('modalHotelName').innerText = hotel.hotel_name;
                        document.getElementById('modalHotelLocation').innerText = hotel.location;
                        document.getElementById('modalHotelCity').innerText = hotel.city_id; // Thêm city_id
                        document.getElementById('modalHotelDescription').innerText = hotel.description; // Thêm description
                        document.getElementById('modalHotelRating').innerText = hotel.rating; // Thêm rating
                        document.getElementById('modalHotelPhoneNumber').innerText = hotel.phone_number;
                        document.getElementById('modalHotelStatus').innerText = hotel.status ? 'Active' : 'Inactive';
                        const avatarUrl = hotel.avatar ? `/images/${hotel.avatar}` : '/path/to/default/avatar.jpg';
                        document.getElementById('modalHotelAvatar').src = avatarUrl;

                        // Thiết lập đường dẫn cho nút Edit
                        const editRoute = "{{ route('hotel.edit', ['hotel_id' => ':hotel_id']) }}";
                        document.getElementById('editHotelButton').setAttribute('href', editRoute.replace(':hotel_id', currentHotelId));
                        
                        // Hiện modal
                        const hotelDetailModal = new bootstrap.Modal(document.getElementById('hotelDetailModal'));
                        hotelDetailModal.show();
                    })
                    .catch(error => console.error('Error fetching hotel details:', error));
            });
        });

        // Xử lý nút xác nhận xóa
        document.getElementById('confirmDeleteHotelButton').addEventListener('click', function () {
            fetch(`/hotels/${currentHotelId}/delete`, { method: 'DELETE' })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Refresh the page or remove the row
                    location.reload();
                })
                .catch(error => console.error('Error deleting hotel:', error));
        });
    });
</script>
@endsection
