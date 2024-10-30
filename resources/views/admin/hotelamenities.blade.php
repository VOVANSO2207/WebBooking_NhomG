@extends('admin.layouts.master')

@php
    use App\Helpers\IdEncoder;
@endphp

@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4"><i class="bx bx-menu bx-sm"></i></a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <form action="{{ route('admin.amenities.search') }}" method="GET" class="d-flex align-items-center" style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="search" class="form-control border-0 shadow-none" placeholder="Search amenities..."
                    aria-label="Search amenities..." style="width: 100%;" />
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; color: #fff;">AMENITIES</h5>
            <div class="add">
                <a class="btn btn-success" href="{{ route('amenity_add') }}">Add Amenity</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Amenity Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($amenities as $index => $amenity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $amenity->amenity_name }}</td>
                                <td>{{ Str::limit($amenity->description, 50, '...') }}</td>
                                <td>
                                    <a href="{{ route('amenity.edit', ['amenity_id' => IdEncoder::encodeId($amenity->amenity_id)]) }}" class="btn btn-info">Edit</a>
                                    <button class="btn btn-danger delete-amenity" data-id="{{ IdEncoder::encodeId($amenity->amenity_id) }}">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No amenities available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $amenities->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="confirmDeleteAmenityModal" tabindex="-1" aria-labelledby="confirmDeleteAmenityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteAmenityModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this amenity?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAmenityButton">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentAmenityId = null;

        document.querySelectorAll('.delete-amenity').forEach(button => {
            button.addEventListener('click', function () {
                currentAmenityId = this.getAttribute('data-id');
                const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteAmenityModal'));
                deleteModal.show();
            });
        });

        document.getElementById('confirmDeleteAmenityButton').addEventListener('click', function () {
            fetch(`/amenities/${currentAmenityId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    console.error('Error deleting amenity:', response.statusText);
                }
            })
            .catch(error => console.error('Error deleting amenity:', error));
        });
    });
</script>
@endsection
