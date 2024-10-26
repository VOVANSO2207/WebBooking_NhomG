@extends('admin.layouts.master') 
@section('admin-container')

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    <form method="POST" id="hotelForm" action="{{ route('admin.hotel.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ asset('images/default_hotel.jpg') }}" alt="hotel-image"
                                    class="d-block rounded" height="100" width="100" id="fileUpload" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="image" class="account-file-input" hidden
                                            accept="image/png, image/jpeg, image/jpg" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Hotel ID</label>
                                <input class="form-control" type="text" name="hotel_id" id="hotel_id"
                                    value="{{ old('hotel_id') }}" placeholder="Hotel ID" required />
                                @error('hotel_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Hotel Name</label>
                                <input class="form-control" type="text" name="hotel_name" id="hotel_name"
                                    value="{{ old('hotel_name') }}" placeholder="Hotel Name" required />
                                @error('hotel_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Location</label>
                                <input class="form-control" type="text" name="location" id="location"
                                    value="{{ old('location') }}" placeholder="Location" required />
                                @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">City ID</label>
                                <input class="form-control" type="text" name="city_id" id="city_id"
                                    value="{{ old('city_id') }}" placeholder="City ID" required />
                                @error('city_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Description" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Rating</label>
                                <input class="form-control" type="number" name="rating" id="rating" min="1" max="5"
                                    value="{{ old('rating') }}" placeholder="Rating" required />
                                @error('rating')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
@endsection
