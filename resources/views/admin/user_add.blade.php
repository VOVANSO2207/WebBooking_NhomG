@extends('admin.layouts.master')
@section('admin-container')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <!-- Account -->
                <hr class="my-0"/>
                <div class="card-body">
                    <form id="formAccountSettings" method="GET" onsubmit="return false" enctype="multipart/form-data">
                        <div class="row">
                                <div class="mb-3 col-md-7">
                                <label class="form-label">Username</label>
                                <input class="form-control" type="text" name="username" id="username" placeholder="username" required/>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Role</label>
                                <select id="role" class="select2 form-select">
                                    <option value="admin" selected>Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-7">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="text" id="email" name="email" placeholder="Email" autofocus required/>
                            </div>
                            <div class="mb-3 col-md-7">
                                <label class="form-label">Password</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password" autofocus required/>
                            </div>
                            <div class="mb-3 col-md-7">
                                <label class="form-label">Phonenumber</label>
                                <input class="form-control" type="text" id="phonenumber" name="phonenumber" placeholder="Phonenumber" autofocus required/>
                            </div>
                            <div class="mb-3 col-md-7">
                                <label class="form-label">Address</label>
                                <input class="form-control" type="text" id="address" name="address" placeholder="Address" autofocus required/>
                            </div>
                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('admin.viewuser') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2 add_post">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

@endsection

