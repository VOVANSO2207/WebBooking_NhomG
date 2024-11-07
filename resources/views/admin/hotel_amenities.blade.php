@extends('admin.layouts.master') 
@php
    use App\Helpers\IdEncoder;
@endphp
@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <form action="{{ route('hotel_amenities.search') }}" method="GET" class="d-flex align-items-center" style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." style="width: 100%;" />
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">HOTEL AMENITIES</h5>
            <div class="add">
                <a class="btn btn-success" href="{{ route('admin.hotel_amenities.add') }}">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Amenity Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($results ?? $amenities as $index => $amenity)
                            <tr class="amenity-detail" data-id="{{ IdEncoder::encodeId($amenity->amenity_id) }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $amenity->amenity_name }}</td>
                                <td>{{ $amenity->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No amenities available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-amenities">
                {{ (isset($results) ? $results : $amenities)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Amenity Detail Modal -->
<div class="modal fade" id="amenityDetailModal" tabindex="-1" aria-labelledby="amenityDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="amenityDetailModalLabel">Amenity Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="room-info-grid mt-3">
                    <div class="info-card">
                        <div class="info-label">Amenity Name:</div>
                        <div class="info-value" id="modalAmenityName"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Description:</div>
                        <div class="info-value" id="modalDescription"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <a id="editAmenityButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteAmenityButton">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const amenityDetailRows = document.querySelectorAll('.amenity-detail');
    let currentAmenityId = null;

    amenityDetailRows.forEach(row => {
        row.addEventListener('click', function () {
            currentAmenityId = this.getAttribute('data-id');

            // Ghi lại ID tiện ích hiện tại vào console
            console.log('Current Amenity ID:', currentAmenityId);

            // Fetch amenity details
            fetch(`/hotel_amenities/${currentAmenityId}/detail`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(amenity => {
                    document.getElementById('modalAmenityName').innerText = amenity.amenity_name;
                    document.getElementById('modalDescription').innerText = amenity.description;

                    const editRoute = "{{ route('admin.hotel_amenities.edit', ['id' => ':id']) }}".replace(':id', currentAmenityId);
                    document.getElementById('editAmenityButton').setAttribute('href', editRoute);

                    const modal = new bootstrap.Modal(document.getElementById('amenityDetailModal'));
                    modal.show();
                })
                .catch(error => console.error('Error fetching amenity details:', error));
        });
    });

    // Xử lý sự kiện nhấn nút Delete trong modal chi tiết
    document.getElementById('deleteAmenityButton').addEventListener('click', function () {
        if (currentAmenityId) {
            // Thực hiện xóa tiện ích mà không có thông báo xác nhận
            fetch(`/admin/hotel_amenities/${currentAmenityId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Thêm CSRF token
                },
            })
            .then(response => {
                if (response.ok) {
                    // Xóa tiện ích khỏi bảng
                    const rowToDelete = document.querySelector(`.amenity-detail[data-id="${currentAmenityId}"]`);
                    if (rowToDelete) {
                        rowToDelete.remove();
                    } else {
                        console.error('Row not found for deletion');
                    }
                    // Đóng modal và tải lại trang
                    new bootstrap.Modal(document.getElementById('amenityDetailModal')).hide();
                    location.reload(); // Tải lại trang
                } else {
                    throw new Error('Failed to delete Amenity.');
                }
            })
            .catch(error => {
                console.error('Error deleting Amenity:', error);
                alert('An error occurred while deleting the amenity.');
            });
        }
    });

    // Lắng nghe sự kiện đóng modal
    document.getElementById('amenityDetailModal').addEventListener('hidden.bs.modal', function () {
        // Tự động reload lại trang khi modal đóng
        location.reload();
    });
});
</script>
@endsection
