@extends('admin.layouts.master')

@section('admin-container')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <hr class="my-0" />
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <!-- @if($user && $user->avatar)
                                    <img src="{{ asset('storage/images/' . $user->avatar) }}" alt="{{ $user->username }}"
                                        height="100" width="100" id="fileUpload" />
                                @else
                                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" height="100"
                                        width="100" id="fileUpload" />
                                @endif -->
                                <img src="{{ asset('storage/images/default-avatar.png') }}" alt="Default Avatar"
                                    height="100" width="100" id="fileUpload" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="avatar" class="account-file-input" hidden
                                            accept="image/png, image/jpeg, image/jpg" />
                                    </label>
                                </div>
                            </div>
                            @error('avatar')
                            <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <!-- Các trường nhập liệu cho thông tin người dùng -->
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Username</label>
                                <input class="form-control" type="text" name="username" id="username"
                                    placeholder="Username" />
                                @error('username')
                                <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email" />
                                @error('email')
                                <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Password</label>
                                <input class="form-control" type="password" name="password" id="password"
                                    placeholder="Password" />
                                @error('password')
                                <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input class="form-control" type="text" name="phone_number" id="phone_number"
                                    placeholder="Phone Number" />
                                @error('phone_number')
                                <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Role</label>
                                <select id="role_id" name="role_id" class="form-select">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">Reset</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='{{ route('admin.viewuser') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        $('#userForm')[0].reset();
        $("#fileUpload").attr("src", "{{ asset('storage/images/default-avatar.png') }}");
    }

    $('#upload').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#fileUpload").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection