@extends('admin.layouts.master')

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
                <input type="text" class="form-control border-0 shadow-none" id="search_post" placeholder="Search..."
                    aria-label="Search..." style="width: 100%;" />
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
                            <tr class="post-detail" data-id="{{ $post->post_id }}">
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
                                <td>{{ $post->status ? 'Show' : 'Hidden' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có bài viết nào để hiển thị.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $posts->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
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
                <a id="editPostButton" class="btn btn-info" href="#">Edit</a>
                <form id="deleteForm" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-danger" id="deletePostButton">Delete</button>
                </form>
            </div>
            <div class="modal-footer" style="width: 100%; position: relative; bottom: 0;">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // POST.BLADE.PHP - View - Modal Post
    document.addEventListener('DOMContentLoaded', function () {
        const postDetailRows = document.querySelectorAll('.post-detail');

        postDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                const postId = this.getAttribute('data-id');
                console.log(`/posts/${postId}/detail`);

                // Gọi AJAX để lấy thông tin chi tiết bài viết
                fetch(`/posts/${postId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(post => {
                        // Hàm giới hạn ký tự và cập nhật thông tin modal
                        const limitText = (text, maxLength = 10) => {
                            return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                        };

                        document.getElementById('modalTitle').innerText = limitText(post.title);
                        document.getElementById('modalDescription').innerText = limitText(post.description);
                        document.getElementById('modalContent').innerText = limitText(post.content);
                        document.getElementById('modalMetaDesc').innerText = limitText(post.meta_desc);
                        document.getElementById('modalUrlSeo').innerText = limitText(post.url_seo);
                        document.getElementById('modalStatus').innerText = post.status ? 'Show' : 'Hidden';

                        // Cập nhật hình ảnh
                        const imageUrl = post.img ? `/images/${post.img}` : '/path/to/default/image.jpg';
                        document.getElementById('modalImage').src = imageUrl;

                        // Hiển thị modal
                        const modal = new bootstrap.Modal(document.getElementById('postDetailModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Có vấn đề với yêu cầu fetch:', error);
                    });
            });
        });
    });


</script>



@endsection