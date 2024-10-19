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
@endsection