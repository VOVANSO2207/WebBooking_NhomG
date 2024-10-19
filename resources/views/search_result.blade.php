@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Tab Control</title>
    <style>
        body {
            background: #EDF2F7;
        }

        .filter {
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #ffffff;
            padding: 20px 0;
            margin-bottom: 20px;

        }
        
        .filter_price {
            width: 100%;
            margin: 20px 0;
        }

        .price_filter p {
            font-size: 1.2em;
            margin-bottom: 10px;
            padding: 0 15px;
        }

        .col-9 {
            padding-left: 15px;
        }

        .tab_control {
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 5px;
            padding-left: 10px;
        }

        .tab_list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .tab_list .text_first {
            margin-right: 15px;
        }

        .tab_btn {
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 10px;
            border: none;
            background: transparent;
            border-radius: 999px;
            font-weight: bold;
            transition: background-color 0.3s ease;

        }

        .tab_btn.active {
            background-color: #3B79C9;
            color: white;
        }

        .tab_content {
            margin-top: 20px;

        }

        .tab_item {
            display: none;
        }

        .tab_item.active {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }

            .col-3,
            .col-9 {
                width: 100%;
                padding-left: 0;
            }

            .filter {
                margin-bottom: 20px;
            }

            .tab_list {
                justify-content: space-around;
            }

            .tab_btn {
                flex: 1;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .tab_btn {
                font-size: 14px;
                padding: 8px 15px;
            }

            .tab_list {
                flex-direction: column;
                align-items: stretch;
            }

            .text_first {
                display: none;
            }
        }

        .line {
            width: 100%;
            display: inline-block;
            border: 1px solid #ccc;
        }

        .header_title h3 {
            padding: 0 15px;
            font-size: 20px;
            color: #4F4F4F;
            margin: 0;
        }

        .group_price {
            padding: 0 15px;
            border: 1px solid green;
        }

        .group_price .price_min {
            background: #D9D9D9;
            border-radius: 20px;
        }

        .group_price .price_max {
            background: #D9D9D9;
            border-radius: 20px;
        }

        .group_price .price_max .title_price_max {
            text-align: center;
        }

        .group_price .price_min .title_price_min {
            text-align: center;
        }

        .group_price .title_price_min {
            margin: 0;
        }

        .group_price .title_price_max {
            margin: 0;
        }

        .Popular_filters {
            padding: 0 15px;
        }

        .Popular_filters p {
            color: #636774;

        }

        .Popular_filters .option p {
            margin: 0;
        }

        .Popular_filters .option {
            margin: 20px 0;
        }

        .Popular_filters .check_filter {
            width: 20px;
            height: 20px;
        }

        .price-slider {
            width: 300px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .price-slider h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 4px;
            background-color: #e0e0e0;
            margin: 40px 0;
        }

        .slider-range {
            position: absolute;
            height: 100%;
            background-color: #ff385c;
        }

        .slider-handle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: white;
            border: 2px solid #ff385c;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
        }

        .price-values {
            display: flex;
            justify-content: space-between;
        }

        .price-box {
            background: #f7f7f7;
            padding: 10px;
            border-radius: 5px;
            width: 45%;
            box-sizing: border-box;
        }

        .price-box .label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .price-box .value {
            font-weight: bold;
        }

        .rating-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .rating-title {
            margin-bottom: 10px;
        }

        .star-container {
            display: flex;
            gap: 10px;
        }

        .star-button {
            /* width: 40px; */
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            color: #888;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .star-button.active {
            background-color: #4285f4;
            color: white;
            border-color: #4285f4;
        }

        .amenities_hotel {
            padding: 0 15px;
        }

        .amenities_hotel p {
            color: #666;

        }

        .amenities_hotel .title_top {
            color: #4F4F4F;
            font-size: 1.1rem;
        }

        .amenities_hotel .option p {
            margin: 0;
        }

        .amenities_hotel .option {
            margin: 20px 0;
        }

        .amenities_hotel .check_filter {
            width: 20px;
            height: 20px;
        }

        .hotel-card {
            display: flex;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 300px;

        }

        .hotel-image {
            position: relative;
            width: 30%; 
            padding: 15px;
        }

        .hotel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .sale-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 50%;
        }

        .hotel-info {
            padding: 20px;
            width: 70%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .reviews {
            color: #777;
            margin-bottom: 10px;
        }

        h3,
        h4 {
            margin-bottom: 5px;
        }

        h3 {
            color: #007bff;
            font-size: 18px;
        }

        h4 {
            color: #333;
            font-size: 16px;
        }

        .price-info {
            margin: 10px 0;
            font-size: 16px;
        }

        .old-price {
            text-decoration: line-through;
            color: #888;
            margin-right: 10px;
        }

        .discount {
            color: red;
            font-weight: bold;
            margin-right: 10px;
        }

        .new-price {
            color: #e53935;
            font-size: 24px;
            font-weight: bold;
        }

        .rating {
            color: #ffdd00;
            font-size: 20px;
        }

        .status {
            margin: 10px 0;
        }

        .status span {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 10px;
            margin-right: 10px;
            font-size: 12px;
            color: #fff;
        }

        .status-available {
            background-color: #28a745;
        }

        .status-soldout {
            background-color: #6c757d;
        }

        .book-now {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            align-self: flex-start;
        }

        .book-now:hover {
            background-color: #0056b3;
        }


         swiper-container {
            width: 100%;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper {
            height: 80%;
            width: 100%;
        }

        .mySwiper2 {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper2 swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper2 .swiper-slide-thumb-active {
            opacity: 1;
        }

        swiper-slide img {
            display: sw </swiper-slidek;
            width: 100%;
            height: 100%;
            object-fit: cover;
        } 
        /* body {
      position: relative;
      height: 100%;
    } */

    body {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #000;
      margin: 0;
      padding: 0;
    }

    swiper-container {
      width: 100%;
      height: 80%;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    swiper-container {
      /* margin-left: auto; */
      /* margin-right: auto; */
      margin: 0;
      padding: 0 10px;
    }
    </style>

</head>

<body>
    <div class="container">
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
                    <div class="slider-container">
                        <div class="slider-range"></div>
                        <div class="slider-handle" id="min-handle"></div>
                        <div class="slider-handle" id="max-handle"></div>
                    </div>
                    <div class="price-values">
                        <div class="price-box">
                            <div class="label">Thấp nhất</div>
                            <div class="value" id="min-value">1.200.000 ₫</div>
                        </div>
                        <div class="price-box">
                            <div class="label">Cao nhất</div>
                            <div class="value" id="max-value">4.900.000 ₫</div>
                        </div>
                    </div>
                </div>
                <div class="Popular_filters">
                    <p>Bộ lọc phổ biến</p>
                    <div class="option d-flex justify-content-between align-items-center">
                        <p>Nhiều đánh giá</p>
                        <input type="checkbox" class="check_filter">
                    </div>
                    <div class="option d-flex justify-content-between align-items-center">
                        <p>Nhiều đánh giá</p>
                        <input type="checkbox" class="check_filter">
                    </div>
                    <div class="option d-flex justify-content-between align-items-center">
                        <p>Nhiều đánh giá</p>
                        <input type="checkbox" class="check_filter">
                    </div>
                    <div class="option d-flex justify-content-between align-items-center">
                        <p>Nhiều đánh giá</p>
                        <input type="checkbox" class="check_filter">
                    </div>
                    <div class="option d-flex justify-content-between align-items-center">
                        <p>Nhiều đánh giá</p>
                        <input type="checkbox" class="check_filter">
                    </div>

                </div>
                <span class="line"></span>

                <div class="rating-container">
                    <h3 class="rating-title">Hạng sao khách sạn</h3>
                    <div class="star-container">
                        <button class="star-button" data-rating="2">2 ★</button>
                        <button class="star-button" data-rating="3">3 ★</button>
                        <button class="star-button active" data-rating="4">4 ★</button>
                        <button class="star-button" data-rating="5">5 ★</button>
                    </div>
                </div>
                <!-- Tiện nghi khách sạn -->
                <div class="amenities_hotel">
                    <p class="title_top">Tiện nghi khách sạn</p>
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
                        <div class="hotel-card">
                            <div class="hotel-image">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                            navigation="true" space-between="30" loop="true">
                            <swiper-slide>     <img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                            <swiper-slide>     <img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                            <swiper-slide>     <img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                            <swiper-slide>Slide 4</swiper-slide>
                            <swiper-slide>Slide 5</swiper-slide>
                            <swiper-slide>Slide 6</swiper-slide>
                            <swiper-slide>Slide 7</swiper-slide>
                            <swiper-slide>Slide 8</swiper-slide>
                            <swiper-slide>Slide 9</swiper-slide>
                        </swiper-container>
                            </div>
                            <div class="hotel-info">
                                <p class="reviews">Có 200 lượt đánh giá</p>
                                <h3><i class="fa fa-map-marker"></i> Thành phố Hồ Chí Minh</h3>
                                <h4><i class="fa fa-hotel"></i> Tên khách sạn</h4>
                                <div class="price-info">
                                    <span class="old-price">2.337.999 đ</span>
                                    <span class="discount">-25%</span>
                                    <span class="new-price">1.763.668 đ</span>
                                </div>
                                <div class="rating">
                                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                </div>
                                <div class="status">
                                    <span class="status-available">ĐƠN</span>
                                    <span class="status-soldout">ĐỢI</span>
                                </div>
                                <button class="book-now">Đặt Ngay</button>
                            </div>
                        </div>
                    </div>
                    <div id="high-to-low" class="tab_item">
                        <!-- <div class="hotel-card">
                            <div class="hotel-image">
                            <swiper-container style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="mySwiper" thumbs-swiper=".mySwiper2" loop="true" space-between="10"
                            navigation="true">
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-4.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-9.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-10.jpg" />
                            </swiper-slide>
                        </swiper-container>
                        <swiper-container class="mySwiper2" loop="true" space-between="10" slides-per-view="4"
                            free-mode="true" watch-slides-progress="true">
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-4.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-9.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-10.jpg" />
                            </swiper-slide>
                        </swiper-container>
                            </div>
                        </div> -->
                        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                            navigation="true" space-between="30" loop="true">
                            <swiper-slide>     <img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                            <swiper-slide>     <img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                            <swiper-slide>     <img src="https://swiperjs.com/demos/images/nature-1.jpg" /></swiper-slide>
                            <swiper-slide>Slide 4</swiper-slide>
                            <swiper-slide>Slide 5</swiper-slide>
                            <swiper-slide>Slide 6</swiper-slide>
                            <swiper-slide>Slide 7</swiper-slide>
                            <swiper-slide>Slide 8</swiper-slide>
                            <swiper-slide>Slide 9</swiper-slide>
                        </swiper-container>
                    </div>
                    <div id="popular" class="tab_item">
                        <div class="hotel-card">
                            <div class="hotel-image">
                            <swiper-container style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="mySwiper" thumbs-swiper=".mySwiper2" loop="true" space-between="10"
                            navigation="true">
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-4.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-9.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-10.jpg" />
                            </swiper-slide>
                        </swiper-container>
                        <swiper-container class="mySwiper2" loop="true" space-between="10" slides-per-view="4"
                            free-mode="true" watch-slides-progress="true">
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-4.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-9.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-10.jpg" />
                            </swiper-slide>
                        </swiper-container>
                            </div>
                        </div>
                    </div>
                    <div id="rating" class="tab_item">
                        <p>Sắp xếp sản phẩm theo đánh giá cao nhất.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const tabButtons = document.querySelectorAll('.tab_btn');
        const tabContents = document.querySelectorAll('.tab_item');

        tabButtons.forEach((btn) => {
            btn.addEventListener('click', function () {
                tabButtons.forEach((btn) => btn.classList.remove('active'));
                tabContents.forEach((content) => content.classList.remove('active'));

                this.classList.add('active');
                const targetTab = this.getAttribute('data-tab');
                document.getElementById(targetTab).classList.add('active');
            });
        });

        // Hàm để cập nhật giá theo input range
        function updatePrice(value) {
            // Giá trị thấp nhất giả định
            var minPrice = 1000000; // 1 triệu

            // Cập nhật giá trị thấp nhất
            document.getElementById('minPrice').innerText = minPrice.toLocaleString() + 'd';

            // Cập nhật giá trị cao nhất bằng giá trị của input range
            document.getElementById('maxPrice').innerText = parseInt(value).toLocaleString() + 'd';
        }

        // Gọi hàm khi trang được tải lần đầu để thiết lập giá trị ban đầu
        // window.onload = function () {
        //     var initialValue = document.getElementById('points').value;
        //     updatePrice(initialValue);
        // }


        const sliderContainer = document.querySelector('.slider-container');
        const sliderRange = document.querySelector('.slider-range');
        const minHandle = document.getElementById('min-handle');
        const maxHandle = document.getElementById('max-handle');
        const minValue = document.getElementById('min-value');
        const maxValue = document.getElementById('max-value');

        const minPrice = 1200000;
        const maxPrice = 4900000;
        let currentMin = minPrice;
        let currentMax = maxPrice;

        function setHandlePosition(handle, value) {
            const percent = (value - minPrice) / (maxPrice - minPrice) * 100;
            handle.style.left = `${percent}%`;
        }

        function updateSliderRange() {
            const minPercent = (currentMin - minPrice) / (maxPrice - minPrice) * 100;
            const maxPercent = (currentMax - minPrice) / (maxPrice - minPrice) * 100;
            sliderRange.style.left = `${minPercent}%`;
            sliderRange.style.width = `${maxPercent - minPercent}%`;
        }

        function formatPrice(price) {
            return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }

        function updatePriceValues() {
            minValue.textContent = formatPrice(currentMin);
            maxValue.textContent = formatPrice(currentMax);
        }

        function handleSliderInteraction(e, isMinHandle) {
            const rect = sliderContainer.getBoundingClientRect();
            const percent = Math.min(Math.max((e.clientX - rect.left) / rect.width, 0), 1);
            const value = Math.round((minPrice + percent * (maxPrice - minPrice)) / 100000) * 100000;

            if (isMinHandle) {
                currentMin = Math.min(value, currentMax - 100000);
                setHandlePosition(minHandle, currentMin);
            } else {
                currentMax = Math.max(value, currentMin + 100000);
                setHandlePosition(maxHandle, currentMax);
            }

            updateSliderRange();
            updatePriceValues();
        }

        minHandle.addEventListener('mousedown', function (e) {
            e.preventDefault();
            document.addEventListener('mousemove', moveMinHandle);
            document.addEventListener('mouseup', stopMinHandleMove);
        });

        maxHandle.addEventListener('mousedown', function (e) {
            e.preventDefault();
            document.addEventListener('mousemove', moveMaxHandle);
            document.addEventListener('mouseup', stopMaxHandleMove);
        });

        function moveMinHandle(e) {
            handleSliderInteraction(e, true);
        }

        function moveMaxHandle(e) {
            handleSliderInteraction(e, false);
        }

        function stopMinHandleMove() {
            document.removeEventListener('mousemove', moveMinHandle);
            document.removeEventListener('mouseup', stopMinHandleMove);
        }

        function stopMaxHandleMove() {
            document.removeEventListener('mousemove', moveMaxHandle);
            document.removeEventListener('mouseup', stopMaxHandleMove);
        }
        console.log(minValue);

        // Initialize slider
        setHandlePosition(minHandle, currentMin);
        setHandlePosition(maxHandle, currentMax);
        updateSliderRange();
        updatePriceValues();
        const starButtons = document.querySelectorAll('.star-button');

        starButtons.forEach(button => {
            button.addEventListener('click', () => {
                starButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</body>

</html>
@endsection