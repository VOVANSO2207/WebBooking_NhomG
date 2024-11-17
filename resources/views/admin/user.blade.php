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
        <!-- Success/Failure Messages -->
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

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
                                    <img src="{{ asset('images/' . $user->avatar) }}" alt="{{ $user->username }}" 
                                    style="width: 100px; height: auto;">
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->role->role_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge d-inline" style="{{ $user->status ? 'background-color: green; color: white; padding: 5px;' : 'background-color: red; color: white; padding: 5px;' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
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
                <div class="gallery-section">
                    <strong>Avatar:</strong>
                    <img id="modalAvatar" style="width: 100%; height: auto; max-width: 200px;" alt="">
                </div>

                <div class="room-info-grid mt-3">
                    <div class="info-card">
                        <div class="info-label">Username:</div>
                        <div class="info-value" id="modalUsername"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Email:</div>
                        <div class="info-value" id="modalEmail"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Phone Number:</div>
                        <div class="info-value" id="modalPhoneNumber"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Role Name:</div>
                        <div class="info-value" id="modalRoleId"></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Status:</div>
                        <div class="info-value" id="modalStatus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <a id="editUserButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteUserButton">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userDetailRows = document.querySelectorAll('.user-detail');
        let currentUserId = null;

        // Khi nhấn vào một người dùng
        userDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentUserId = this.getAttribute('data-id');
                
                // Gọi AJAX để lấy chi tiết người dùng
                fetch(`/users/${currentUserId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(user => {
                        // Cập nhật thông tin vào modal
                        document.getElementById('modalUsername').innerText = user.username;
                        document.getElementById('modalEmail').innerText = user.email;
                        document.getElementById('modalPhoneNumber').innerText = user.phone_number;
                        document.getElementById('modalRoleId').innerText = user.role_id;
                        document.getElementById('modalStatus').innerText = user.status ? 'Active' : 'Inactive';
                        const avatarUrl = user.avatar ? `/images/${user.avatar}` : 'default-avatar.png';
                        document.getElementById('modalAvatar').src = avatarUrl;

                        // Đặt link Edit
                        const editRoute = "{{ route('user.edit', ['user_id' => ':id']) }}".replace(':id', currentUserId);
                        document.getElementById('editUserButton').setAttribute('href', editRoute);

                        // Hiển thị modal chi tiết người dùng
                        new bootstrap.Modal(document.getElementById('userDetailModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching user details:', error);
                    });
            });
        });

        // Xử lý xóa người dùng
        deleteUserButton.addEventListener('click', async function () {
            if (!confirm('Bạn có chắc chắn muốn xóa người dùng này?')) return;

            try {
                const response = await fetch(`/users/${currentUserId}/delete`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                });
                // Ẩn dòng dữ liệu ngay lập tức
                document.querySelector(`tr[data-id="${currentUserId}"]`).remove();
                window.location.reload();

            } catch (error) {
                console.error('Error deleting user:', error);
            }
        });
    });
</script>
@endsection
