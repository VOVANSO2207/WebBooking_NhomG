@extends('admin.layouts.master')

@section('admin-container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h3
                    style="
            text-align: center; 
            font-size: 40px; 
            font-weight: bold; 
            color: #4CAF50; 
            margin: 20px 0; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            border-bottom: 2px solid #4CAF50; 
            padding-bottom: 10px; 
            font-family: 'Arial', sans-serif;">
                    EDIT ROOM AMENITIES 
                </h3>
                <div class="card mb-4">
                    <hr class="my-0" />
                    <div class="card-body">
                        <form method="post" id="roomAmenitiesForm"
                            action="{{ route('admin.room_amenities.update', $roomAmenities->amenity_id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Đảm bảo bạn sử dụng PUT để cập nhật -->
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Name Room Amenities</label>
                                    <input class="form-control" type="text" name="amenity_name" id="nameRoomAmenities"
                                        value="{{ old('amenity_name', $roomAmenities->amenity_name) }}" />
                                    @error('amenity_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="descriptionRoomType" rows="3"> {{ old('description', $roomAmenities->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2" style="text-align: right">
                                <button type="reset" class="btn btn-outline-secondary"
                                    onclick="resetForm()">Reset</button>
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="window.location.href='{{ route('admin.viewroomamenities') }}'">Close</button>
                                <button type="submit" class="btn btn-outline-success me-2">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Thông báo Thành công -->
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

    <!-- Toast Thông báo Không có thay đổi -->
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
 
@endsection
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
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

    });
</script>
