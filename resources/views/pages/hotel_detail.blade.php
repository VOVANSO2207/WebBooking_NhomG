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

@section('content')
<section class="hotel_detail">
    <div class="container thu-nho">
        <div class="image-detail-card">
            <div class="row">
                <div class="col-md-6 large-img">
                    @foreach ($hotel->images as $index => $image)
                        @if ($index == 1)
                            <img src="{{ asset('storage/images/' . $image->image_url) }}" alt="{{ $image->image_url }}" />
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6">
                    <div class="row">
                        @foreach ($hotel->images as $index => $image)
                            @if ($index < 3)
                                <div class="col-6 small-img">
                                    <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                        alt="{{ $image->image_url }} Image_null" />
                                </div>
                            @elseif ($index === 3)
                                <div class="col-6 small-img overlay-container">
                                    <img src="{{ asset('storage/images/' . $image->image_url) }}"
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Tất cả hình ảnh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5">
                        <div class="row">
                            <div class="staynest-image-swiper mb-3">
                                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                    navigation="true" space-between="30" loop="true">
                                    @foreach ($hotel->images as $image)
                                        <swiper-slide>
                                            <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                                alt="{{ $image->image_url }}" style="object-fit: cover;" />
                                        </swiper-slide>
                                    @endforeach
                                </swiper-container>
                            </div>
                            @foreach ($hotel->images as $image)
                                <div class="col-md-4 mb-3 review-images-details">
                                    <img src="{{ asset('storage/images/' . $image->image_url) }}"
                                        alt="{{ $image->image_url }}" style="object-fit: cover;"
                                        class="img-fluid modal-image-alls" />
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
                            <span class="star-1">★</span>
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
                                <p class="price">{{ number_format($hotel->rooms->min('price'), 0, ',', '.') }} VND/ đêm
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

        <div class="group-review">
            <div class="review-title m-0">ĐÁNH GIÁ</div>
            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($averageRating))
                        <i class="fa-solid fa-star" style="color: #3B79C9;"></i> <!-- Sao đầy -->
                    @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                        <i class="fa-solid fa-star-half-stroke" style="color: #3B79C9;"></i> <!-- Nửa sao -->
                    @else
                        <i class="fa-regular fa-star" style="color: #ccc;"></i> <!-- Sao chưa được đánh giá -->
                    @endif
                @endfor
            </span>
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <!-- Tổng điểm -->
                    <div class="col-4 overall-score">
                        <div class="circle">
                            <span class="score">{{ number_format($averageRating, 1) }}</span>
                            <span class="description">
                                @if (is_null($averageRating))
                                    Chưa có đánh giá
                                @elseif ($averageRating >= 8) Ấn tượng
                                @else ($averageRating >= 6) Tốt
                                @endif

                            </span>

                        </div>
                        <p class="total-reviews" style="font-size: 20px; font-weight: 500;">
                            Từ {{ $totalReviews }} đánh giá của khách hàng đã đặt
                        </p>
                    </div>
                    <!-- Phân loại đánh giá -->
                    <div class="col-5 rating-distribution">
                        @foreach ($ratingDistribution as $label => $count)
                                                @php
                                                    $percentage = ($totalReviews > 0) ? ($count / $totalReviews * 100) : 0;
                                                    $labelText = match ($label) {
                                                        'tuyetvoi' => 'Tuyệt vời',
                                                        'ratot' => 'Rất tốt',
                                                        'hailong' => 'Hài lòng',
                                                        'trungbinh' => 'Trung bình',
                                                        'kem' => 'Kém',
                                                    };
                                                @endphp
                                                <div class="rating-row">
                                                    <span class="rating-label">{{ $labelText }}</span>
                                                    <div class="progress-bar">
                                                        <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                                                    </div>
                                                    <span class="rating-count">{{ $count }}</span>
                                                </div>
                        @endforeach
                    </div>
                </div>

                <hr class="m-0">

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
                                            <form class="mt-5 comment-box mx-auto" id="reviewForm"
                                                action="{{ route('reviews.store', $hotel->hotel_id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <!-- Header với avatar và tên người dùng -->
                                                <div class="d-flex align-items-center mb-3">
                                                    <img class="rounded-circle me-2"
                                                        src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/images/' . Auth::user()->avatar) : asset('images/user-profile.png') }}"
                                                        alt="Avatar" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                                    <h4 class="mb-0">{{ Auth::user()->username }}</h4>
                                                </div>
                                                <!-- Input nhận xét -->
                                                <div class="stay-nest-input-review">
                                                    <div class="input-review">
                                                        <textarea name="comment" id="inputReview"
                                                            class="comment-body form-control orther-input m-0" maxlength="1000"
                                                            placeholder="Nhập nhận xét của bạn tại đây..."></textarea>
                                                        @error('comment')
                                                            <span class="text-danger"
                                                                style="font-size: 14px; margin-bottom: -25px">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
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
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="char-limit">0/1000</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Action Buttons -->
                                                <div class="d-flex justify-content-between align-items-center row mt-2 mb-0">
                                                    <div class="action-buttons col-md-6">
                                                        <span id="boldButton"><i class="fas fa-bold"></i></span>
                                                        <span id="italicButton"><i class="fas fa-italic"></i></span>
                                                        <span id="stayNestUploadFile">
                                                            <label for="file-input">
                                                                <i class="fa-solid fa-camera-retro"></i>
                                                            </label>
                                                            <input type="file" id="file-input" name="images[]" style="display: none;"
                                                                accept="image/*" multiple>
                                                            @error('images.*')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </span>
                                                        <span> <button type="button" id="emojiButton">😂</button></span>
                                                    </div>

                                                    <div class="btn-submit col-md-2">
                                                        <button type="submit" class="btn btn-primary w-100">ĐĂNG</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @elseif($hasReviewed)
                                            <!-- Hiển thị thông báo nếu người dùng đã đánh giá -->
                                            <p style="font-size: 25px;" class="text-success">Bạn đã đánh giá khách sạn này.</p>
                                        @else
                                            <!-- Hiển thị thông báo nếu người dùng chưa đặt phòng -->
                                            <p style="font-size: 25px;" class="text-warning">Bạn cần đặt phòng tại khách sạn này để viết
                                                đánh giá.
                                            </p>
                                        @endif
                    @else
                        <!-- Hiển thị thông báo nếu người dùng chưa đăng nhập -->
                        <p style="font-size: 25px;" class="text-warning">
                            Vui lòng
                            <a href="{{ route('login') }}">
                                đăng nhập
                            </a>
                            để viết đánh giá.
                        </p>
                    @endif
                    <div class="image-preview-review d-flex">
                        <img id="preview" src="" alt="Ảnh xem trước" multiple>
                    </div>
                </div>
            </div>
            <!-- Modal Xác Nhận Xóa -->

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

<div class="stay-nest-review">
    <div class="container stay-nest-review-container">
        @foreach ($reviews as $review)
                <div class="row p-3 rounded align-items-start">
                    <!-- Avatar và thông tin người dùng -->
                    <div class="col-md-2 d-flex align-items-center">
                        <div class="avatar bg-light rounded-circle d-flex justify-content-center align-items-center me-3 border"
                            style="width: 64px; height: 64px;">
                            <span class="text-uppercase fw-bold" style="font-size: 24px;">
                                {{ substr($review->user->username ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <div class="stay-nest-review-name-group">
                                <h5 class="mb-0">
                                    {{ $review->user->username ?? 'Anonymous' }}
                                </h5>
                                <span class="ms-2">{{ $review->user->role->role_name }}</span>
                            </div>
                            <p class="text-muted mb-0">
                                <i class="fa-solid fa-pen fa-xs"></i>
                                {{ \Carbon\Carbon::parse($review->created_at)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    <!-- Nội dung đánh giá -->
                    <div class="col-md-10 review-content">
                        <h5 class="m-0 d-flex">
                            {{$review->hotel->hotel_name}}
                            <span class="badge ms-2">
                                {{round($review->rating, 2)}}
                            </span>
                        </h5>
                        @php
                            $rating = round($review->rating, 2);
                            $labelTextRating = match ($rating) {
                                5.00 => 'Tuyệt vời',
                                4.00 => 'Rất tốt',
                                3.00 => 'Hài lòng',
                                2.00 => 'Trung bình',
                                1.00 => 'Kém',
                                default => 'Chưa đánh giá',
                            };
                         @endphp
                        <p class="text-muted m-0 mb-1">{{ $labelTextRating  }}</p>
                        <div class="review-rating m-0">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="fa-solid fa-star" style="color: #3B79C9;"></i>
                                @else
                                    <i class="fa-regular fa-star" style="color: #ccc;"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="mb-0">{!! $review->comment !!}</p>
                        <!-- Hiển thị ảnh -->
                        <div class="d-flex mt-2">
                            @foreach ($review->images->take(2) as $image)
                                <img src="{{ asset($image->image_url) }}" alt="Review Image" class="img-fluid rounded me-2 border"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endforeach
                            @if ($review->images->count() > 2)
                                <!-- Hiển thị nút "+x" -->
                                <div class="position-relative ms-2">
                                    <div class="extra-images d-flex align-items-center justify-content-center bg-secondary text-white rounded"
                                        style="width: 100px; height: 100px; cursor: pointer;" data-bs-toggle="modal"
                                        data-bs-target="#imageModalReview-{{ $review->id }}">
                                        +{{ $review->images->count() - 2 }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-2 review-function align-items-end">
                            <a href="javascript:void(0)" class="like-review me-4 btn btn-outline-primary"
                                id="like-review-{{ $review->review_id }}" data-review-id="{{ $review->review_id }}">
                                <i class="fa-solid fa-thumbs-up"></i>
                                <span class="like-count" id="like-count-{{ $review->review_id }}">
                                    {{ $review->likes_count }}
                                </span>
                                Hữu ích
                            </a>
                            </button>
                            @if (auth()->check() && (auth()->user()->user_id === $review->user_id || auth()->user()->is_admin))
                                <button type="button" class="delete-review-btn me-4 btn" data-review-id="{{ $review->review_id }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteReviewModal">
                                    <i class="fa-solid fa-trash"></i> Xóa Đánh Giá
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Modal hiển thị tất cả ảnh -->
                <div class="modal fade" id="imageModalReview-{{ $review->id }}" tabindex="-1"
                    aria-labelledby="imageModalLabel-{{ $review->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel-{{ $review->id }}">Hình ảnh đánh giá</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @foreach ($review->images as $image)
                                        <div class="col-6 mb-3">
                                            <img src="{{ asset($image->image_url) }}" alt="Full Image"
                                                class="img-fluid rounded border image_review_full">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
    </div>
    <!-- PHÂN TRANG -->
    <div class="d-flex justify-content-center mt-3 pagination-voucher">
        {{ $reviews->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
    </div>
</div>

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

        (function () {
            const images = document.querySelectorAll('.modal-image-alls');
            let activeImage = null;

            images.forEach(function (img) {
                img.addEventListener('click', function (event) {
                    console.log("CLICK DUOC ");
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
        })
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
    (function () {
        // Đảm bảo code nằm trong phạm vi cục bộ
        const inputReview = document.getElementById("inputReview");
        const boldButton = document.getElementById("boldButton");
        const italicButton = document.getElementById("italicButton");
        const linkButton = document.getElementById("linkButton");

        // Thêm chức năng in đậm
        boldButton.addEventListener("click", () => {
            inputReview.style.fontWeight =
                inputReview.style.fontWeight === "bold" ? "normal" : "bold";
        });

        // Thêm chức năng in nghiêng
        italicButton.addEventListener("click", () => {
            inputReview.style.fontStyle =
                inputReview.style.fontStyle === "italic" ? "normal" : "italic";
        });
    })();

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
        // console.log("CLICK DUOC");
        e.preventDefault();
        document.getElementById('bookingSection').scrollIntoView({
            behavior: 'smooth' // Cuộn mượt mà
        });
    });

    function setupCharacterCounter() {
        const textarea = document.getElementById('inputReview');
        const charLimit = document.querySelector('.char-limit');
        textarea.addEventListener('input', () => {
            charLimit.textContent = `${textarea.value.length}/1000`;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        setupCharacterCounter();
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
</script>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

@section('footer')
@include('partials.footer')
@endsection