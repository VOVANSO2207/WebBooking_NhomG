@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/hotel_detail.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--  -->
@section('header')
@include('partials.header')
@endsection
@section('search')
@include('partials.search_layout')
@endsection
<!--  -->

@section('content')
<section class="hotel_detail">
    <div class="container thu-nho">
        <div class="image-detail-card">
            <div class="row">
                <div class="col-md-6 large-img">
                    @foreach ($hotel->images as $index => $image)
                        @if ($index == 1)
                            <img src="{{ asset('images/' . $image->image_url) }}" alt="{{ $image->image_url }}" />
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6">
                    <div class="row">
                        @foreach ($hotel->images as $index => $image)
                            @if ($index < 3)
                                <div class="col-6 small-img">
                                    <img src="{{ asset('images/' . $image->image_url) }}"
                                        alt="{{ $image->image_url }} Image_null" />
                                </div>
                            @elseif ($index === 3)
                                <div class="col-6 small-img overlay-container">
                                    <img src="{{ asset('images/' . $image->image_url) }}"
                                        alt="{{ $image->image_url }} Image_null" />
                                    <div class="overlay" data-bs-toggle="modal" data-bs-target="#imageModal">
                                        <span>Xem tất cả ảnh</span>
                                    </div>
                                </div>
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="imageModal" data-bs-backdrop="static" tabindex="-1"
            aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Tất cả hình ảnh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5">
                        <div class="row">
                            @foreach ($hotel->images as $image)
                                <div class="col-md-4 mb-3 review-images-details">
                                    <img src="{{ asset('images/' . $image->image_url) }}" alt="{{ $image->image_url }}"
                                        class="img-fluid modal-image-alls">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-location-shape m-0"><span>
                {{ $hotel->city->city_name }}
            </span></div>
        <div class="detail-info-top">
            <div class="detail-hotel-card">
                <span class="hotel-name">{{ $hotel->hotel_name }}</span>
                <div class="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $hotel->rating)
                            <span class="star">★</span>
                        @else
                            <span class="star emty">☆</span>
                        @endif
                    @endfor
                </div>
                <span class="price-label">Giá phòng từ</span>
            </div>
            <div class="detail-info-middle mt-2">
                <div class="row">
                    <div class="col-md-8 detail-left-info">
                        <h5 class="section-title">Giới thiệu</h5>
                        <p class="detail-description">
                            {!! \Illuminate\Support\Str::limit($hotel->description, 500) !!}
                            @if (str_word_count($hotel->description) > 100)
                                <span id="more-text" style="display: none;">
                                    {!! substr($hotel->description, 500) !!}
                                </span>
                                <span>
                                    <a href="#" class="detail-btn-load-more" onclick="toggleMoreText(event)">Xem
                                        thêm</a>
                                </span>
                            @endif
                        </p>
                        <div class="detail-address">
                            <i class="fa-solid fa-location-dot fa-xl me-2"></i>
                            <span>{{ $hotel->location }}</span>
                        </div>
                    </div>
                    <div class="col-md-4 detail-right-info">
                        <span class="detail-price-main">
                            @if ($hotel->rooms->isNotEmpty())
                                <p class="price">{{ number_format($hotel->rooms->min('price'), 0, ',', '.') }}/ đêm
                                </p>
                            @else
                                <p>N/A</p>
                            @endif
                        </span>
                        <div class="detail-map ratio ratio-16x9">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4976450036565!2d106.69522897480486!3d10.773145589375437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38cdaf80a5%3A0x18fb7c58d919b591!2zMTY0IMSQLiBMw6ogVGjDoW5oIFTDtG4sIFBoxrDhu51uZyBC4bq_biBUaMOgbmgsIFF14bqtbiAxLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1730039298467!5m2!1svi!2s"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="detail-button">
                            <a href="#" class="detail-btn-book-room" id="bookNowBtn">Đặt Phòng Ngay</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="hotel-amenities">
                    <div class="row">
                        <div class="col-md-6 detail-title-amenities">Tiện nghi khách sạn </div>
                        @if ($hotel->amenities->IsEmpty())
                            <div class="col-md-6"><a href="#" class="xem-tat-ca"></a></div>
                        @else
                            <div class="col-md-6"><a href="#" class="xem-tat-ca">Xem tất cả ></a></div>
                        @endif
                    </div>
                    <div class="info-amenities d-flex justify-content-center">
                        <div class="row">
                            @if ($hotel->amenities->IsEmpty())
                                <p>Khách sạn không có tiện nghi</p>
                            @else
                                @foreach ($hotel->amenities as $amenity)
                                    <div class="col-6 col-md-3 amenity-item">
                                        <i class="fas fa-check-circle amenity-icon"></i>
                                        {{ $amenity->amenity_name }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="group-detail-book-room" id="bookingSection">
            @if ($rooms->IsEmpty())
                <p> </p>
            @else
                <!--  -->
                <div class="search-bar-staynest color-light container p-0">
                    <form id="searchForm" action="{{ route('hotels.search') }}" method="GET" class="row">
                        @csrf
                        <div class="col-md-4">
                            <h2>Thay đổi ngày nhận trả phòng</h2>
                            <div class="date-picker-search border">
                                <i class="fa-regular fa-calendar-days ps-2"></i>
                                <input class="datepicker-staynest form-control p-0 ms-2" type="text" name="daterange"
                                    value="{{ session('daterange', '') }}" readonly />
                            </div>
                        </div>
                        <!--   <div class="col-md-3">
                                                    <div class="people-summary-container border">
                                                        <div class="people-summary-display">
                                                            <span id="people-summary-counter">{{ session('adults', 1) }} người lớn, </span>
                                                            <span id="room-summary-counter">{{ session('rooms', 1) }} phòng, </span>
                                                            <span id="children-summary-counter">{{ session('children', 0) }} trẻ em</span>
                                                        </div>
                                                    </div>
                                                    <div class="people-counter-dropdown mt-1 bg-light">
                                                        <div class="people-counter-item">
                                                            <span>Người lớn</span>
                                                            <div class="counter-container">
                                                                <button type="button" class="btn-decrement-adult">-</button>
                                                                <input type="text" class="counter-value" id="adultsCounter"
                                                                    name="adults" value="{{ session('adults', 1) }}" readonly>
                                                                <button type="button" class="btn-increment-adult">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="people-counter-item">
                                                            <span>Phòng</span>
                                                            <div class="counter-container">
                                                                <button type="button" class="btn-decrement-room">-</button>
                                                                <input type="text" class="counter-value" id="roomsCounter" name="rooms"
                                                                    value="{{ session('rooms', 1) }}" readonly>
                                                                <button type="button" class="btn-increment-room">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="people-counter-item">
                                                            <span>Trẻ em</span>
                                                            <div class="counter-container">
                                                                <button type="button" class="btn-decrement-children">-</button>
                                                                <input type="text" class="counter-value" id="childrenCounter"
                                                                    name="children" value="{{ session('children', 0) }}" readonly>
                                                                <button type="button" class="btn-increment-children">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                        <!-- <div class="col-md-2 search-header button-search-header">
                                                    <button type="submit" class="btn btn-primary" style="width: 100%; padding:10px;">
                                                        Thay đổi tìm kiếm
                                                    </button>
                                                </div> -->
                    </form>
                </div>
            @endif
            <!--  -->
            <h2 class="detail-title-book-room">
                Chọn phòng
            </h2>
            <div id="searchResults">
                <div class="group-room-card row gx-4">
                    @forelse($rooms as $room)
                        <!-- CARD ROOM -->
                        <div class="col-md-6">
                            <div class="row group-info-room-card">
                                <!-- Hình ảnh -->
                                <div class="col-md-5 detail-infor-room-left">
                                    <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                        navigation="true" space-between="30" loop="true">
                                        @forelse($room->room_images as $image)
                                            <swiper-slide>
                                                <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                                    alt="Room Image" />
                                            </swiper-slide>
                                        @empty
                                            <p>Không có hình ảnh cho phòng này</p>
                                        @endforelse
                                    </swiper-container>
                                </div>

                                <!-- Thông tin room -->
                                <div class="col-md-7 detail-infor-right">
                                    <div class="detail-room-sale">-{{ $room->discount_percent }}%</div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card-room-location m-0">
                                                <i class="fa-solid fa-location-dot"></i>
                                                <span>{{ $hotel->location }}</span>
                                            </div>
                                            <div class="card-room-hotel-name m-0">
                                                <i class="fa-solid fa-bed"></i>
                                                <span>{{ $room->name }}</span>
                                            </div>
                                            <div class="group-room-price">
                                                <ul class="p-0">
                                                    <li>
                                                        <span class="card-room-price-old">
                                                            {{ number_format($room->price, 0, ',', '.') }} / Đêm
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="card-room-price-new">
                                                            {{ number_format($room->price * (1 - $room->discount_percent / 100), 0, ',', '.') }}
                                                            / Đêm
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-room-rating m-0 p-0">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $hotel->rating)
                                                        <span>★</span>
                                                    @else
                                                        <span>☆</span>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card-room-status">
                                                @if (optional($room->room_types)->room_type_id == 1)
                                                    <div class="don">{{ optional($room->roomType)->name }}</div>
                                                @else
                                                    <div class="doi">{{ optional($room->roomType)->name }}</div>
                                                @endif
                                            </div>
                                            <div class="card-room-btn-book">
                                                <form
                                                    action="{{ route('pages.getInfoPay', ['hotel_id' => $hotel->hotel_id, 'room_id' => $room->room_id]) }}"
                                                    method="GET" target="_blank">
                                                    <input type="hidden" name="daterange"
                                                        value="{{ session('daterange', '') }}">
                                                    <button type="submit" class="btn-book-now"
                                                        style="background: none; border: none; color: #fff; cursor: pointer;">Đặt
                                                        ngay</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="404">
                            <h5>Hiện tại không còn phòng trống.</h5>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Links phân trang -->
            <div class="d-flex justify-content-center pt-4">
                {{ $rooms->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="group-review">
            <div class="review-title m-0">ĐÁNH GIÁ</div>
            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($averageRating))
                        <i class="fa-solid fa-star" style="color: #ff4500;"></i> <!-- Sao đầy -->
                    @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                        <i class="fa-solid fa-star-half-stroke" style="color: #ff4500;"></i> <!-- Nửa sao -->
                    @else
                        <i class="fa-regular fa-star" style="color: #ccc;"></i> <!-- Sao chưa được đánh giá -->
                    @endif
                @endfor
            </span>
            <hr class="m-0">
            <div class="total-review m-0 mb-4">
                Có {{ $reviews->count() }} Đánh giá từ người dùng
            </div>

            <div class="box-review">
                @if(auth()->check())
                                @php
                                    $hasBooking = \App\Models\Booking::where('user_id', auth()->user()->user_id)
                                        ->whereHas('room', function ($query) use ($hotel) {
                                            $query->where('hotel_id', $hotel->hotel_id);
                                        })
                                        ->exists();
                                    $hasReviewed = \App\Models\Reviews::where('user_id', auth()->user()->user_id)
                                        ->where('hotel_id', $hotel->hotel_id)
                                        ->exists();
                                @endphp

                                @if($hasBooking && !$hasReviewed)
                                    <form class="group-input-review" id="reviewForm" action="{{ route('reviews.store', $hotel->hotel_id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="icon-profile">
                                            <i class="fa-solid fa-circle-user"></i>
                                        </div>
                                        <div class="group-text-review">
                                            <textarea name="comment" id="inputReview" placeholder="Mời bạn nhập đánh giá..."
                                                class="form-control"></textarea>
                                            @error('comment')
                                                <span class="text-danger" style="font-size: 14px; margin-bottom: -25px">{{ $message }}</span>
                                            @enderror
                                            <div class="upload-file-review d-flex">
                                                <div class="emoj-review">
                                                    <button type="button" id="emojiButton" class="btn btn-light"></button>
                                                </div>
                                                <div class="upload-file">
                                                    <label for="file-input">
                                                        <i class="fa-solid fa-circle-plus"></i>
                                                    </label>
                                                    <input type="file" id="file-input" name="images[]" style="display: none;"
                                                        accept="image/*" multiple>
                                                    @error('images.*')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="rating-stars">
                                            <input type="hidden" name="rating" id="ratingInput" value="0">
                                            <i class="fa-solid fa-star star" data-value="1"></i>
                                            <i class="fa-solid fa-star star" data-value="2"></i>
                                            <i class="fa-solid fa-star star" data-value="3"></i>
                                            <i class="fa-solid fa-star star" data-value="4"></i>
                                            <i class="fa-solid fa-star star" data-value="5"></i>
                                            @error('rating')
                                                <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="btn-submit">
                                            <button type="submit">ĐĂNG</button>
                                        </div>
                                    </form>
                                @elseif($hasReviewed)
                                    <!-- Hiển thị thông báo nếu người dùng đã đánh giá -->
                                    <p style="font-size: 25px;" class="text-success">Bạn đã đánh giá khách sạn này.</p>
                                @else
                                    <!-- Hiển thị thông báo nếu người dùng chưa đặt phòng -->
                                    <p style="font-size: 25px;" class="text-warning">Bạn cần đặt phòng tại khách sạn này để viết đánh giá.
                                    </p>
                                @endif
                @else
                    <!-- Hiển thị thông báo nếu người dùng chưa đăng nhập -->
                    <p style="font-size: 25px;" class="text-warning">Vui lòng <a href="{{ route('login') }}">đăng nhập</a>
                        để viết đánh giá.</p>
                @endif
                <div class="image-preview-review d-flex">
                    <img id="preview" src="" alt="Ảnh xem trước" multiple>
                </div>

                <!-- HIỂN THỊ ĐÁNH GIÁ -->
                @foreach ($reviews as $review)
                    <div class="box-comment-review mt-3 d-flex">
                        <div class="icon-profile ms-5">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <div class="view-review ms-2">
                            <div class="group-info-review">
                                <div class="review-user-name">{{ $review->user->username }}</div>
                                <div class="created_at">{{ $review->created_at }}</div>
                                <!-- Hiển thị số sao đánh giá -->
                                <div class="review-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fa-solid fa-star" style="color: #ff4500;"></i>
                                            <!-- Sao được đánh giá -->
                                        @else
                                            <i class="fa-regular fa-star" style="color: #ccc;"></i>
                                            <!-- Sao chưa được đánh giá -->
                                        @endif
                                    @endfor
                                </div>
                                <div class="comment-text">
                                    {!! $review->comment !!}
                                </div>
                                <!-- Hiển thị hình ảnh đánh giá nếu có -->
                                <div class="image-review">
                                    @foreach ($review->images as $image)
                                        <img src="{{ asset($image->image_url) }}" width="20%" alt="Review Image">
                                    @endforeach
                                </div>

                                <div class="action-review mt-2">
                                    <a href="javascript:void(0)" class="like-review me-4"
                                        id="like-review-{{ $review->review_id }}" data-review-id="{{ $review->review_id }}">
                                        <i class="fa-solid fa-thumbs-up"></i> <span class="like-count"
                                            id="like-count-{{ $review->review_id }}">{{ $review->likes_count }}</span>
                                        Thích
                                    </a>
                                    @if (auth()->check() && (auth()->user()->user_id === $review->user_id || auth()->user()->is_admin))
                                        <button type="button" class="delete-review-btn me-4 btn btn-link"
                                            data-review-id="{{ $review->review_id }}" data-bs-toggle="modal"
                                            data-bs-target="#deleteReviewModal">
                                            <i class="fa-solid fa-trash"></i> Xóa Đánh Giá
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


                <!-- PHÂN TRANG -->
                <div class="d-flex justify-content-center mt-3 pagination-voucher">
                    {{ $reviews->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Xác Nhận Xóa -->
    <div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReviewModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa bình luận này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form id="deleteReviewForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginRequiredModalLabel">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

</section>
<script>
    function showLoginModal() {
        const loginModal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
        loginModal.show();
    }
    document.addEventListener('DOMContentLoaded', function () {
        const likeButtons = document.querySelectorAll('.like-review'); // Lấy tất cả các nút like

        likeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const reviewId = this.getAttribute(
                    'data-review-id'); // Lấy review_id từ data attribute
                const likeCountSpan = document.getElementById(
                    `like-count-${reviewId}`); // Lấy span số like

                // Gửi yêu cầu AJAX để thích hoặc bỏ thích
                fetch(`/reviews/like/${reviewId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]').getAttribute(
                                'content') // CSRF Token
                    },
                    body: JSON.stringify({
                        review_id: reviewId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật số lượng like mới nhận được từ phản hồi của server
                            likeCountSpan.textContent = data.likes_count;

                            // Thêm hoặc bỏ class liked để thay đổi kiểu dáng của nút
                            if (data.action === 'liked') {
                                this.classList.add('liked');
                            } else {
                                this.classList.remove('liked');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.rating-stars .star');
        const ratingInput = document.getElementById('ratingInput');

        stars.forEach(star => {
            // Khi click
            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-value');
                ratingInput.value = rating;

                // Reset các sao
                stars.forEach(s => s.classList.remove('selected'));

                // Tô màu từ sao đầu tiên đến ngôi sao được chọn
                for (let i = 0; i < rating; i++) {
                    stars[i].classList.add('selected');
                }
            });

            // Khi hover
            star.addEventListener('mouseover', function () {
                const hoverValue = this.getAttribute('data-value');

                // Reset hover
                stars.forEach(s => s.classList.remove('hover'));

                // Tô màu từ sao đầu tiên đến ngôi sao được hover
                for (let i = 0; i < hoverValue; i++) {
                    stars[i].classList.add('hover');
                }
            });

            // Khi chuột rời khỏi
            star.addEventListener('mouseout', function () {
                // Xóa hiệu ứng hover
                stars.forEach(s => s.classList.remove('hover'));
            });
        });
    });



    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-review-btn');
        const deleteForm = document.getElementById('deleteReviewForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const reviewId = this.getAttribute('data-review-id');
                const updatedAt = this.getAttribute('data-updated-at'); // Lấy updated_at từ nút

                // Cập nhật URL action và thêm trường hidden updated_at vào form
                deleteForm.setAttribute('action', `/review/${reviewId}`);
                deleteForm.innerHTML +=
                    `<input type="hidden" name="updated_at" value="${updatedAt}">`;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const emojiButton = document.querySelector('#emojiButton');
        const inputReview = document.querySelector('#inputReview');

        // Tạo đối tượng EmojiConvertor
        const emoji = new EmojiConvertor();
        emoji.img_sets.apple.path =
            'https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/assets/png/'; // Đường dẫn biểu tượng emoji
        emoji.use_sheet = false;

        // Hiển thị picker emoji khi bấm nút
        emojiButton.addEventListener('click', () => {
            const emojiPicker = document.createElement('div');
            emojiPicker.classList.add('emoji-picker');
            emojiPicker.style.position = 'absolute';
            emojiPicker.style.border = '1px solid #ccc';
            emojiPicker.style.backgroundColor = '#fff';
            emojiPicker.style.padding = '10px';
            emojiPicker.style.zIndex = '1000';

            // Danh sách emoji mẫu
            const emojis = ['😊', '😂', '😍', '🥺', '👍', '🎉', '😢', '❤️'];
            emojis.forEach(em => {
                const emojiElement = document.createElement('span');
                emojiElement.textContent = em;
                emojiElement.style.cursor = 'pointer';
                emojiElement.style.margin = '5px';
                emojiElement.style.fontSize = '20px';

                emojiElement.addEventListener('click', () => {
                    inputReview.value += em;
                    emojiPicker.remove(); // Đóng picker khi chọn emoji
                });

                emojiPicker.appendChild(emojiElement);
            });

            document.body.appendChild(emojiPicker);

            // Đặt vị trí picker gần nút
            const rect = emojiButton.getBoundingClientRect();
            emojiPicker.style.top = `${rect.bottom + window.scrollY}px`;
            emojiPicker.style.left = `${rect.left + window.scrollX}px`;

            // Đóng picker khi click bên ngoài
            document.addEventListener('click', function closePicker(event) {
                if (!emojiPicker.contains(event.target) && event.target !== emojiButton) {
                    emojiPicker.remove();
                    document.removeEventListener('click', closePicker);
                }
            });
        });
    });

    // Hiển thị ảnh xem trước ở bình luận và lưu ảnh vào store để f5 không mất
    (function () {
        const EXPIRATION_TIME = 10 * 60 * 1000; // 10 phút tính bằng mili giây
        const MAX_UPLOAD_COUNT = 10; // Giới hạn số lượng ảnh tối đa 

        const fileInput = document.getElementById('file-input');
        const previewContainer = document.querySelector('.image-preview-review');

        // Hàm hiển thị ảnh xem trước với nút xóa
        function displayImage(src) {
            const imgContainer = document.createElement('div');
            imgContainer.classList.add('preview-container');

            const img = document.createElement('img');
            img.src = src;
            img.alt = 'Ảnh xem trước';
            img.classList.add('preview-image');

            const closeButton = document.createElement('span');
            closeButton.classList.add('close-button');
            closeButton.innerHTML = '&times;';

            // Xóa ảnh khi nhấn vào nút X và cập nhật `localStorage`
            closeButton.addEventListener('click', function () {
                previewContainer.removeChild(imgContainer);

                // Cập nhật lại danh sách ảnh trong `localStorage`
                let updatedImages = JSON.parse(localStorage.getItem('previewImages')) || [];
                updatedImages = updatedImages.filter(item => item.src !== src);
                localStorage.setItem('previewImages', JSON.stringify(updatedImages));
            });

            imgContainer.appendChild(img);
            imgContainer.appendChild(closeButton);
            previewContainer.appendChild(imgContainer);
        }

        // Xử lý khi chọn ảnh mới
        fileInput.addEventListener('change', function (event) {
            const files = event.target.files;
            let images = JSON.parse(localStorage.getItem('previewImages')) || [];

            // Kiểm tra số lượng ảnh đã tải lên
            if (images.length + files.length > MAX_UPLOAD_COUNT) {
                alert('Bạn chỉ có thể tải tối đa ' + MAX_UPLOAD_COUNT + ' ảnh!');
                return;
            }

            Array.from(files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imgData = {
                        src: e.target.result,
                        timestamp: Date.now() // Lưu thời gian hiện tại
                    };

                    images.push(imgData);
                    localStorage.setItem('previewImages', JSON.stringify(images));

                    // Hiển thị ảnh mới
                    displayImage(imgData.src);
                };

                reader.readAsDataURL(file);
            });
        });

        // Kiểm tra và hiển thị các ảnh còn hạn sử dụng khi tải lại trang
        document.addEventListener('DOMContentLoaded', function () {
            let storedImages = JSON.parse(localStorage.getItem('previewImages')) || [];

            // Lọc và chỉ hiển thị các ảnh còn hạn sử dụng
            const validImages = storedImages.filter(imgData => {
                const isValid = Date.now() - imgData.timestamp < EXPIRATION_TIME;
                if (isValid) displayImage(imgData.src);
                return isValid;
            });

            // Cập nhật lại `localStorage` chỉ với các ảnh còn hạn
            localStorage.setItem('previewImages', JSON.stringify(validImages));
        });

        // Xóa danh sách ảnh khỏi localStorage sau 5 giây và gửi form
        setTimeout(function () {
            // Thêm sự kiện xóa ảnh khỏi localStorage khi nhấn nút "ĐĂNG"
            document.querySelector('.btn-submit button').addEventListener('click', function (event) {
                // event.preventDefault();
                // Xóa danh sách ảnh khỏi localStorage
                localStorage.removeItem('previewImages');

                // Nếu bạn muốn reset giao diện xem trước
                const previewContainer = document.querySelector('.image-preview-review');
                while (previewContainer.firstChild) {
                    previewContainer.removeChild(previewContainer.firstChild);
                }
            });
        }, 3000);
    })();
    // Khi click ảnh sẽ được gọi class enlarged và phóng to lên
    document.addEventListener('DOMContentLoaded', function () {
        const images = document.querySelectorAll('.modal-image-alls');
        let activeImage = null;

        images.forEach(function (img) {
            img.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent modal from closing

                if (activeImage && activeImage !== img) {
                    activeImage.classList.remove('enlarged');
                }

                img.classList.toggle('enlarged');
                activeImage = img.classList.contains('enlarged') ? img : null;
            });
        });

        // Đóng ảnh đồng nghĩa trả về mặc định khi click ra bên ngoài modal
        document.querySelector('#imageModal .modal-body').addEventListener('click', function () {
            if (activeImage) {
                activeImage.classList.remove('enlarged');
                activeImage = null;
            }
        });

        // Trả về mặc định khi modal hidden
        document.querySelector('#imageModal').addEventListener('hidden.bs.modal', function () {
            if (activeImage) {
                activeImage.classList.remove('enlarged');
                activeImage = null;
            }
        });
    });
    // load more cho giới thiệu description
    function toggleMoreText(event) {
        event.preventDefault(); // Prevent the default anchor behavior

        const moreText = document.getElementById("more-text");
        const loadMoreBtn = event.target;

        if (moreText.style.display === "none") {
            moreText.style.display = "inline"; // Show more text
            loadMoreBtn.textContent = "Thu gọn"; // Change button text
        } else {
            moreText.style.display = "none"; // Hide more text
            loadMoreBtn.textContent = "Xem thêm"; // Reset button text
        }
    }
    // 
    document.getElementById('bookNowBtn').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('bookingSection').scrollIntoView({
            behavior: 'smooth' // Cuộn mượt mà
        });
    });
    // 
    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('searchForm');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn form gửi theo cách thông thường

            // Lấy URL và tạo query string từ các input
            const url = searchForm.getAttribute('action');
            const formData = new FormData(searchForm);
            const queryString = new URLSearchParams(formData).toString();

            // Gửi yêu cầu AJAX với fetch
            fetch(`${url}?${queryString}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Để Laravel nhận diện đây là yêu cầu AJAX
                },
            })
                .then(response => response.json())
                .then(data => {
                    // Cập nhật HTML trong div #searchResults
                    document.getElementById('searchResults').innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('searchResults').innerHTML =
                        '<p>Đã xảy ra lỗi. Vui lòng thử lại sau.</p>';
                });
        });

    });

    // 
    (function () {
        document.addEventListener("DOMContentLoaded", function () {
            const peopleSummaryContainer = document.querySelector('.people-summary-container');
            const peopleCounterDropdown = document.querySelector('.people-counter-dropdown');

            peopleSummaryContainer.addEventListener('click', function () {
                // Toggle giữa hiển thị và ẩn phần .people-counter-dropdown
                if (peopleCounterDropdown.style.display === "none" || peopleCounterDropdown.style
                    .display === "") {
                    peopleCounterDropdown.style.display = "block";
                } else {
                    peopleCounterDropdown.style.display = "none";
                }
            });

            // Ẩn dropdown khi nhấn ra ngoài
            document.addEventListener('click', function (e) {
                if (!peopleSummaryContainer.contains(e.target) && !peopleCounterDropdown.contains(e
                    .target)) {
                    peopleCounterDropdown.style.display = "none";
                }
            });
        });
    })();

    //
    document.addEventListener("DOMContentLoaded", function () {
        const roomsInput = document.getElementById("roomsCounter");
        const adultsInput = document.getElementById("adultsCounter");
        const childrenInput = document.getElementById("childrenCounter");
        const roomSummary = document.getElementById("room-summary-counter");
        const peopleSummary = document.getElementById("people-summary-counter");
        const childrenSummary = document.getElementById("children-summary-counter");

        // Cập nhật hiển thị số lượng
        function updateSummary() {
            roomSummary.innerHTML = `${roomsInput.value} phòng, `;
            peopleSummary.innerHTML = `${adultsInput.value} người lớn, `;
            childrenSummary.innerHTML = `${childrenInput.value} trẻ em`;
        }

        // Tính toán số người tối đa
        function maxPeople() {
            return roomsInput.value * 4; // Mỗi phòng tối đa 4 người
        }

        // Kiểm tra và điều chỉnh số lượng người lớn
        function checkAdults() {
            const totalPeople = parseInt(adultsInput.value) + parseInt(childrenInput.value);
            const max = maxPeople();
            if (totalPeople > max) {
                alert(`Tối đa ${max} người cho ${roomsInput.value} phòng.`);
                adultsInput.value = max - parseInt(childrenInput.value);
            }
            updateSummary();
        }

        // Kiểm tra và điều chỉnh số trẻ em
        function checkChildren() {
            const maxChildren = roomsInput.value * 4; // Tối đa 4 trẻ em cho mỗi phòng
            if (parseInt(childrenInput.value) > maxChildren) {
                alert(`Tối đa ${maxChildren} trẻ em cho ${roomsInput.value} phòng.`);
                childrenInput.value = maxChildren; // Điều chỉnh trẻ em nếu vượt quá
            }
            updateSummary();
        }

        // Tăng giảm số lượng
        document.querySelector(".btn-increment-room").onclick = function () {
            roomsInput.value = parseInt(roomsInput.value) + 1;
            updateButtons();
            updateSummary();
        };

        document.querySelector(".btn-decrement-room").onclick = function () {
            if (roomsInput.value > 1) {
                roomsInput.value = parseInt(roomsInput.value) - 1;
                updateButtons();
                updateSummary();
            }
        };

        document.querySelector(".btn-increment-adult").onclick = function () {
            adultsInput.value = parseInt(adultsInput.value) + 1;
            checkAdults();
            updateButtons();
            updateSummary();
        };

        document.querySelector(".btn-decrement-adult").onclick = function () {
            if (adultsInput.value > 1) {
                adultsInput.value = parseInt(adultsInput.value) - 1;
                updateButtons();
                updateSummary();
            }
        };

        document.querySelector(".btn-increment-children").onclick = function () {
            const maxChildren = roomsInput.value * 4; // Tối đa 4 trẻ em cho mỗi phòng
            if (parseInt(childrenInput.value) < maxChildren) {
                childrenInput.value = parseInt(childrenInput.value) + 1;
            }
            checkChildren();
            updateButtons();
            updateSummary();
        };

        document.querySelector(".btn-decrement-children").onclick = function () {
            if (childrenInput.value > 0) {
                childrenInput.value = parseInt(childrenInput.value) - 1;
            }
            updateButtons();
            updateSummary();
        };

        // Cập nhật trạng thái nút
        function updateButtons() {
            document.querySelector(".btn-decrement-room").disabled = roomsInput.value <= 1;
            document.querySelector(".btn-decrement-adult").disabled = adultsInput.value <= 1;
            document.querySelector(".btn-decrement-children").disabled = childrenInput.value <= 0;
        }

        // Khởi tạo hiển thị ban đầu
        updateSummary();
        updateButtons();
    });

    // 
</script>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

@section('footer')
@include('partials.footer')
@endsection