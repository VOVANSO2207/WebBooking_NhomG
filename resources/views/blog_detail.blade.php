@extends('layouts.app')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="{{asset('css/blog.css')}}">
<!--  -->
@section('header')
@include('partials.header') 
@endsection
<!--  -->

@section('content')
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Bên Trái: Nội dung bài viết -->
            <div class="col-md-8">
                <h1 class="post-title">{{ $post->title }}</h1>
                <div class="content">
                    {!! $post->description !!} <!-- Hiển thị nội dung bài viết -->
                </div>
                <div class="content">
                    {!! $post->content !!} <!-- Hiển thị nội dung bài viết -->
                </div>
                <p class="text-muted">Ngày đăng: {{ $post->created_at ?? 'N/A' }}</p> <!-- Ngày đăng -->
                <!-- Thêm các nút chia sẻ Facebook và Gmail -->
                    <div class="share-buttons">
                        <h3>Chia sẻ bài viết:</h3>
                        
                        <!-- Nút chia sẻ lên Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->full()) }}" 
                        target="_blank" class="btn btn-primary">
                        <i class="fab fa-facebook"></i> Chia sẻ Facebook
                        </a>

                        <!-- Nút chia sẻ qua Gmail -->
                        <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(Request::url()) }}" 
                        target="_blank" class="btn btn-danger">
                        <i class="fas fa-envelope"></i> Chia sẻ Gmail
                        </a>
                    </div>

            </div>
            
            <!-- Bên Phải: Bài viết liên quan -->
            <div class="col-md-4">
                <h2>Bài viết liên quan</h2>
                <div class="related-posts">
                    <ul class="list-unstyled">
                        @foreach($relatedPosts as $relatedPost)
                            <li class="related-post">
                                <a href="{{ url('blog/' . $relatedPost->url_seo) }}">
                                    <img src="{{ asset('storage/images/' . $relatedPost->img) }}" alt="{{ $relatedPost->title }}" class="img-fluid" style="width:100%; height: 200px;">
                                    <h4>{{ Str::limit($relatedPost->title, 20) }}</h4>
                                    <p class="text-muted">Ngày đăng: {{ $relatedPost->created_at ?? 'N/A' }}</p> <!-- Ngày đăng -->
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
@endsection
@section('footer')
@include('partials.footer') 
@endsection