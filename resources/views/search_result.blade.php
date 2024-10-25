@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('header')
@include('partials.header') 
@endsection
{{-- Link File CSS  --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/search_result.css') }}">
@endsection
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <h3>Có 554 khách sạn tại Thành Phố Hồ Chí Minh</h3>
    </div>
    <div class="row d-flex">
        <div class="col-3 filter">
            <div class="header_title">
                <h3>Bộ lọc</h3>
            </div>
            <span class="line"></span>
            <div class="price-slider">
                <h2>Giá mỗi đêm</h2>
                <div class="wrapper">
                    <div class="slider">
                        <div class="progress"></div>
                    </div>
                    <div class="range-input">
                        <input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
                        <input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
                    </div>
                    <div class="price-input">
                        <div class="field">
                            <span>Thấp nhất</span>
                            <input type="number" class="input-min" value="2500" readonly>
                        </div>
                        <div class="separator">-</div>
                        <div class="field">
                            <span>Cao nhất</span>
                            <input type="number" class="input-max" value="7500" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Popular_filters">
                <h2>Bộ lọc phổ biến</h2>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Nhiều đánh giá</p>
                    <input type="checkbox" class="check_filter">
                </div>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Khuyến mãi</p>
                    <input type="checkbox" class="check_filter">
                </div>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Phòng đơn</p>
                    <input type="checkbox" class="check_filter">
                </div>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Phòng đôi</p>
                    <input type="checkbox" class="check_filter">
                </div>

            </div>
            <span class="line"></span>

            <div class="rating-container">
                <h2 class="rating-title">Hạng sao khách sạn</h2>
                <div class="star-container">
                    <button class="star-button" data-rating="2">2 ★</button>
                    <button class="star-button" data-rating="3">3 ★</button>
                    <button class="star-button active" data-rating="4">4 ★</button>
                    <button class="star-button" data-rating="5">5 ★</button>
                </div>
            </div>
            <div class="line"></div>
            <!-- Tiện nghi khách sạn -->
            <div class="amenities_hotel">
                <h2 class="title_top">Tiện nghi khách sạn</h2>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Cho thuê xe đạp</p>
                    <input type="checkbox" class="check_filter">
                </div>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Cho thuê xe đạp</p>
                    <input type="checkbox" class="check_filter">
                </div>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Cho thuê xe đạp</p>
                    <input type="checkbox" class="check_filter">
                </div>
                <div class="option d-flex justify-content-between align-items-center">
                    <p>Cho thuê xe đạp</p>
                    <input type="checkbox" class="check_filter">
                </div>
            </div>
        </div>

        <div class="col-9">
            <div class="tab_control">
                <ul class="tab_list d-flex">
                    <span class="text_first">Sắp xếp:</span>
                    <li><button class="tab_btn active" data-tab="low-to-high">Giá rẻ</button></li>
                    <li><button class="tab_btn" data-tab="high-to-low">Giá đắt</button></li>
                    <li><button class="tab_btn" data-tab="popular">Đánh giá nhiều nhất</button></li>
                    <li><button class="tab_btn" data-tab="rating">Xếp hạng sao</button></li>
                </ul>
            </div>

            <div class="tab_content">
                <div id="low-to-high" class="tab_item active">
                    <div class="d-flex">
                        <p>Ngày đi: {{ isset($daterange) ? explode(' - ', $daterange)[0] : '' }} </p>
                        <p class="ms-2">Ngày về: {{ isset($daterange) ? explode(' - ', $daterange)[1] : '' }} </p>
                        <p class="ms-2">Số phòng: {{ $rooms }} </p>
                        <p class="ms-2">Số người lớn: {{ $adults }} </p>
                        <p class="ms-2">Số trẻ em: {{ $children }} </p>
                    </div>
                    @if ($hotels->isEmpty())
                        <p>Không tìm thấy khách sạn nào.</p>
                    @else
                        @foreach ($hotels as $hotel)
                            <div class="hotel-card">
                                <div class="sale-badge">SALE</div>
                                <div class="hotel-image">
                                    <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                        navigation="true" space-between="30" loop="true" style="height: auto">
                                        <swiper-slide>
                                            <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                        </swiper-slide>
                                        <swiper-slide>
                                            <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                        </swiper-slide>
                                        <swiper-slide>
                                            <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                        </swiper-slide>
                                        <swiper-slide>
                                            <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                        </swiper-slide>
                                        <!-- Thêm các slide khác -->
                                    </swiper-container>

                                </div>
                                <div class="hotel-info row">
                                    <div class="col-md-9">
                                        <p class="reviews">Có {{ $hotel->rating }} lượt đánh giá</p>
                                        <h4 class="location_hotel">
                                            <i class="fas fa-map-marker-alt icon-location" style="color: #3B79C9;"></i>
                                            Thành Phố Hồ Chí Minh
                                        </h4>
                                        <h3 class="name_hotel"><i class="fa-solid fa-hotel icon-hotel"
                                                style="color: #3B79C9;"></i>{{ $hotel->hotel_name }}</h3>
                                        <div class="price-info">
                                            <span class="old-price">2.337.999 đ</span>
                                            <span class="discount">-25%</span>
                                        </div>
                                        <span class="new-price">1.763.668 đ</span>
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $hotel->rating)
                                                    <span>★</span>
                                                @else
                                                    <span>☆</span>
                                                @endif
                                            @endfor

                                        </div>

                                    </div>
                                    <div class="col-md-3 status-button">
                                        <div class="status">
                                            <span class="status-available">ĐƠN</span>
                                            <span class="status-soldout">ĐÔI</span>
                                        </div>

                                        <button class="book-now">Đặt Ngay</button>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endif

                </div>

                <div id="high-to-low" class="tab_item">
                    <div class="hotel-card">
                        <div class="sale-badge">SALE</div>
                        <div class="hotel-image">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true" style="height: auto">
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <!-- Thêm các slide khác -->
                            </swiper-container>

                        </div>
                        <div class="hotel-info row">
                            <div class="col-md-9">
                                <p class="reviews">Có {{ $hotel->rating }} lượt đánh giá</p>
                                <h4 class="location_hotel">
                                    <i class="fas fa-map-marker-alt icon-location" style="color: #3B79C9;"></i>
                                    Thành Phố Hồ Chí Minh
                                </h4>
                                <h3 class="name_hotel"><i class="fa-solid fa-hotel icon-hotel"
                                        style="color: #3B79C9;"></i>{{ $hotel->hotel_name }}</h3>
                                <div class="price-info">
                                    <span class="old-price">2.337.999 đ</span>
                                    <span class="discount">-25%</span>
                                </div>
                                <span class="new-price">1.763.668 đ</span>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->rating)
                                            <span>★</span>
                                        @else
                                            <span>☆</span>
                                        @endif
                                    @endfor
                                    <div class="status">
                                        <span class="status-available">ĐƠN</span>
                                        <span class="status-soldout">ĐÔI</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3 status-button">


                                <button class="book-now">Đặt Ngay</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="popular" class="tab_item">
                    <div class="hotel-card">
                        <div class="sale-badge">SALE</div>
                        <div class="hotel-image">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true" style="height: auto">
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <!-- Thêm các slide khác -->
                            </swiper-container>

                        </div>
                        <div class="hotel-info row">
                            <div class="col-md-9">
                                <p class="reviews">Có {{ $hotel->rating }} lượt đánh giá</p>
                                <h4 class="location_hotel">
                                    <i class="fas fa-map-marker-alt icon-location" style="color: #3B79C9;"></i>
                                    Thành Phố Hồ Chí Minh
                                </h4>
                                <h3 class="name_hotel"><i class="fa-solid fa-hotel icon-hotel"
                                        style="color: #3B79C9;"></i>{{ $hotel->hotel_name }}</h3>
                                <div class="price-info">
                                    <span class="old-price">2.337.999 đ</span>
                                    <span class="discount">-25%</span>
                                </div>
                                <span class="new-price">1.763.668 đ</span>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->rating)
                                            <span>★</span>
                                        @else
                                            <span>☆</span>
                                        @endif
                                    @endfor
                                </div>

                            </div>
                            <div class="col-md-3 status-button">

                                <div class="status">
                                    <span class="status-available">ĐƠN</span>
                                    <span class="status-soldout">ĐÔI</span>
                                </div>
                                <button class="book-now">Đặt Ngay</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="rating" class="tab_item">
                    <div class="hotel-card">
                        <div class="sale-badge">SALE</div>
                        <div class="hotel-image">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true" style="height: auto">
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                                <!-- Thêm các slide khác -->
                            </swiper-container>

                        </div>
                        <div class="hotel-info row">
                            <div class="col-md-9">
                                <p class="reviews">Có {{ $hotel->rating }} lượt đánh giá</p>
                                <h4 class="location_hotel">
                                    <i class="fas fa-map-marker-alt icon-location" style="color: #3B79C9;"></i>
                                    Thành Phố Hồ Chí Minh
                                </h4>
                                <h3 class="name_hotel"><i class="fa-solid fa-hotel icon-hotel"
                                        style="color: #3B79C9;"></i>{{ $hotel->hotel_name }}</h3>
                                <div class="price-info">
                                    <span class="old-price">2.337.999 đ</span>
                                    <span class="discount">-25%</span>
                                </div>
                                <span class="new-price">1.763.668 đ</span>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->rating)
                                            <span>★</span>
                                        @else
                                            <span>☆</span>
                                        @endif
                                    @endfor
                                </div>

                            </div>
                            <div class="col-md-3 status-button">

                                <div class="status">
                                    <span class="status-available">ĐƠN</span>
                                    <span class="status-soldout">ĐÔI</span>
                                </div>
                                <button class="book-now">Đặt Ngay</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('footer')
@include('partials.footer') 
@endsection

{{-- Link File JS  --}}
@section('js')
    <script src="{{ asset('js/search_result.js') }}"></script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
@endsection
