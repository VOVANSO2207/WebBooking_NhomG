@extends('admin.layouts.master')
@section('admin-container')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST" action="{{ route('room_store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Room Name" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Room Type</label>
                                    <select name="room_type_id" class="form-select" required>
                                        @foreach ($roomTypes as $roomType)
                                            <option value="{{ $roomType->room_type_id }}">{{ $roomType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Price Base</label>
                                    <input class="form-control" type="text" name="price" placeholder="Price Base" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Price Sales</label>
                                    <input class="form-control" type="text" name="sales_price" placeholder="Price Sales" />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Capacity</label>
                                    <input class="form-control" type="text" name="capacity" placeholder="Capacity" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Discount Percent</label>
                                    <input class="form-control" type="text" name="discount_percent" placeholder="Discount Percent" required />
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Upload Images</label>
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ asset('/images/img-upload.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="fileUpload" />
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Upload</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="upload" name="images[]" multiple class="account-file-input" hidden accept="image/png, image/jpeg, image/jpg" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Room Amenities</label>
                                    <select name="amenities[]" class="form-select select2" multiple="multiple" required>
                                        @foreach ($amenities as $amenity)
                                            <option value="{{ $amenity->amenity_name }}">{{ $amenity->amenity_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="description" required></textarea>
                                </div>
                            </div>
                            <div class="mt-2" style="text-align: right">
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('admin.viewroom') }}'">Close</button>
                                <button type="submit" class="btn btn-outline-success me-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <script>
        window.onload = function() {
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: "path/to/upload/image"
            });
        };
    </script>
@endsection
