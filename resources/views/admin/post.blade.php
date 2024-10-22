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
            <div class="nav-item d-flex align-items-center" style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" id="search_post" name="search_post"
                    placeholder="Search..." aria-label="Search..." style="width: 100%;" />
            </div>
        </div>

    </div>
</nav>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">BLOG</h5>
            <div class="add">
                <a class="btn btn-success" href="{{ route('post_add') }}">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Content</th>
                            <th>Meta_desc</th>
                            <th>Url_seo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @forelse ($posts as $index => $post)
                        
                            <tr class="post-detail" data-id="{{ IdEncoder::encodeId($post->post_id) }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('images/' . $post->img) }}" alt="{{ $post->title }}"
                                        style="width: 100px; height: auto;">
                                </td>
                                <td>{{ Str::limit($post->title, 10) }}</td>
                                <td>{{ Str::limit($post->description, 10) }}</td>
                                <td>{{ Str::limit($post->content, 10) }}</td>
                                <td>{{ Str::limit($post->meta_desc, 10) }}</td>
                                <td>{{ $post->url_seo }}</td>
                                <td class="{{ $post->status ? 'badge bg-success' : 'badge bg-danger' }}">
                                    {{ $post->status ? 'Show' : 'Hidden' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có bài viết nào để hiển thị.</td>
                            </tr>
                        @endforelse

                    </tbody>
                    <tbody id="Content" class="searchdata">

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-post">
                {{ $posts->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal chi tiết bài viết -->
<div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="postDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postDetailModalLabel">Post Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="post-detail">
                    <div class="post-detail-item">
                        <strong>Title:</strong>
                        <span id="modalTitle"></span>
                    </div>
                    <div class="post-detail-item">
                        <strong>Description:</strong>
                        <span id="modalDescription"></span>
                    </div>
                    <div class="post-detail-item">
                        <strong>Content:</strong>
                        <span id="modalContent"></span>
                    </div>
                    <div class="post-detail-item">
                        <strong>Meta Description:</strong>
                        <span id="modalMetaDesc"></span>
                    </div>
                    <div class="post-detail-item">
                        <strong>URL SEO:</strong>
                        <span id="modalUrlSeo"></span>
                    </div>
                    <div class="post-detail-item">
                        <strong>Status:</strong>
                        <span id="modalStatus"></span>
                    </div>
                    <div class="post-detail-item">
                        <strong>Image:</strong>
                        <img id="modalImage" style="width: 100%; height: auto; max-width: 200px;" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <a id="editPostButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deletePostButton" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal">Delete</button>
            </div>
            <div class="modal-footer" style="width: 100%; position: relative; bottom: 0;">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa bài viết này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">OK</button>
            </div>
        </div>
    </div>
</div>

<script>


    document.addEventListener('DOMContentLoaded', function () {
        const postDetailRows = document.querySelectorAll('.post-detail');
        let currentPostId = null; // Lưu ID bài viết hiện tại

        // Khi người dùng nhấn vào một bài viết
        postDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentPostId = this.getAttribute('data-id'); // Lưu ID bài viết hiện tại
                console.log(`/posts/${currentPostId}/detail`);

                // Gọi AJAX để lấy thông tin chi tiết bài viết
                fetch(`/posts/${currentPostId}/detail`)
                    .then(response => response.json())
                    .then(post => {
                        const limitText = (text, maxLength = 10) => {
                            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                        };

                        // Cập nhật nội dung modal
                        document.getElementById('modalTitle').innerText = limitText(post.title);
                        document.getElementById('modalDescription').innerText = limitText(post.description);
                        document.getElementById('modalContent').innerText = limitText(post.content);
                        document.getElementById('modalMetaDesc').innerText = limitText(post.meta_desc);
                        document.getElementById('modalUrlSeo').innerText = limitText(post.url_seo);
                        document.getElementById('modalStatus').innerText = post.status ? 'Show' : 'Hidden';
                        const imageUrl = post.img ? `/images/${post.img}` : '/path/to/default/image.jpg';
                        document.getElementById('modalImage').src = imageUrl;

                        // Thiết lập đường dẫn cho nút Edit
                        const editRoute = "{{ route('post.edit', ['post_id' => ':id']) }}".replace(':id', currentPostId);
                        document.getElementById('editPostButton').setAttribute('href', editRoute);

                        // Hiển thị modal
                        const modal = new bootstrap.Modal(document.getElementById('postDetailModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Có vấn đề với yêu cầu fetch:', error);
                    });
            });
        });

        // Đường dẫn đến route xóa bài viết

        // Khi người dùng nhấn nút "Delete"
        document.getElementById('deletePostButton').addEventListener('click', function () {
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            confirmDeleteModal.show();
        });

        // Khi người dùng nhấn nút "OK" trong modal xác nhận
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (currentPostId) {
                // Sử dụng tên route để tạo URL
                const deleteRoute = "{{ route('post.delete', ['post_id' => ':id']) }}".replace(':id', currentPostId);


                fetch(deleteRoute, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            alert("Xoá Bài Viết Thành Công");
                            location.reload(); // Tải lại trang sau khi xóa thành công
                        } else {
                            console.error('Có lỗi xảy ra khi xóa bài viết');
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            }
        });
    });
    // Lắng nghe sự kiện khi modal đã hoàn toàn đóng
    document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function () {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove(); // Loại bỏ lớp mờ
        }
    });

    // Đảm bảo nút Cancel đóng modal
    document.getElementById('cancelButton').addEventListener('click', function () {
        const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmDeleteModal.hide(); // Ẩn modal
    });







</script>

@endsection