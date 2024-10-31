@extends('layouts.app')
<!--  -->
@section('header')
@include('partials.header') 
@endsection
@section('search')
@include('partials.search_layout') 
@endsection
<!--  -->
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">

@section('content')
<section class="payment mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="title-pay">
                <h4 class="m-0">Đặt phòng của bạn</h4>
                <span class="hotel-warning">Hãy đảm bảo tất cả thông tin chi tiết trên trang này đã chính xác trước
                    khi tiến hành
                    thanh toán.</span>
            </div>
            <div class="col-md-8">

                <!-- THÔNG TIN KHÁCH SẠN -->
                <div class="hotel-card border p-4">
                    <div class="row hotel-row">
                        <div class="col-md-3 hotel-image">
                            <img src="https://kda.vn/uploads/extra/241/z3718233146736_e5b5625a79f9c061536688f101f3f2af.jpg"
                                alt="">
                        </div>
                        <div class="col-md-9 hotel-details">
                            <h2 class="hotel-name m-0">Lasol Boutique Hotel</h2>
                            <div class="hotel-rating">
                                <span>★</span> <span>★</span> <span>★</span> <span>★</span> <span>★</span>
                            </div>
                            <span class="lhotel-addresscation">164 Lê Thánh Tôn, Phường Bến Thành, Quận 1, TP. Hồ Chí
                                Minh</span>
                        </div>
                    </div>
                    <hr>
                    <div class="check-details row">
                        <div class="check-in col-md-3">
                            <p class="label m-0">Nhận phòng</p>
                            <p class="info">14:00, T2, 30 tháng 9</p>
                        </div>
                        <div class="check-out col-md-4">
                            <p class="label m-0">Trả phòng</p>
                            <p class="info">12:00, T3, 01 tháng 10</p>
                        </div>
                        <div class="night-count col-md-2">
                            <p class="label m-0">Số đêm</p>
                            <p class="info">1</p>
                        </div>
                        <div class="room-info col-md-3">
                            <p class="label m-0">Số phòng</p>
                            <p class="info">x1 Đơn, x2 Đôi</p>
                        </div>
                    </div>
                </div>

                <!-- THÔNG TIN NGƯỜI ĐẶT -->
                <div class="contact-form p-4 mt-5">
                    <h3 class="mb-4">Thông tin liên hệ</h3>

                    <div class="mb-3">
                        <label for="full-name" class="form-label m-0">Họ và tên</label>
                        <input type="text" id="full-name" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label m-0">Email</label>
                            <input type="email" id="email" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label m-0">Số điện thoại</label>
                            <input type="tel" id="phone" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- YÊU CẦU KHÁC -->
                <div class="request-container">
                    <div class="request-title">Bạn có yêu cầu nào không?</div>
                    <div class="request-description">
                        Khi nhận phòng, khách sạn sẽ thông báo liệu yêu cầu này có được đáp ứng hay không. Một số yêu
                        cầu cần trả thêm phí để sử dụng nhưng bạn hoàn toàn có thể hủy yêu cầu sau đó.
                    </div>

                    <div class="row g-3">
                        <!-- CHECK BOX -->
                        <div class="col-6 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="nonSmokingRoom">
                                <label class="form-check-label checkbox-label" for="nonSmokingRoom">Phòng không hút
                                    thuốc</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="singleBed">
                                <label class="form-check-label checkbox-label" for="singleBed">Giường đơn</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="highFloor">
                                <label class="form-check-label checkbox-label" for="highFloor">Tầng lầu</label>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="doubleBed">
                                <label class="form-check-label checkbox-label" for="doubleBed">Giường đôi</label>
                            </div>
                        </div>
                        <!-- KHÁC -->
                        <div class="col-12">
                            <label for="otherRequests" class="form-label m-0">Khác</label>
                            <textarea id="otherRequests" class="other-input" maxlength="100"
                                placeholder="Nhập yêu cầu khác tại đây..."></textarea>
                            <div class="char-limit">0/100</div>
                        </div>
                    </div>
                </div>

                <div class="voucher-container">
                    <div class="group-voucherCode d-flex align-items-center voucher-1">
                        <div class="voucher-icon me-2"><i class="fa-solid fa-ticket"></i></div>
                        <div class="title me-2">Nhập mã giảm giá</div>
                        <input id="voucherCode" class="voucher-input" placeholder="Mời bạn nhập mã giảm giá"
                            type="text">
                        <button type="button" class="ms-2">SỬ DỤNG</button>
                    </div>
                </div>

                <div class="detail-price">
                    <div class="title">Chi tiết giá</div>
                    <div class="group-info-price">
                        <div class="row price-room">
                            <div class="col-md-6 left">
                                <p class="m-0">Giá phòng</p>
                                <p>(x1) Phòng - Lasol Boutique Hotel (1 đêm)</p>
                            </div>
                            <div class="col-md-6 right">
                                <div class="sale">-10%</div>
                                <div class="price-old">155.089 VND</div>
                                <div class="price-new">105.908 VND</div>
                            </div>
                        </div>
                        <hr>
                        <div class="price-item">
                            <div class="item-1">
                                <span>Mã giảm giá</span>
                                <span class="discount-code ms-2">GIAMGIACHOTOINHA</span>
                            </div>
                            <span class="discount-amount">-55.908 VND</span>
                        </div>
                        <hr>
                        <div class="total-detail-price">
                            <span class="title-total-price">Tổng giá</span>
                            <span class="total-price">100.000 VND</span>
                        </div>
                        <div class="button-pay">
                            <button type="submit" id="btnPay" class="btn-pay">Tiếp tục thanh toán</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="room-info-card border">
                    <h3 class="room-info-title">Thông tin phòng</h3>
                    <div class="room-image">
                        <div class="slider">
                            <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
                            <div class="slides">
                                <div class="slide active"><img
                                        src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                        alt="Image 1"></div>
                                <div class="slide"><img
                                        src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                        alt="Image 2"></div>
                                <div class="slide"><img
                                        src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                        alt="Image 3"></div>
                                <div class="slide"><img
                                        src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                        alt="Image 4"></div>
                                <div class="slide"><img
                                        src="https://cms.imgworlds.com/assets/a5366382-0c26-4726-9873-45d69d24f819.jpg?key=home-gallery"
                                        alt="Image 5"></div>
                            </div>
                            <button class="next" onclick="changeSlide(1)">&#10095;</button>
                        </div>
                    </div>
                    <div class="availability-container">
                        <div class="availability-alert">Chỉ còn 2 phòng</div>
                        <div class="row g-2 align-items-center group-view-date">
                            <div class="col">
                                <div class="date-box">
                                    <div class="date-header">Nhận phòng</div>
                                    <div class="date-main">Thứ 4, 2 thg 10 2024</div>
                                    <div class="date-sub">Từ 14:00</div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="date-divider">—</div>
                            </div>
                            <div class="col">
                                <div class="date-box">
                                    <div class="date-header">Trả phòng</div>
                                    <div class="date-main">Thứ 4, 2 thg 10 2024</div>
                                    <div class="date-sub">Trước 12:00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="rooom-info-amenity">
                        <div class="row">
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Có bãi đậu xe
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Có hồ bơi
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Phòng gym
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Phòng gym
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> WiFi miễn phí
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Nhà hàng
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Máy lạnh
                            </div>
                            <div class="col-6 col-md-4 amenity-item">
                                <i class="fas fa-check-circle amenity-icon"></i> Ghế tình yêu
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="room-info-description">
                        <h5 class="section-title">Giới thiệu</h5>
                        <p class="room-description">ibis Styles Vung Tau là khách sạn quốc tế tiết kiệm với thiết kế
                            vui nhộn, sáng tạo và hiện đại. Tọa lạc tại trung tâm khu vực bãi biển phía sau của Vũng
                            Tàu, du khách có thể tận hưởng một trong những...
                            <span><a href="#" class="detail-btn-load-more">Xem thêm</a></span> tầm nhìn ra đại dương đẹp
                            nhất tại
                            thành phố
                            Vũng Tàu. Khách sạn cung cấp 250 phòng độc đáo với khái niệm giường ngủ ibis mới và WIFI
                            miễn phí, phục vụ cả khách du lịch giải trí và công tác.ibis Styles Vung Tau là khách sạn
                            quốc tế tiết kiệm với thiết kế

                        </p>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

<script>
    function slideShowImage() {
        let currentSlide = 0;

        function showSlide(index) {
            const slides = document.querySelectorAll('.slide');
            if (index >= slides.length) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = slides.length - 1;
            } else {
                currentSlide = index;
            }

            const slideWidth = slides[currentSlide].clientWidth;
            const slidesContainer = document.querySelector('.slides');
            slidesContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
        }

        window.changeSlide = function (direction) {
            showSlide(currentSlide + direction);
        };

        showSlide(currentSlide);
    }

    function setupCharacterCounter() {
        const textarea = document.getElementById('otherRequests');
        const charLimit = document.querySelector('.char-limit');
        textarea.addEventListener('input', () => {
            charLimit.textContent = `${textarea.value.length}/100`;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        setupCharacterCounter();
        slideShowImage();
    });
</script>
@section('footer')
@include('partials.footer') 
@endsection