@extends('layouts.app')
@section('header')
@include('partials.header') 
@endsection

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
            </div>
            <div class="col-md-4 ">
                <div class="room-info room-card border">
                    <h3 class=" m-3">Thông tin phòng</h3>
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
                    <div class="room-info p-3">
                        ádasd
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

<!-- scrip slider -->
<script>
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

    function changeSlide(direction) {
        showSlide(currentSlide + direction);
    }

    // Show the first slide initially
    showSlide(currentSlide);
</script>

@section('footer')
@include('partials.footer') 
@endsection