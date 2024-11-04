<!-- resources/views/pages/home.blade.php -->
@extends('layouts.app')

@section('title', 'Trang chủ')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->

<!-- <script>
    // Datepicker
    function initializeDateRangePicker() {
        const startDate = moment(); // Ngày hiện tại
        const endDate = moment().add(1, 'days'); // Ngày hiện tại + 7 ngày

        $('input[name="daterange"]').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            minDate: startDate, // Ngày hiện tại là ngày nhỏ nhất
            opens: 'center',
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end) {
            // Cập nhật giá trị của input khi người dùng chọn
            $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        });

        // Cập nhật giá trị mặc định cho input
        $('input[name="daterange"]').val(startDate.format('DD/MM/YYYY') + ' - ' + endDate.format('DD/MM/YYYY'));
    }

    $(document).ready(function() {
        $('.select2').select2(); // Khởi tạo Select2 cho các phần tử có class "select2"
    });

    $(document).ready(function() {
        initializeDateRangePicker(); // Gọi hàm khởi tạo
    });
</script> -->

@section('content')
    <div class="banner-home"></div>
    <section class="header-staynest-home">
        <div class="top-header">
            <a href="#" class="logo-staynest p-3">
                <img src="{{ asset('/images/logo_staynest_white_color.png') }}" alt="" width="50px">
                <h1 class="name-logo ms-2">StayNest</h1>
            </a>
            <div class="menu-header d-flex justify-content-center text-light m-3">
                <div class="container row align-items-center">
                    <div class="social-header col-md-2 text-center">
                        <a href="#" class="link-social"><i class="fa-brands fa-facebook fa-2xl"></i></a>
                        <a href="#" class="link-social"><i class="fa-brands fa-x-twitter fa-2xl"></i></a>
                        <a href="#" class="link-social"><i class="fa-brands fa-youtube fa-2xl"></i></a>
                    </div>
                    <div class="menu-header col-md-8">
                        <ul class="menu-attribute d-flex justify-content-around m-0">
                            <li><a href="#">TRANG CHỦ</a></li>
                            <li><a href="#">GIỚI THIỆU</a></li>
                            <li><a href="#">PHÒNG KHÁCH SẠN</a></li>
                            <li><a href="{{ route('blog') }}">TIN TỨC</a></li>
                            <li><a href="#">LIÊN HỆ</a></li>
                        </ul>
                    </div>
                    <div class="profile-header col-md-2">
                        <!-- Nếu chưa đăng nhập -->
                        <!-- <div class="group-left-header">
                                <a href="#" class="login">Đăng nhập/</a>
                                <a href="#" class="register">Đăng ký</a>
                            </div> -->
                        <!-- Nếu đã đăng nhập -->
                        <div class="loged">
                            <div class="group-left-header d-flex align-items-center justify-content-center">
                                <div class="col-md-2 text-center">
                                    <i class="fa-solid fa-bell fa-xl"></i>
                                </div>
                                <div class="col-md-8 text-center ms-3 me-2">
                                    <p class="name-user m-0 p-0" id="userIcon">
                                        <span style="display: inline-block; transform: rotate(90deg);">&gt;</span>
                                        <abbr title="Nguyen Hoang Son" style="text-decoration: none;">Nguyen Hoang
                                            Son</abbr>
                                    </p>
                                </div>
                                <div class="col-md-2 text-center">
                                    <i class="fa-solid fa-user fa-xl"></i>
                                </div>
                            </div>
                            <div class="dropdown-menu" id="userDropdown" style="display: none;">
                                <a class="dropdown-item dropdown-item-staynest" href="#">Tài Khoản</a>
                                <a class="dropdown-item dropdown-item-staynest" href="#">Yêu Thích</a>
                                <a class="dropdown-item dropdown-item-staynest" href="#">Hóa Đơn</a>
                                <a class="dropdown-item dropdown-item-staynest" href="#">Voucher</a>
                                <a href="#" class="dropdown-item dropdown-item-staynest text-danger"
                                    >
                                    Đăng Xuất
                                </a>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="middle-staynest-home mt-5">
            <div class="search-bar-staynest-home color-light container">
                <form action="{{ route('hotels.search') }}" method="GET" class="row d-flex justify-content-center">
                    @csrf
                    <div class="col-md-3 search-header">
                        <div class="form-group">
                            <select name="location" class="form-control-staynest select2" style="width: 100%;"
                                tabindex="-1" aria-hidden="true" required>
                                @if ($cities->isEmpty())
                                    <option value="">Chưa có địa điểm hiển thị</option>
                                @else
                                    @foreach ($cities as $citie)
                                        <option value="{{ $citie->city_id }}" id="{{ $citie->city_id }}">
                                            {{ $citie->city_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="date-picker-search border">
                            <div class="d-flex justify-content-around">
                                <div class="label-date">Ngày đi</div>
                                <div class="label-date">Ngày về</div>
                            </div>
                            <input class="datepicker-staynest form-control p-0 m-0" type="text" name="daterange"
                                readonly />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="num-people border">
                            <label class="small-text">Số người</label>
                            <div class="number">
                                <span id="people-summary">1 người lớn, </span>
                                <span id="room-summary">1 phòng, </span>
                                <span id="children-summary">0 trẻ em</span>
                            </div>
                        </div>
                        <div class="drop-counter mt-1 bg-light">
                            <div class="item">
                                <span>Phòng</span>
                                <div class="counter">
                                    <button type="button" class="decrement-room">-</button>
                                    <input type="text" class="value-people" id="rooms" name="rooms"
                                        value="1" readonly>
                                    <button type="button" class="increment-room">+</button>
                                </div>
                            </div>
                            <div class="item">
                                <span>Người lớn</span>
                                <div class="counter">
                                    <button type="button" class="decrement-adult">-</button>
                                    <input type="text" class="value-people" id="adults" name="adults"
                                        value="1" readonly>
                                    <button type="button" class="increment-adult">+</button>
                                </div>
                            </div>
                            <div class="item">
                                <span>Trẻ em</span>
                                <div class="counter">
                                    <button type="button" class="decrement-children">-</button>
                                    <input type="text" class="value-people" id="children" name="children"
                                        value="0" readonly>
                                    <button type="button" class="increment-children">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 search-header button-search-header">
                        <button type="submit" class="btn btn-primary" style="width: 100%; height: 47px;">Tìm Khách
                            Sạn</button>
                    </div>
                </form>
            </div>
            <div class="slogan-staynest container">
                <p>ĐẶT PHÒNG NHANH TẬN HƯỞNG NGAY</p>
                <p class="header-text-muted">Khám phá du lịch với dịch vụ đặt phòng nhanh chóng và tiện lợi. Hãy bắt đầu
                    hành trình
                    của bạn ngay hôm
                    nay!</p>
            </div>
            <div class="button-book d-flex justify-content-center">
                <a href="#" class="header-btn-book-now">ĐẶT NGAY</a>
            </div>
        </div>
    </section>

    <section class="famous-hotel">
        <div class="container">
            <div class="title mt-5 mb-2">Khách Sạn Nổi Tiếng</div>
            <div class="carousel-container">
                <div class="carousel-wrapper">
                    @foreach ($hotels as $hotel)
                        @if ($hotel->rating >= 4.0)
                            <div class="card the-top-khach-san">
                                @foreach ($hotel->images as $index => $image)
                                    @if ($index === 0)
                                        <img class="image-hotel-1"
                                            src="{{ asset('storage/images/' . $image->image_url) }}"
                                            alt="{{ $image->image_url }}" />
                                    @endif
                                @endforeach


                                <div class="shape">
                                    <p class="country m-0">VIET NAM</p>
                                    <p class="location m-0">{{ $hotel->location }} - <span
                                            class="name-hotel">{{ $hotel->hotel_name }}</span></p>
                                    <p class="price-old m-0">VNĐ {{ number_format($hotel->price_old, 0, ',', '.') }} VNĐ
                                    </p>
                                    <div class="row price-top">
                                        <div class="col-md-7">
                                            <span class="price-new">VNĐ
                                                {{ number_format($hotel->price_new, 0, ',', '.') }} VNĐ
                                                <span>/ Khách</span> </span>
                                        </div>
                                        <div class="col-md-5"><a href="#" class="btn-book-now">ĐẶT NGAY</a></div>
                                    </div>
                                </div>
                                <div class="rating-top">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $hotel->rating)
                                            <span>★</span>
                                        @else
                                            <span>☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <div class="sale"><span>-</span>50%</div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <button class="prev-btn"><i class="fa-solid fa-arrow-right"></i></button>
                <button class="next-btn"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </section>

    <section class="popular-destination pb-5">
        <div class="container">
            <div class="title mt-5 mb-2">Điểm đến thịnh hành</div>
            <div class="row">
                <div class="col-md-6">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://image.vietnamnews.vn/uploadvnnews/Article/2023/9/28/308010_4651436783396218_vna_potal_thanh_pho_ho_chi_minh_la_1_trong_10_diem_den_tuyet_voi_nhat_o_chau_a_6666855.jpg"
                            alt="image">
                        <p class="name-location-1">HỒ CHÍ MINH</p>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://letsflytravel.vn/assets/source/2_5_2024_Up/nha-trang-city-tour/nha-trang-letsflytravel.jpg"
                            alt="image">
                        <p class="name-location-1">ĐÀ NẴNG</p>
                </div>
                </a>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://static.vinwonders.com/production/gioi-thieu-ve-da-lat-1.jpg" alt="image">
                        <p class="name-location-1">ĐÀ LẠT</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://th.bing.com/th/id/R.05b072e1b9b939addf7c3f25637efa5e?rik=3F5fed7sbYHisQ&pid=ImgRaw&r=0"
                            alt="image">
                        <p class="name-location-1">CÀ MAU</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="link-popular-destination">
                        <img class="image-destitation-1"
                            src="https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA"
                            alt="image">
                        <p class="name-location-1">ĐÀ NẴNG</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="our-offers pb-5">
        <div class="container">
            <div class="title mt-5 mb-2">Ưu đãi của chúng tôi</div>
            <div class="carousel-container">
                <div class="carousel-wrapper">
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="#" class="group-offers">
                            <div class="shape-in">
                                <img class="image-hotel-2"
                                    src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/209890188.jpg?k=882e748be3114714efa7f001b6ffa97425b1a52a458d3166dea3c1af7c66ac09&o=&hp=1"
                                    alt="">
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">Grand Wahlla Hotel</p>
                                    <p class="info-hotel-location m-0">Ho Chi Minh City, Viet Nam</p>
                                    <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> 294 Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">1,710,000 đ</p>
                                    <div class="row group-heart-price">
                                        <div class="col-md-6"><a href="#"><i class="fa-regular fa-heart"></i></a>
                                            <!--<i class="fa-solid fa-heart"></i>-->
                                        </div>
                                        <div class="col-md-6 text-right"><span class="info-hotel-price-new">1,504,800
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">-10%</div>
                            </div>
                        </a>
                    </div>
                </div>
                <button class="prev-btn"><i class="fa-solid fa-arrow-right"></i></button>
                <button class="next-btn"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </section>

    <script>
        const carousels = document.querySelectorAll('.carousel-wrapper');

        carousels.forEach(carousel => {
            const cards = carousel.querySelectorAll('.card');
            const nextBtn = carousel.parentElement.querySelector('.next-btn');
            const prevBtn = carousel.parentElement.querySelector('.prev-btn');
            let index = 0;
            const visibleCards = 4; // Number of cards visible at a time

            function updateCarousel() {
                const cardWidth = cards[0].clientWidth;
                carousel.style.transform = `translateX(${-index * cardWidth}px)`;

                // Hide prev button if at the start
                if (index === 0) {
                    prevBtn.classList.add('hidden');
                } else {
                    prevBtn.classList.remove('hidden');
                }

                // Hide next button if at the end
                if (index >= cards.length - visibleCards) {
                    nextBtn.classList.add('hidden');
                } else {
                    nextBtn.classList.remove('hidden');
                }
            }

            nextBtn.addEventListener('click', () => {
                if (index < cards.length - visibleCards) {
                    index++;
                    updateCarousel();
                }
            });

            prevBtn.addEventListener('click', () => {
                if (index > 0) {
                    index--;
                    updateCarousel();
                }
            });

            window.addEventListener('resize', updateCarousel); // Adjust on window resize

            // Initial call to hide prev button on load
            updateCarousel();
        });
    </script>
@endsection
@section('footer')
    @include('partials.footer')
    {{-- Link File JS --}}
@section('js')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
@endsection
