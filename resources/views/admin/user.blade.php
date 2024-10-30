@extends('admin.layouts.master')
@php
    use App\Helpers\IdEncoder;
@endphp
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
            <form action="{{ route('admin.users.search') }}" method="GET" class="d-flex align-items-center"
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
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">USER</h5>
            <div class="add">
                <a class="btn btn-success" href="{{ route('user_add') }}">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($results ?? $users as $index => $user)
                            <tr class="user-detail" data-id="{{ IdEncoder::encodeId($user->user_id) }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/images/admin/' . $user->avatar) }}" alt="{{ $user->username }}" 
                                    style="width: 100px; height: auto;">
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->role->role_name ?? 'N/A' }}</td>
                                <td class="{{ $user->status ? 'badge bg-success' : 'badge bg-danger' }}">
                                    {{  $user->status ? 'Active' : 'Inactive' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có người dùng nào để hiển thị.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-user">
                {{ (isset($results) ? $results : $users)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal chi tiết người dùng -->
<div class="modal fade" id="userDetailModal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailModalLabel">User Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="user-detail">
                    <div class="user-detail-item">
                        <strong>Username:</strong>
                        <span id="modalUsername"></span>
                    </div>
                    <div class="user-detail-item">
                        <strong>Email:</strong>
                        <span id="modalEmail"></span>
                    </div>
                    <div class="user-detail-item">
                        <strong>Phone Number:</strong>
                        <span id="modalPhoneNumber"></span>
                    </div>
                    <div class="user-detail-item">
                        <strong>Role Name:</strong>
                        <span id="modalRoleId"></span>
                    </div>
                    <div class="user-detail-item">
                        <strong>Status:</strong>
                        <span id="modalStatus"></span>
                    </div>
                    <div class="user-detail-item">
                        <strong>Avatar:</strong>
                        <img id="modalAvatar" style="width: 100%; height: auto; max-width: 200px;" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <a id="editUserButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteUserButton" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteUserModal">Delete</button>
            </div>
            <div class="modal-footer" style="width: 100%; position: relative; bottom: 0;">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteUserModal" tabindex="-1" aria-labelledby="confirmDeleteUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteUserModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa người dùng này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteUserButton">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userDetailRows = document.querySelectorAll('.user-detail');
        let currentUserId = null; // Lưu ID người dùng hiện tại

        // Khi người dùng nhấn vào một người dùng
        userDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentUserId = this.getAttribute('data-id'); // Lưu ID người dùng hiện tại
                console.log(`/users/${currentUserId}/detail`);

                // Gọi AJAX để lấy thông tin chi tiết người dùng
                fetch(`/users/${currentUserId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(user => {
                        // Cập nhật nội dung modal
                        document.getElementById('modalUsername').innerText = user.username;
                        document.getElementById('modalEmail').innerText = user.email;
                        document.getElementById('modalPhoneNumber').innerText = user.phone_number;
                        document.getElementById('modalRoleId').innerText = user.role_id;
                        document.getElementById('modalStatus').innerText = user.status ? 'Active' : 'Inactive';
                        const avatarUrl = user.avatar ? `/storage/images/admin/${user.avatar}` : '/path/to/default/avatar.jpg';
                        document.getElementById('modalAvatar').src = avatarUrl;

                        // Thiết lập đường dẫn cho nút Edit
                        const editRoute = "{{ route('user.edit', ['user_id' => ':id']) }}".replace(':id', currentUserId);
                        document.getElementById('editUserButton').setAttribute('href', editRoute);

                        // Hiển thị modal
                        new bootstrap.Modal(document.getElementById('userDetailModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching user details:', error);
                    });
            });
        });

        // Xử lý sự kiện nhấn nút Delete trong modal
        document.getElementById('deleteUserButton').addEventListener('click', function () {
            new bootstrap.Modal(document.getElementById('confirmDeleteUserModal')).show();
        });

        // Xác nhận xóa người dùng
        document.getElementById('confirmDeleteUserButton').addEventListener('click', function () {
            fetch(`/users/${currentUserId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Thêm CSRF token
                },
            })
                .then(response => {
                    if (response.ok) {
                        // Xóa người dùng khỏi bảng
                        const rowToDelete = document.querySelector(`.user-detail[data-id="${currentUserId}"]`);
                        rowToDelete.remove();
                        new bootstrap.Modal(document.getElementById('confirmDeleteUserModal')).hide();
                        alert('User deleted successfully.');
                    } else {
                        throw new Error('Failed to delete user.');
                    }
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                    alert('An error occurred while deleting the user.');
                });
        });
    });
</script>
@endsection