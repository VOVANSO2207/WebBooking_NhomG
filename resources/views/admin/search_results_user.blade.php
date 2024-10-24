@extends('admin.layouts.master')

@section('admin-container')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">Kết Quả Tìm
                Kiếm Người Dùng</h5>
            <div class="table-responsive text-nowrap">
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
                    <tbody class="table-border-bottom-0">
                        @if ($results->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">Không có người dùng nào được tìm thấy.</td>
                            </tr>
                        @else
                            @foreach ($results as $index => $user)
                                <tr class="user-detail" data-id="{{ $user->user_id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $user->avatar) }}" alt="{{ $user->username }}"
                                            style="width: 100px; height: auto;">
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->role_id }}</td>
                                    <td class="{{ $user->status ? 'badge bg-success' : 'badge bg-danger' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-user">
                {{ $results->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userDetailRows = document.querySelectorAll('.user-detail');

        userDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                fetch(`/users/${userId}/detail`)
                    .then(response => response.json())
                    .then(user => {
                        // Cập nhật nội dung modal
                        document.getElementById('modalUsername').innerText = user.username;
                        document.getElementById('modalEmail').innerText = user.email;
                        document.getElementById('modalPhoneNumber').innerText = user.phone_number;
                        document.getElementById('modalRoleId').innerText = user.role_id;
                        document.getElementById('modalStatus').innerText = user.status ? 'Active' : 'Inactive';
                        const avatarUrl = user.avatar ? `/images/${user.avatar}` : '/path/to/default/avatar.jpg';
                        document.getElementById('modalAvatar').src = avatarUrl;

                        // Hiển thị modal
                        new bootstrap.Modal(document.getElementById('userDetailModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching user details:', error);
                    });
            });
        });
    });
</script>
@endsection