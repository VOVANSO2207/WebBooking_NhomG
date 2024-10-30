@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/hotel_detail.css') }}">

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
                    <img src="https://kykagroup.com/wp-content/uploads/2023/07/IMG-Worlds-of-Adventure.jpg"
                        alt="Large Image">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6 small-img">
                            <img src="https://kykagroup.com/wp-content/uploads/2023/07/IMG-Worlds-of-Adventure.jpg"
                                alt="Small Image">
                            <img src="https://kykagroup.com/wp-content/uploads/2023/07/IMG-Worlds-of-Adventure.jpg"
                                alt="Small Image">
                        </div>
                        <div class="col-6 small-img">
                            <img src="https://kykagroup.com/wp-content/uploads/2023/07/IMG-Worlds-of-Adventure.jpg"
                                alt="Small Image">
                            <div class="overlay-container">
                                <img src="https://kykagroup.com/wp-content/uploads/2023/07/IMG-Worlds-of-Adventure.jpg"
                                    alt="Small Image">
                                <div class="overlay"><span>Xem tất cả ảnh</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail-location-shape mb-3"><span>vũng tàu</span></div>
        <div class="detail-info-top">
            <div class="detail-hotel-card">
                <span class="hotel-name">Khách sạn Ibis Styles Vũng Tàu</span>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">★</span>
                </div>
                <span class="price-label">Giá phòng từ</span>
            </div>
            <div class="detail-info-middle mt-2">
                <div class="row">
                    <div class="col-md-8 detail-left-info">
                        <h5 class="section-title">Giới thiệu</h5>
                        <p class="detail-description">ibis Styles Vung Tau là khách sạn quốc tế tiết kiệm với thiết kế
                            vui nhộn, sáng tạo và hiện đại. Tọa lạc tại trung tâm khu vực bãi biển phía sau của Vũng
                            Tàu, du khách có thể tận hưởng một trong những tầm nhìn ra đại dương đẹp nhất tại thành phố
                            Vũng Tàu. Khách sạn cung cấp 250 phòng độc đáo với khái niệm giường ngủ ibis mới và WIFI
                            miễn phí, phục vụ cả khách du lịch giải trí và công tác.ibis Styles Vung Tau là khách sạn
                            quốc tế tiết kiệm với thiết kế
                            vui nhộn, sáng tạo và hiện đại. Tọa lạc tại trung tâm khu vực bãi biển phía sau của Vũng
                            Tàu, du khách có thể tận hưởng một trong những tầm nhìn ra đại dương đẹp nhất tại thành phố
                            Vũng Tàu. Khách sạn cung cấp 250 phòng độc đáo với khái niệm giường ngủ ibis mới và WIFI
                            miễn phí, phục vụ cả khách du lịch giải trí và công tác.
                            <span><a href="#" class="detail-btn-load-more">Xem thêm</a></span>
                        </p>
                        <div class="detail-address">
                            <i class="fa-solid fa-location-dot fa-xl me-2"></i>
                            <span>164 Lê Thánh Tôn, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh</span>
                        </div>
                    </div>
                    <div class="col-md-4 detail-right-info">
                        <span class="detail-price-main">1.777.777 đ</span>
                        <div class="detail-map ratio ratio-16x9">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4976450036565!2d106.69522897480486!3d10.773145589375437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38cdaf80a5%3A0x18fb7c58d919b591!2zMTY0IMSQLiBMw6ogVGjDoW5oIFTDtG4sIFBoxrDhu51uZyBC4bq_biBUaMOgbmgsIFF14bqtbiAxLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1730039298467!5m2!1svi!2s"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="detail-button">
                            <a href="#" class="detail-btn-book-room">Đặt Phòng Ngay</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="hotel-amenities">
                    <div class="row">
                        <div class="col-md-6 detail-title-amenities">Tiện nghi khách sạn </div>
                        <div class="col-md-6"><a href="#" class="xem-tat-ca">Xem tất cả ></a></div>
                    </div>
                    <div class="info-amenities d-flex justify-content-center">
                        <div class="row">
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Có bãi đậu xe
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Có hồ bơi
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Phòng gym
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Phòng gym
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> WiFi miễn phí
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Nhà hàng
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Máy lạnh
                            </div>
                            <div class="col-6 col-md-3 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Ghế tình yêu
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="group-detail-book-room mt-5">
            <h2 class="detail-title-book-room">
                Chọn phòng
            </h2>
            <div class="group-room-card row gx-4">
                <!-- CARD ROOM -->
                <div class="col-md-6">
                    <div class="row group-info-room-card">

                        <!-- Hình ảnh -->
                        <div class="col-md-5 detail-infor-room-left">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true">
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                            </swiper-container>
                        </div>

                        <!-- Thông tin room -->
                        <div class="col-md-7 detail-infor-right">
                            <div class="detail-room-sale">-12%</div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-room-location m-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>Đà Nẵng</span>
                                    </div>
                                    <div class="card-room-hotel-name m-0">
                                        <i class="fa-solid fa-hotel"></i>
                                        <span>Khách Sạn Maximilan</span>
                                    </div>
                                    <div class="group-room-price mt-2">
                                        <ul class="p-0">
                                            <li>
                                                <span class="card-room-price-old">1.057.666 đ</span>
                                            </li>
                                            <li>
                                                <span class="card-room-price-new">933.157 đ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-room-rating m-0">
                                        <span>★</span> <span>★</span> <span>★</span> <span>★</span> <span>☆</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-room-status">
                                        <div class="don">ĐƠN</div>
                                        <div class="doi">ĐÔI</div>
                                    </div>
                                    <div class="card-room-btn-book">
                                        <a href="#" class="btn-book-now">đặt ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD ROOM -->
                <div class="col-md-6">
                    <div class="row group-info-room-card">

                        <!-- Hình ảnh -->
                        <div class="col-md-5 detail-infor-room-left">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true">
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                            </swiper-container>
                        </div>

                        <!-- Thông tin room -->
                        <div class="col-md-7 detail-infor-right">
                            <div class="detail-room-sale">-12%</div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-room-location m-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>Đà Nẵng</span>
                                    </div>
                                    <div class="card-room-hotel-name m-0">
                                        <i class="fa-solid fa-hotel"></i>
                                        <span>Khách Sạn Maximilan</span>
                                    </div>
                                    <div class="group-room-price mt-2">
                                        <ul class="p-0">
                                            <li>
                                                <span class="card-room-price-old">1.057.666 đ</span>
                                            </li>
                                            <li>
                                                <span class="card-room-price-new">933.157 đ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-room-rating m-0">
                                        <span>★</span> <span>★</span> <span>★</span> <span>★</span> <span>☆</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-room-status">
                                        <div class="don">ĐƠN</div>
                                        <div class="doi">ĐÔI</div>
                                    </div>
                                    <div class="card-room-btn-book">
                                        <a href="#" class="btn-book-now">đặt ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD ROOM -->
                <div class="col-md-6">
                    <div class="row group-info-room-card">

                        <!-- Hình ảnh -->
                        <div class="col-md-5 detail-infor-room-left">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true">
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                            </swiper-container>
                        </div>

                        <!-- Thông tin room -->
                        <div class="col-md-7 detail-infor-right">
                            <div class="detail-room-sale">-12%</div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-room-location m-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>Đà Nẵng</span>
                                    </div>
                                    <div class="card-room-hotel-name m-0">
                                        <i class="fa-solid fa-hotel"></i>
                                        <span>Khách Sạn Maximilan</span>
                                    </div>
                                    <div class="group-room-price mt-2">
                                        <ul class="p-0">
                                            <li>
                                                <span class="card-room-price-old">1.057.666 đ</span>
                                            </li>
                                            <li>
                                                <span class="card-room-price-new">933.157 đ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-room-rating m-0">
                                        <span>★</span> <span>★</span> <span>★</span> <span>★</span> <span>☆</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-room-status">
                                        <div class="don">ĐƠN</div>
                                        <div class="doi">ĐÔI</div>
                                    </div>
                                    <div class="card-room-btn-book">
                                        <a href="#" class="btn-book-now">đặt ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD ROOM -->
                <div class="col-md-6">
                    <div class="row group-info-room-card">

                        <!-- Hình ảnh -->
                        <div class="col-md-5 detail-infor-room-left">
                            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                navigation="true" space-between="30" loop="true">
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://gratisography.com/wp-content/uploads/2024/10/gratisography-cool-cat-800x525.jpg"
                                        alt="Nature Image 1" />
                                </swiper-slide>
                                <swiper-slide>
                                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" alt="Nature Image 1" />
                                </swiper-slide>
                            </swiper-container>
                        </div>

                        <!-- Thông tin room -->
                        <div class="col-md-7 detail-infor-right">
                            <div class="detail-room-sale">-12%</div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card-room-location m-0">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>Đà Nẵng</span>
                                    </div>
                                    <div class="card-room-hotel-name m-0">
                                        <i class="fa-solid fa-hotel"></i>
                                        <span>Khách Sạn Maximilan</span>
                                    </div>
                                    <div class="group-room-price mt-2">
                                        <ul class="p-0">
                                            <li>
                                                <span class="card-room-price-old">1.057.666 đ</span>
                                            </li>
                                            <li>
                                                <span class="card-room-price-new">933.157 đ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-room-rating m-0">
                                        <span>★</span> <span>★</span> <span>★</span> <span>★</span> <span>☆</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-room-status">
                                        <div class="don">ĐƠN</div>
                                        <div class="doi">ĐÔI</div>
                                    </div>
                                    <div class="card-room-btn-book">
                                        <a href="#" class="btn-book-now">đặt ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-room-load-more d-flex justify-content-center pt-5">
                    <button id="loadMore">Tải Thêm</button>
                </div>
            </div>
        </div>
        <div class="group-review mt-5">
            <div class="review-title m-0">ĐÁNH GIÁ</div>
            <hr class="m-0">
            <div class="total-review m-0 mb-4">
                Có tất cả 5 đánh giá
            </div>

            <!--NHẬP ĐÁNH GIÁ -->
            <div class="box-review">
                <form class="group-input-review" id="reviewForm">
                    <div class="icon-profile">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="group-text-review">
                        <input type="text" placeholder="Mời bạn nhập đánh giá..." class="form-control" id="inputReview">
                        <div class="upload-file-review">
                            <label for="file-input">
                                <i class="fa-solid fa-circle-plus"></i>
                            </label>
                            <input type="file" id="file-input" style="display: none;" accept="image/*">
                        </div>
                    </div>
                    <div class="btn-submit"><button type="submit">ĐĂNG</button></div>
                </form>
                <div class="image-preview-review">
                    <img id="preview" src="" alt="Ảnh xem trước">
                </div>

                <!-- HIỂN THỊ ĐÁNH GIÁ -->
                <div class="box-comment-review mt-3 d-flex">
                    <div class="icon-profile ms-5">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="view-review ms-2">
                        <div class="group-info-review">
                            <div class="review-user-name">Nguyen Van A</div>
                            <div class="created_at">2024-09-27</div>
                            <div class="comment-text">
                                Phòng đẹp chất lượng dịch vụ tốt, ưng ghê vậy á chàiiiii ♥♥
                            </div>
                            <div class="image-review">
                                <img src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                    alt="">
                            </div>
                            <div class="action-review mt-2">
                                <a href="#" class="like-review me-4"><i class="fa-solid fa-thumbs-up"></i>
                                    Thích</a>
                                <a href="#" class="delete-review me-4"><i class="fa-solid fa-trash"></i> Xóa
                                    Đánh
                                    Giá</a>
                                <a href="#" class="edit-review"><i class="fa-solid fa-pen-to-square"></i> Chỉnh
                                    sửa</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HIỂN THỊ ĐÁNH GIÁ -->
                <div class="box-comment-review mt-3 d-flex">
                    <div class="icon-profile ms-5">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="view-review ms-2">
                        <div class="group-info-review">
                            <div class="review-user-name">Nguyen Van A</div>
                            <div class="created_at">2024-09-27</div>
                            <div class="comment-text">
                                Phòng đẹp chất lượng dịch vụ tốt, ưng ghê vậy á chàiiiii ♥♥
                            </div>
                            <div class="image-review">
                                <img src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                    alt="">
                            </div>
                            <div class="action-review mt-2">
                                <a href="#" class="like-review me-4"><i class="fa-solid fa-thumbs-up"></i>
                                    Thích</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HIỂN THỊ ĐÁNH GIÁ -->
                <div class="box-comment-review mt-3 d-flex">
                    <div class="icon-profile ms-5">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="view-review ms-2">
                        <div class="group-info-review">
                            <div class="review-user-name">Nguyen Van A</div>
                            <div class="created_at">2024-09-27</div>
                            <div class="comment-text">
                                Phòng đẹp chất lượng dịch vụ tốt, ưng ghê vậy á chàiiiii ♥♥
                            </div>
                            <div class="image-review">
                                <img src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                    alt="">
                            </div>
                            <div class="action-review mt-2">
                                <a href="#" class="like-review me-4"><i class="fa-solid fa-thumbs-up"></i>
                                    Thích</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HIỂN THỊ ĐÁNH GIÁ -->
                <div class="box-comment-review mt-3 d-flex">
                    <div class="icon-profile ms-5">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="view-review ms-2">
                        <div class="group-info-review">
                            <div class="review-user-name">Nguyen Van A</div>
                            <div class="created_at">2024-09-27</div>
                            <div class="comment-text">
                                Phòng đẹp chất lượng dịch vụ tốt, ưng ghê vậy á chàiiiii ♥♥
                            </div>
                            <div class="image-review">
                                <img src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                    alt="">
                            </div>
                            <div class="action-review mt-2">
                                <a href="#" class="like-review me-4"><i class="fa-solid fa-thumbs-up"></i>
                                    Thích</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HIỂN THỊ ĐÁNH GIÁ -->
                <div class="box-comment-review mt-3 d-flex">
                    <div class="icon-profile ms-5">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    <div class="view-review ms-2">
                        <div class="group-info-review">
                            <div class="review-user-name">Nguyen Van A</div>
                            <div class="created_at">2024-09-27</div>
                            <div class="comment-text">
                                Phòng đẹp chất lượng dịch vụ tốt, ưng ghê vậy á chàiiiii ♥♥
                            </div>
                            <div class="image-review">
                                <img src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                    alt="">
                            </div>
                            <div class="action-review mt-2">
                                <a href="#" class="like-review me-4"><i class="fa-solid fa-thumbs-up"></i>
                                    Thích</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHÂN TRANG -->
                <div class="review-pagination">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link">
                                < </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"> > </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('file-input').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block'; // Hiển thị ảnh
            }

            reader.readAsDataURL(file); // Đọc file dưới dạng URL
        }
    });
</script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

@section('footer')
@include('partials.footer') 
@endsection