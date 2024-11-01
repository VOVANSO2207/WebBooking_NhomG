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
    <section class="blog">
        <div class="title-blog">
            <div class="container mt-5">
                Tin Tức
            </div>
        </div>
        <div class="container">
            <div class="row">
            <div class="col-md-4">
                    <div class="search-bar">
                        <h4>Tìm kiếm bài viết</h4>
                        <form id="search-form">
                        @csrf
                            <input type="text" id="search-input" placeholder="Nhập tiêu đề hoặc mô tả...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <div class="error-message" id="error-message"></div>
                    </div>
                    <div class="search-results" id="search-results"></div>
                </div>
                <div class="col-md-8">
                    <h3>Danh sách bài viết</h3>
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-6">
                                <div class="news-item">
                                <a style="text-decoration: none" href="{{ url('blog/' . $post->url_seo) }}">
                                    <img src="{{ asset('images/' . $post->img) }}" alt="Ảnh đại diện bài viết"></a>
                                    <div class="news-content">
                                        <h5><a href="{{ url('blog/' . $post->url_seo) }}">{{ Str::limit($post->title, 25) }}</a></h5>
                                        <p>{{ Str::limit($post->description, 25) }}</p>
                                        <span class="news-date">{{ $post->formattedCreatedAt }}</span>
                                        <a href="{{ url('blog/' . $post->url_seo) }}" class="btn-read-more">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3 pagination-post">
                        {{ $posts->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
               
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.getElementById('search-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Ngăn không cho gửi form

        const query = document.getElementById('search-input').value;
        const errorMessageContainer = document.getElementById('error-message');
        const resultsContainer = document.getElementById('search-results');

        // Xóa nội dung cũ và thông báo lỗi
        resultsContainer.innerHTML = '';
        errorMessageContainer.textContent = '';

        // Kiểm tra ràng buộc
        if (!query) {
            errorMessageContainer.textContent = 'Vui lòng nhập từ khóa để tìm kiếm';
            return;
        }

        if (/[@#$%^&*]/.test(query)) {
            errorMessageContainer.textContent = 'Từ khóa tìm kiếm không chứa ký tự đặc biệt, vui lòng nhập lại';
            return;
        }

        if (query.length < 5) {
            errorMessageContainer.textContent = 'Từ khóa tìm kiếm quá ngắn, vui lòng nhập ít nhất 5 ký tự';
            return;
        }

        if (query.length > 100) {
            errorMessageContainer.textContent = 'Từ khóa tìm kiếm quá dài, vui lòng nhập dưới 100 ký tự';
            return;
        }

        const newUrl = `?query=${encodeURIComponent(query)}`;
        history.pushState({ search: query }, '', newUrl);
        fetch(`/search1?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(posts => {
                if (posts.length === 0) {
                    errorMessageContainer.textContent = 'Không tìm thấy kết quả nào phù hợp với từ khóa của bạn';
                } else {
                    // Hiển thị kết quả tìm kiếm
                    posts.forEach(post => {
                        const resultItem = document.createElement('div');
                        resultItem.classList.add('news-item');
                        resultItem.innerHTML = `
                        <img src="{{ asset('images/${post.img}') }}" alt="Ảnh đại diện bài viết">
                            <div class="news-content">
                                <h5>${post.title}</h5>
                                <p>${post.description}</p>
                                <span class="news-date">${post.created_at}</span>
                                <a href="#" class="btn-read-more">Xem thêm</a>
                            </div>
                        `;
                        resultsContainer.appendChild(resultItem);
                    });
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra:', error);
                errorMessageContainer.textContent = 'Có lỗi xảy ra trong quá trình tìm kiếm';
            });
    });
</script>

</body>

</html>
@endsection