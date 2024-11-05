@extends('admin.layouts.master')

@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="amenityForm" action="{{ route('admin.hotel_amenities.update', $amenity->amenity_id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label">Amenity Name</label>
                                <input class="form-control" type="text" name="amenity_name" id="amenity_name"
                                    value="{{ old('amenity_name', $amenity->amenity_name) }}" placeholder="Amenity Name" />
                                @error('amenity_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"
                                    placeholder="Description">{{ old('description', $amenity->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='{{ route('admin.hotel_amenities.index') }}'">Quay Lại</button>
                            <button type="submit" class="btn btn-outline-success me-2">Lưu</button>
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

@endsection
