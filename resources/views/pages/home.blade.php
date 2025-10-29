<!-- resources/views/pages/home.blade.php -->
@extends('layouts.app')

@section('title', 'Trang chủ')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
{{-- https://images.unsplash.com/photo-1564501049412-61c2a3083791?q=80&w=2000 --}}
@section('content')
<section class="header-staynest-home">
    <section class="top-header header-staynest m-0">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <!-- Toggler Button -->     
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler" type="button" id="sidebarToggler" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            <!-- Sidebar Overlay -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>

            <!-- Sidebar Menu -->
            <div class="sidebar-menu" id="sidebarMenu">
                <div class="sidebar-header">
                    <h4 class="text-light">StayNest Menu</h4>
                    <button type="button" class="btn-close btn-close-white" id="sidebarClose" aria-label="Close"></button>
                </div>
                
                <!-- Social Links -->
                <div class="sidebar-section">
                    <h6 class="sidebar-title">Kết nối</h6>
                    <ul class="navbar-nav social-header">
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-brands fa-facebook fa-lg"></i> Facebook</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-brands fa-x-twitter fa-lg"></i> Twitter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-brands fa-youtube fa-lg"></i> YouTube</a>
                        </li>
                    </ul>
                </div>

                <!-- Navigation Links -->
                <div class="sidebar-section">
                    <h6 class="sidebar-title">Điều hướng</h6>
                    <ul class="navbar-nav mb-2 mb-lg-0 menu-attribute">
                        <li class="nav-item">
                            <a class="nav-link" href="{{asset('/')}}">
                                <i class="fa-solid fa-house me-1"></i> TRANG CHỦ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{asset('introduce')}}">
                                <i class="fa-solid fa-info-circle me-1"></i> GIỚI THIỆU
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hotels.index')}}">
                                <i class="fa-solid fa-hotel me-1"></i> PHÒNG KHÁCH SẠN
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('blog')}}">
                                <i class="fa-solid fa-newspaper me-1"></i> TIN TỨC
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('contact')}}">
                                <i class="fa-solid fa-envelope me-1"></i> LIÊN HỆ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('contact')}}">
                                <i class="fa-solid fa-lightbulb me-1"></i> Ý TƯỞNG
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('contact')}}">
                                <i class="fa-solid fa-paint-brush me-1"></i> SÁNG TẠO
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Profile Section for Mobile -->
                <div class="sidebar-section">
                    <h6 class="sidebar-title">Tài khoản</h6>
                    @if (auth()->check())
                        <div class="sidebar-user-info">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/images/' . Auth::user()->avatar) : asset('images/user-profile.png') }}"
                                    alt="Avatar" class="img-fluid rounded-circle me-2"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <p class="m-0 fw-bold">{{ Auth::user()->username }}</p>
                                </div>
                            </div>
                            <div class="sidebar-user-links">
                                <a href="{{ route('pages.account') }}" class="sidebar-link">
                                    <i class="fa-solid fa-user me-2"></i> Tài Khoản
                                </a>
                                <a href="{{ route('pages.account') }}?tab=nav-contact" class="sidebar-link">
                                    <i class="fa-solid fa-heart me-2"></i> Yêu Thích
                                </a>
                                <a href="{{ route('pages.account') }}?tab=nav-profile" class="sidebar-link">
                                    <i class="fa-solid fa-file-invoice me-2"></i> Hóa Đơn
                                </a>
                                <a href="{{route('viewVoucherUser')}}" class="sidebar-link">
                                    <i class="fa-solid fa-ticket me-2"></i> Voucher
                                </a>
                                <a href="#" class="sidebar-link text-danger" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                                    <i class="fa-solid fa-sign-out-alt me-2"></i> Đăng Xuất
                                </a>
                                <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="sidebar-auth-links">
                            <a href="{{ route('login') }}" class="btn btn-outline-light w-100 mb-2">
                                <i class="fa-solid fa-sign-in-alt me-2"></i> Đăng nhập
                            </a>
                            <a href="{{ url('register') }}" class="btn btn-light w-100">
                                <i class="fa-solid fa-user-plus me-2"></i> Đăng ký
                            </a>
                        </div>
                    @endif
                </div>
            </div>

                <!-- Desktop Navigation -->
                <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
                    <!-- Logo and Brand -->
                    <a href="{{asset('/')}}" class="d-flex align-items-center justify-content-center logo-staynest">
                        <img src="{{ asset('/images/logo_staynest_white_color.png') }}" alt="Logo" width="50px">
                        <h2 class="ms-2 mb-0 text-light">StayNest</h2>
                    </a>
                    
                    <!-- Navigation Links -->
                    <ul class="navbar-nav mb-2 mb-lg-0 menu-attribute">
                        <li class="nav-item"><a class="nav-link" href="{{asset('/')}}">TRANG CHỦ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{asset('introduce')}}">GIỚI THIỆU</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('hotels.index')}}">PHÒNG KHÁCH SẠN</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('blog')}}">TIN TỨC</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">LIÊN HỆ</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Ý TƯỞNG</a></li>
                    </ul>
                    
                    <!-- Profile Section -->
                    <div class="profile-header col-md-2">
                        @if (auth()->check())
                            <div class="loged">
                                <div class="group-left-header d-flex align-items-center justify-content-center">
                                    <div class="col-md-2 text-center">
                                        <button class="button-notifi" id="notificationBell-header">
                                            <i class="fa-solid fa-bell fa-xl"></i>
                                        </button>

                                        <!-- Notification Dropdown -->
                                        <div class="notification-dropdown mt-4" id="notificationDropdown-header"
                                            style="display: none;">
                                            <h5 class="dropdown-header p-3">Thông báo</h5>
                                            @foreach(session('notifications', []) as $key => $notification)
                                                <div
                                                    class="notification-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $notification['content'] }}</span>
                                                    <button class="btn-danger btn-delete-notification"
                                                        data-key="{{ $key }}">&#10005;</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-8 text-center ms-3 me-2">
                                        <p class="name-user m-0 p-0" id="userIcon">
                                            <span style="display: inline-block; transform: rotate(90deg);">&gt;</span>
                                            <abbr title="{{ Auth::check() ? Auth::user()->username : 'Guest' }}"
                                                style="text-decoration: none;">
                                                {{ Auth::check() ? Auth::user()->username : 'Guest' }}
                                            </abbr>
                                        </p>
                                    </div>

                                    <div class="col-md-2 text-center" style="width: 100%; height:100%;">
                                        <a href="{{ route('pages.account') }}">
                                            <img class="image-user"
                                                src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/images/' . Auth::user()->avatar) : asset('images/user-profile.png') }}"
                                                alt="Avatar" class="img-fluid rounded-circle"
                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown-menu" id="userDropdown" style="display: none;">
                                    <a class="dropdown-item dropdown-item-staynest" href="{{ route('pages.account') }}">
                                        Tài Khoản
                                    </a>
                                    <a class="dropdown-item dropdown-item-staynest"
                                        href="{{ route('pages.account') }}?tab=nav-contact">
                                        Yêu Thích
                                    </a>
                                    <a class="dropdown-item dropdown-item-staynest"
                                        href="{{ route('pages.account') }}?tab=nav-profile">
                                        Hóa Đơn
                                    </a>
                                    <a class="dropdown-item dropdown-item-staynest" href="{{route('viewVoucherUser')}}">
                                        Voucher
                                    </a>
                                    <a href="#" class="dropdown-item dropdown-item-staynest text-danger"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng Xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Nếu chưa đăng nhập -->
                            <div class="group-left-header">
                                <a href="{{ route('login') }}" class="login">Đăng nhập</a>
                                <span class="text-light mx-1">/</span>
                                <a href="{{ url('register') }}" class="register">Đăng ký</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </section>
    <div class="middle-staynest-home mt-5">
        <div class="slogan-staynest container">
            <h1 class="main-heading">ĐẶT PHÒNG NHANH TẬN HƯỞNG NGAY</h1>
            <p class="header-text-muted">Khám phá du lịch với dịch vụ đặt phòng nhanh chóng và tiện lợi. Hãy bắt đầu
                hành trình của bạn ngay hôm nay!</p>
        </div>
        
        <div class="search-bar-staynest-home color-light container">
            <form action="{{ route('hotels.search') }}" method="GET" class="row d-flex justify-content-center search-form">
                @csrf
                <div class="col-md-3 search-header">
                    <div class="form-group">
                        <label for="location" class="search-label">Địa điểm</label>
                        <select name="location" class="form-control-staynest select2" style="width: 100%;" tabindex="-1"
                            aria-hidden="true" required>
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
                    <label for="daterange" class="search-label">Ngày đặt phòng</label>
                    <div class="date-picker-search border">
                        <i class="fa-regular fa-calendar-days ps-2"></i>
                        <input class="datepicker-staynest form-control p-0 ms-2" type="text" name="daterange"
                            readonly />
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="search-label">Số người & phòng</label>
                    <div class="num-people border">
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
                                <input type="text" class="value-people" id="rooms" name="rooms" value="1" readonly>
                                <button type="button" class="increment-room">+</button>
                            </div>
                        </div>
                        <div class="item">
                            <span>Người lớn</span>
                            <div class="counter">
                                <button type="button" class="decrement-adult">-</button>
                                <input type="text" class="value-people" id="adults" name="adults" value="1" readonly>
                                <button type="button" class="increment-adult">+</button>
                            </div>
                        </div>
                        <div class="item">
                            <span>Trẻ em</span>
                            <div class="counter">
                                <button type="button" class="decrement-children">-</button>
                                <input type="text" class="value-people" id="children" name="children" value="0"
                                    readonly>
                                <button type="button" class="increment-children">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 search-header button-search-header">
                    <label class="search-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Tìm Khách Sạn</button>
                </div>
            </form>
        </div>
        
        <div class="button-book d-flex justify-content-center">
            <a href="{{route('hotels.index')}}" class="header-btn-book-now">ĐẶT NGAY</a>
        </div>
    </div>
    <div class="banner-change-container">
        <button class="banner-change-btn" id="changeBannerBtn" title="Đổi hình nền">
            <i class="fa-solid fa-th-large"></i>
        </button>
    </div>
    <div class="banner-modal" id="bannerModal">
        <div class="banner-modal-content">
            <div class="banner-modal-header">
                <h3 class="banner-modal-title">Chọn hình nền</h3>
                <button class="banner-modal-close" id="closeModal">&times;</button>
            </div>
            <div class="banner-options">
                <div class="banner-option selected" data-url="https://images.unsplash.com/photo-1564501049412-61c2a3083791?q=80&w=2000">
                    <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?q=80&w=2000" alt="Banner 1">
                    <div class="banner-option-name">Mặc định</div>
                </div>
                <div class="banner-option" data-url="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2000">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2000" alt="Banner 2">
                    <div class="banner-option-name">Phòng sang trọng</div>
                </div>
                <div class="banner-option" data-url="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2000">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2000" alt="Banner 3">
                    <div class="banner-option-name">View biển</div>
                </div>
                <div class="banner-option" data-url="https://images.unsplash.com/photo-1540541338287-41700207dee6?q=80&w=2000">
                    <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?q=80&w=2000" alt="Banner 4">
                    <div class="banner-option-name">Hồ bơi</div>
                </div>
                <div class="banner-upload-option" id="uploadBannerOption">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Tải lên hình ảnh</span>
                    <input type="file" accept="image/*" id="bannerUpload" style="display: none;">
                </div>
            </div>
            <div class="banner-modal-footer">
                <button class="banner-action-btn banner-cancel-btn" id="cancelBannerChange">Hủy</button>
                <button class="banner-action-btn banner-apply-btn" id="applyBannerChange">Áp dụng</button>
            </div>
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
                                    <img class="image-hotel-1" src="{{ asset('storage/images/' . $image->image_url) }}"
                                        alt="{{ $image->image_url }}" />
                                @endif
                            @endforeach

                            <div class="shape">
                                <p class="country m-0">VIET NAM</p>
                                <p class="location m-0">{{ $hotel->city->city_name }} -
                                    <span class="name-hotel">{{ mb_strimwidth($hotel->hotel_name, 0, 25, '...') }}</span>
                                </p>
                                <p class="price-old m-0">
                                    {{ number_format($hotel->average_price, 0, ',', '.') }} VNĐ
                                </p>
                                <div class="row price-top">
                                    <div class="col-md-7">
                                        <span class="price-new">
                                            {{ number_format($hotel->average_price_sale, 0, ',', '.') }} VNĐ
                                            <span>/ Khách</span>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]) }}"
                                            class="btn-book-now">ĐẶT NGAY</a>
                                    </div>
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
                            <div class="sale">
                                - {{ number_format($hotel->average_discount_percent) }} %
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <button class="prev-btn"><i class="fa-solid fa-arrow-right"></i></button>
            <button class="next-btn"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
</section>
<!-- VOUCHER -->
<section>
    <div class="voucher-banner-container">
        <div class="voucher-banner">
            <div class="banner-header">
                <div class="banner-title">
                    <span class="title-emoji">✨</span> Ưu đãi đặc biệt  <span class="month"></span>
                </div>
                <div class="banner-subtitle">Khám phá ngay ưu đãi hấp dẫn</div>
            </div>
            <div class="banner-content">
                <div class="voucher-item">
                    <div class="voucher-icon">💎</div>
                    <div class="voucher-details">
                        <h4>Giảm 200K</h4>
                        <p>Đơn từ 1.000.000đ</p>
                    </div>
                </div>
                <div class="voucher-item">
                    <div class="voucher-icon">🌟</div>
                    <div class="voucher-details">
                        <h4>Giảm 15%</h4>
                        <p>Tối đa 500K</p>
                    </div>
                </div>
                <div class="voucher-item">
                    <div class="voucher-icon">👑</div>
                    <div class="voucher-details">
                        <h4>Giảm 50%</h4>
                        <p>Lần đặt đầu tiên</p>
                    </div>
                </div>
            </div>
            <div class="banner-actions">
                <a href="{{route('viewVoucherUser')}}" class="view-all-btn">Xem tất cả ưu đãi</a>
            </div>
            <div class="new-badge">Mới</div>
        </div>
    </div>

</section>
<section class="popular-destination pb-5">
    <div class="container">
        <div class="title mb-2">Điểm đến thịnh hành</div>
        
        <!-- Desktop view - original grid layout -->
        <div class="desktop-view d-none d-lg-block">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Hồ Chí Minh']) }}" class="link-popular-destination">
                        <img class="image-destitation-1 w-100" src="https://image.vietnamnews.vn/uploadvnnews/Article/2023/9/28/308010_4651436783396218_vna_potal_thanh_pho_ho_chi_minh_la_1_trong_10_diem_den_tuyet_voi_nhat_o_chau_a_6666855.jpg" alt="Hồ Chí Minh">
                        <p class="name-location-1">HỒ CHÍ MINH</p>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Nha Trang']) }}" class="link-popular-destination">
                        <img class="image-destitation-1 w-100" src="https://letsflytravel.vn/assets/source/2_5_2024_Up/nha-trang-city-tour/nha-trang-letsflytravel.jpg" alt="Nha Trang">
                        <p class="name-location-1">NHA TRANG</p>
                    </a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Đà Lạt']) }}" class="link-popular-destination">
                        <img class="image-destitation-1 w-100" src="https://static.vinwonders.com/production/gioi-thieu-ve-da-lat-1.jpg" alt="Đà Lạt">
                        <p class="name-location-1">ĐÀ LẠT</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Huế']) }}" class="link-popular-destination">
                        <img class="image-destitation-1 w-100" src="https://kinhtevadubao.vn/stores/news_dataimages/kinhtevadubaovn/092018/18/14/5-ve-dep-co-do-hue-tao-ne-su-hap-dan-dac-biet-khi-ghe-tham-07-.7434.jpg" alt="Huế">
                        <p class="name-location-1">HUẾ</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Đà Nẵng']) }}" class="link-popular-destination">
                        <img class="image-destitation-1 w-100" src="https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA" alt="Đà Nẵng">
                        <p class="name-location-1">ĐÀ NẴNG</p>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Mobile and Tablet view - slider -->
        <div class="mobile-tablet-view d-block d-lg-none">
            <div class="destination-slider">
                <!-- Add navigation arrows -->
                <div class="slider-nav">
                    <button class="prev-slide" onclick="moveSlide(-1)">&#10094;</button>
                    <button class="next-slide" onclick="moveSlide(1)">&#10095;</button>
                </div>
                
                <div class="slider-container">
                    <div class="slider-track">
                        <div class="slide">
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Hồ Chí Minh']) }}" class="link-popular-destination">
                                <img class="image-destitation-1" src="https://image.vietnamnews.vn/uploadvnnews/Article/2023/9/28/308010_4651436783396218_vna_potal_thanh_pho_ho_chi_minh_la_1_trong_10_diem_den_tuyet_voi_nhat_o_chau_a_6666855.jpg" alt="Hồ Chí Minh">
                                <p class="name-location-1">HỒ CHÍ MINH</p>
                            </a>
                        </div>
                        <div class="slide">
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Nha Trang']) }}" class="link-popular-destination">
                                <img class="image-destitation-1" src="https://letsflytravel.vn/assets/source/2_5_2024_Up/nha-trang-city-tour/nha-trang-letsflytravel.jpg" alt="Nha Trang">
                                <p class="name-location-1">NHA TRANG</p>
                            </a>
                        </div>
                        <div class="slide">
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Đà Lạt']) }}" class="link-popular-destination">
                                <img class="image-destitation-1" src="https://static.vinwonders.com/production/gioi-thieu-ve-da-lat-1.jpg" alt="Đà Lạt">
                                <p class="name-location-1">ĐÀ LẠT</p>
                            </a>
                        </div>
                        <div class="slide">
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Huế']) }}" class="link-popular-destination">
                                <img class="image-destitation-1" src="https://kinhtevadubao.vn/stores/news_dataimages/kinhtevadubaovn/092018/18/14/5-ve-dep-co-do-hue-tao-ne-su-hap-dan-dac-biet-khi-ghe-tham-07-.7434.jpg" alt="Huế">
                                <p class="name-location-1">HUẾ</p>
                            </a>
                        </div>
                        <div class="slide">
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Đà Nẵng']) }}" class="link-popular-destination">
                                <img class="image-destitation-1" src="https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA" alt="Đà Nẵng">
                                <p class="name-location-1">ĐÀ NẴNG</p>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Slide indicators -->
                <div class="slider-dots">
                    <span class="dot active" onclick="goToSlide(0)"></span>
                    <span class="dot" onclick="goToSlide(1)"></span>
                    <span class="dot" onclick="goToSlide(2)"></span>
                    <span class="dot" onclick="goToSlide(3)"></span>
                    <span class="dot" onclick="goToSlide(4)"></span>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="our-offers pb-5">
    <div class="container">
        <div class="title mb-2">Ưu đãi của chúng tôi</div>

        <div class="Popular_filters">
            <!-- Bộ lọc Thành phố -->
            <div class="option">
                <div class="city-filters d-flex flex-wrap">
                    @if ($cities->isEmpty())
                        <span>Chưa có thành phố để hiển thị</span>
                    @else
                        @foreach ($cities->take(5) as $city)
                            <div class="city-option mb-3">
                                <button class="btn btn-outline-primary btn-lg city-btn"
                                    data-city-id="{{ $city->city_id }}">{{ $city->city_name }}</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="carousel-container">
            <div class="carousel-wrapper carousel-wrapper2">
                @foreach ($hotels as $hotel)
                    <div class="card">
                        <a href="{{ route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]) }}" class="group-offers">
                            <div class="shape-in">
                                @if ($hotel->images->isNotEmpty())
                                    <img class="image-hotel-2" src="{{ asset('storage/images/' . $hotel->images->first()->image_url) }}" alt="">
                                @else
                                    <img class="image-hotel-2" src="{{ asset('images/default-image.png') }}" alt="">
                                @endif
        
                                <div class="group-info-hotel">
                                    <p class="info-hotel-name m-0">{{ $hotel->hotel_name }}</p>
                                    <p style="color: #2e75d3" class="info-hotel-location m-0">
                                        <i class="fa-solid fa-location-dot fa-xl"></i>
                                        {{ $hotel->location }},
                                        {{ $hotel->city->city_name }}
                                    </p>
                                    <p style="color: #FF3366" class="info-hotel-reviews m-0">
                                        <i class="fa-regular fa-comment"></i>
                                        {{ $hotel->reviews->count() }} Đánh giá
                                    </p>
                                    <p class="info-hotel-price-old mb-0 mt-5 pt-5">
                                        {{ number_format($hotel->average_price_sale, 0, ',', '.') }} VNĐ
                                    </p>
                                    <div class="row group-heart-price">
                                        <div class="col col-md-6 col-sm-4 col-xs-4">
                                            <a href="#" class="heart-icon" data-hotel-id="{{ $hotel->hotel_id }}">
                                                <i class="fa-regular fa-heart @if ($hotel->is_favorite) fa-solid red @endif"></i>
                                            </a>
                                        </div>
                                        <div class="col col-md-6 col-sm-8 col-xs-8 text-right">
                                            <span class="info-hotel-price-new">
                                                {{ number_format($hotel->average_price, 0, ',', '.') }} VNĐ
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sale-hotel">
                                    -{{ number_format($hotel->average_discount_percent) }}%
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="prev-btn"><i class="fa-solid fa-arrow-right"></i></button>
            <button class="next-btn"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
</section>

<section class="famous-hotel">
    <div class="container">
        @if($recentHotels->isNotEmpty())
                <div class="title mt-5 mb-2">Khách sạn vừa xem</div>
                <div class="carousel-container">
                    <div class="carousel-wrapper">
                        @foreach($recentHotels as $recentHotel)
                            <div class="card the-top-khach-san">
                                @foreach ($recentHotel->images as $index => $image)
                                    @if ($index === 0)
                                        <img class="image-hotel-1" src="{{ asset('storage/images/' . $image->image_url) }}"
                                            alt="{{ $image->image_url }}" />
                                    @endif
                                @endforeach

                                <div class="shape">
                                    <p class="country m-0">VIET NAM</p>
                                    <p class="location m-0">{{ $recentHotel->city->city_name }} -
                                        <span class="name-hotel">{{ mb_strimwidth($recentHotel->hotel_name, 0, 25, '...')  }}</span>
                                    </p>
                                    <p class="price-old m-0">
                                        {{ number_format($recentHotel->average_price, 0, ',', '.') }} VNĐ
                                    </p>
                                    <div class="row price-top">
                                        <div class="col-md-7">
                                            <span class="price-new">
                                                {{ number_format($recentHotel->average_price_sale, 0, ',', '.') }} VNĐ
                                                <span>/ Khách</span>
                                            </span>
                                        </div>
                                        <div class="col-md-5">
                                            <a href="{{ route('pages.hotel_detail', ['hotel_id' => $recentHotel->hotel_id]) }}"
                                                class="btn-book-now">ĐẶT NGAY</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="rating-top">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $recentHotel->rating)
                                            <span>★</span>
                                        @else
                                            <span>☆</span>
                                        @endif
                                    @endfor
                                </div>
                                <div class="sale">
                                    - {{ number_format($recentHotel->average_discount_percent) }} %
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- <p>Không có khách sạn nào vừa xem.</p> -->
        @endif
</section>
<section class="latest-blogs">
    <div class="container">
        <div class="title mt-5 mb-2">Bài Viết Mới Nhất</div>
        <div class="row mt-3">
            @foreach($blogs as $blog)
                <div class="col-md-3">
                    <div class="blog-card">
                        <img src="{{ asset('storage/images/' . $blog->img) }}" alt="{{ $blog->title }}" class="blog-image">
                        <div class="blog-content">
                            <h3 class="blog-title">{{ $blog->title }}</h3>
                            <p class="blog-excerpt">
                                {{ Str::limit(html_entity_decode(strip_tags($blog->description)), 100) }}
                            </p>
                            <a href="{{ url('blog/' . $blog->url_seo) }}" class="btn-read-more">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<script>
    // Carousel functionality
    document.querySelectorAll('.carousel-wrapper').forEach((carousel) => {
        const cards = carousel.querySelectorAll('.card');
        const nextBtn = carousel.closest('.carousel-container').querySelector('.next-btn');
        const prevBtn = carousel.closest('.carousel-container').querySelector('.prev-btn');
        let index = 0;
        const visibleCards = 4; // Number of cards visible at a time

        function updateCarousel() {
            if (cards.length === 0) return; // Prevent errors if no cards

            const cardWidth = cards[0].clientWidth;
            carousel.style.transform = `translateX(${-index * cardWidth}px)`;

            // Toggle visibility of buttons based on position
            prevBtn && prevBtn.classList.toggle('hidden', index === 0);
            nextBtn && nextBtn.classList.toggle('hidden', index >= cards.length - visibleCards);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (index < cards.length - visibleCards) {
                    index++;
                    updateCarousel();
                }
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (index > 0) {
                    index--;
                    updateCarousel();
                }
            });
        }

        window.addEventListener('resize', updateCarousel);
        updateCarousel(); // Initial call
    });

    document.addEventListener('DOMContentLoaded', function () {
        const bell = document.getElementById('notificationBell-header');
        const dropdown = document.getElementById('notificationDropdown-header');

        if (bell && dropdown) {
            bell.addEventListener('click', function () {
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    dropdown.style.display = 'none';
                } else {
                    dropdown.style.display = 'block';
                    dropdown.classList.add('show');
                }
            });

            document.addEventListener('click', function (event) {
                if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.remove('show');
                    dropdown.style.display = 'none';
                }
            });
        }
    });


    // Đóng dropdown khi nhấn bên ngoài
    document.addEventListener('click', function (event) {
        const bell = document.getElementById('notificationBell');
        const dropdown = document.getElementById('notificationDropdown');

        if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
            dropdown.style.display = 'none';
        }
    });

    $(document).ready(function () {
        $('.heart-icon').on('click', function (event) {
            event.preventDefault();
            const heart = $(this).find('i');
            const hotelId = $(this).data('hotel-id');

            // Kiểm tra trạng thái yêu thích để xác định phương thức
            const isFavorite = heart.hasClass('fa-solid');

            // Gửi yêu cầu AJAX để thêm hoặc xóa khách sạn khỏi danh sách yêu thích
            $.ajax({
                url: '/favorites',
                method: isFavorite ? 'DELETE' : 'POST',
                data: {
                    hotel_id: hotelId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Cập nhật lại trạng thái của biểu tượng trái tim
                    if (isFavorite) {
                        // Nếu khách sạn đã yêu thích, xóa khỏi yêu thích và đổi lại màu tim
                        heart.removeClass('fa-solid red').addClass('fa-regular');
                    } else {
                        // Nếu chưa yêu thích, thêm vào yêu thích và đổi màu tim
                        heart.removeClass('fa-regular').addClass('fa-solid red');
                    }
                    // alert(response.message);
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message || 'Đã xảy ra lỗi.');
                }
            });
        });
    });
    function copyCode(code) {
        navigator.clipboard.writeText(code);
    }

    //  Jiệu ứng lấp lánh
    function createSparkles() {
        const header = document.querySelector('.banner-header');
        for (let i = 0; i < 5; i++) {
            const sparkle = document.createElement('div');
            sparkle.className = 'sparkle';
            sparkle.style.left = Math.random() * 100 + '%';
            sparkle.style.top = Math.random() * 100 + '%';
            sparkle.style.animation = `sparkle ${1 + Math.random()}s infinite ${Math.random()}s`;
            header.appendChild(sparkle);
        }
    }
    createSparkles();

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.city-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    fetch('{{ route('hotels.all') }}')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            updateHotelList(data.hotels);
                        })
                        .catch(error => console.error('Error:', error));
                    return;
                }
                document.querySelectorAll('.city-btn').forEach(function (btn) {
                    btn.classList.remove('selected');
                });

                this.classList.add('selected');

                var cityId = this.getAttribute('data-city-id');

                if (cityId) {
                    let url = '{{ route('hotels.filter') }}?city_id=' + cityId;

                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Data received:', data);
                            updateHotelList(data.hotels);
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    console.error('City ID is not defined.');
                }
            });
        });
    });

    function updateHotelList(hotels) {
        console.log('Hotels data received:', hotels);
        const hotelContainer = document.querySelector('.carousel-wrapper2');
        hotelContainer.innerHTML = '';

        if (hotels.length === 0) {
            hotelContainer.innerHTML = '<p>Không có khách sạn nào được tìm thấy.</p>';
            return;
        }

        hotels.forEach(hotel => {
            const hotelCard = document.createElement('div');
            const baseUrl = "{{ asset('storage/images') }}";
            hotelCard.classList.add('card');
            hotelCard.innerHTML = `
                <a href="${hotel.detail_url}" class="group-offers">
                    <div class="shape-in">
                        <img class="image-hotel-2" src="${hotel.image_url}" alt="">
                        <div class="group-info-hotel">
                            <p class="info-hotel-name m-0">${hotel.hotel_name}</p>
                            <p class="info-hotel-location m-0">${hotel.location}, ${hotel.city}</p>
                            <p class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i> ${hotel.reviews_count} Đánh giá</p>
                            <p class="info-hotel-price-old mb-0 mt-5 pt-5">${hotel.old_price} VND</p>
                            <div class="row group-heart-price">
                                <div class="col-md-6">
                                    <a href="#" class="heart-icon" data-hotel-id="${hotel.hotel_id}">
                                        <i class="fa-regular fa-heart ${hotel.is_favorite ? 'fa-solid red' : ''}"></i>
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="info-hotel-price-new">${hotel.new_price} VND</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </a>
            `;
            hotelContainer.appendChild(hotelCard);
        });
        $(document).ready(function () {
            $('.heart-icon').on('click', function (event) {
                event.preventDefault();
                const heart = $(this).find('i');
                const hotelId = $(this).data('hotel-id');

                // Kiểm tra trạng thái yêu thích để xác định phương thức
                const isFavorite = heart.hasClass('fa-solid');

                // Gửi yêu cầu AJAX để thêm hoặc xóa khách sạn khỏi danh sách yêu thích
                $.ajax({
                    url: '/favorites',
                    method: isFavorite ? 'DELETE' : 'POST',
                    data: {
                        hotel_id: hotelId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Cập nhật lại trạng thái của biểu tượng trái tim
                        if (isFavorite) {
                            // Nếu khách sạn đã yêu thích, xóa khỏi yêu thích và đổi lại màu tim
                            heart.removeClass('fa-solid red').addClass('fa-regular');
                        } else {
                            // Nếu chưa yêu thích, thêm vào yêu thích và đổi màu tim
                            heart.removeClass('fa-regular').addClass('fa-solid red');
                        }
                        // alert(response.message);
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON.message || 'Đã xảy ra lỗi.');
                    }
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-delete-notification')) {
                const key = e.target.getAttribute('data-key'); // Lấy key của thông báo

                // Gửi yêu cầu xóa thông báo
                fetch(`/notifications/${key}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Xóa thông báo khỏi giao diện
                            e.target.closest('.notification-item').remove();
                        }
                    })
                    .catch((error) => console.error('Error deleting notification:', error));
            }
        });

    });

</script>
@endsection

@section('footer')
@include('partials.footer')
@endsection

{{-- Link File JS --}}
@section('js')
<script src="{{ asset('js/home.js') }}"></script>
@endsection