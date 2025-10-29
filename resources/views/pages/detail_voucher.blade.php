@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/detail_voucher.css') }}">

<!--  -->
@section('header')
    @include('partials.header')
@endsection
<!--  -->
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="page-container">
        <!-- New Promo Banner -->
        <div class="promo-banner">
            <h2>🌟 Ưu Đãi Đặc Biệt <span class="month"></span> ! 🌟</h2>
            <p>Giảm đến 50% cho tất cả các đặt phòng - Số lượng có hạn!</p>
        </div>

        <!-- Existing Vouchers Section -->
        <div class="vouchers-container">

            <h2 class="section-title">Khám Phá Ưu Đãi Hấp Dẫn Cho Mọi Kỳ Nghỉ Tại Khách Sạn</h2>

            <div class="voucher-list" id="voucherList">

                @foreach ($vouchers as $key => $voucher)
                    @if ($voucher->status == 'expired')
                        <!-- Voucher Card 3: Đã hết hạn -->
                        <div class="voucher-card expired-voucher">
                            <div class="voucher-header" style="background: linear-gradient(45deg, #636e72, #b2bec3);">
                                <p class="voucher-amount">Giảm {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                                    VND</p>
                                <span class="voucher-type">Đã hết hạn</span>
                                <span class="voucher-status status-expired">Đã hết hạn</span>
                            </div>
                            <div class="voucher-body">
                                <h3 class="voucher-title">{{ $voucher->pro_title }}</h3>
                                <p class="voucher-description">
                                    {{ $voucher->pro_description }}
                                </p>
                                <div class="voucher-meta">
                                    <span class="voucher-expiry">Đã hết hạn</span>
                                    <span class="voucher-code"
                                        onclick="copyVoucherCode(this)">{{ $voucher->promotion_code }}</span>
                                </div>
                            </div>
                            <div class="voucher-action">
                                <button class="use-voucher-btn" disabled style="background: #b2bec3;">Đã hết hạn</button>
                            </div>
                        </div>
                    @elseif ($voucher->status == 'expiring_soon')
                        <!-- Voucher Card 2: Còn 1 ngày nữa hết hạn -->
                        <div class="voucher-card">
                            <div class="voucher-header" style="background: linear-gradient(45deg, #4834d4, #686de0);">
                                <p class="voucher-amount">Giảm {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                                    VND</p>
                                <span class="voucher-type">Áp dụng cho đơn từ 1.000.000đ</span>
                                <span class="voucher-status status-warning">Voucher sắp hết hạn</span>
                            </div>
                            <div class="voucher-body">
                                <h3 class="voucher-title">{{ $voucher->pro_title }}</h3>
                                <p class="voucher-description">
                                    {{ $voucher->pro_description }}
                                </p>
                                <div class="voucher-meta">
                                    <span class="voucher-expiry">Hết hạn: {{ $voucher->end_date }}</span>
                                    <span class="voucher-code"
                                        onclick="copyVoucherCode(this)">{{ $voucher->promotion_code }}</span>
                                </div>
                            </div>
                            <div class="voucher-action">
                                <button class="use-voucher-btn">Sử dụng ngay</button>
                            </div>
                        </div>
                    @else
                        <!-- Voucher Card 1: Đang hoạt động -->
                        <div class="voucher-card">
                            <div class="voucher-header">
                                <p class="voucher-amount">Giảm {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                                    VND</p>
                                <span class="voucher-type">Áp dụng cho đơn từ 1.000.000đ</span>
                                <span class="voucher-status status-active">Đang hoạt động</span>
                            </div>
                            <div class="voucher-body">
                                <h3 class="voucher-title">{{ $voucher->pro_title }}</h3>
                                <p class="voucher-description">
                                    {{ $voucher->pro_description }}
                                </p>
                                <div class="voucher-meta">
                                    <span class="voucher-expiry">Hết hạn: {{ $voucher->end_date }}</span>
                                    <span class="voucher-code"
                                        onclick="copyVoucherCode(this)">{{ $voucher->promotion_code }}</span>
                                </div>
                            </div>
                            <div class="voucher-action">
                                <button class="use-voucher-btn">Sử dụng ngay</button>
                            </div>
                        </div>
                    @endif
                @endforeach


                <div class="view-more-container" id="viewMoreContainer">
                    <button class="view-more-btn" id="viewMoreBtn">
                        Xem thêm voucher <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Destinations Section -->
        <div class="destinations-container">
            <h2 class="section-title">Khám phá những điểm đến hấp dẫn trong <span class="month" style="font-weight:500;"></span></h2>
            <div class="destinations-grid">
                <!-- Đà Lạt Card -->
                <div class="destination-card">
                    <div class="destination-inner">
                        <div class="destination-front">
                            <img src="https://static.vinwonders.com/production/gioi-thieu-ve-da-lat-1.jpg" alt="Đà Lạt"
                                class="destination-image" />
                            <div class="destination-overlay">
                                <h3>Đà Lạt</h3>
                                <p>Thành phố ngàn hoa</p>
                            </div>
                        </div>
                        <div class="destination-back">

                            <h3>Đà Lạt</h3>
                            <p>Khám phá thành phố mộng mơ với khí hậu mát mẻ, những đồi thông xanh và các khu vườn hoa tuyệt
                                đẹp.</p>
                            <p class="price">Từ 1.200.000đ/đêm</p>
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Đà Lạt']) }}" class="explore-btn">Khám phá ngay</a>
                        </div>
                    </div>
                </div>

                <!-- Phú Quốc Card -->
                <div class="destination-card">
                    <div class="destination-inner">
                        <div class="destination-front">
                            <img src="https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA"
                                alt="Phú Quốc" class="destination-image" />
                            <div class="destination-overlay">
                                <h3>Đà Nẵng</h3>
                                <p>Cầu Vàng</p>
                            </div>
                        </div>
                        <div class="destination-back">
                            <h3>Đà Nẵng</h3>
                            <p>Thiên đường biển đảo với bãi cát trắng mịn, nước biển trong xanh và ẩm thực hải sản phong
                                phú.</p>
                            <p class="price">Từ 1.500.000đ/đêm</p>
                            <a href="{{ route('pages.hotel_by_city', ['cityName' => 'Đà Nẵng']) }}" class="explore-btn">Khám phá ngay</a>
                        </div>
                    </div>
                </div>

                <!-- Sapa Card -->
                <div class="destination-card">
                    <div class="destination-inner">
                        <div class="destination-front">
                            <img src="https://letsflytravel.vn/assets/source/2_5_2024_Up/nha-trang-city-tour/nha-trang-letsflytravel.jpg"
                                alt="Sapa" class="destination-image" />
                            <div class="destination-overlay">
                                <h3>Sapa</h3>
                                <p>Thành phố trong sương</p>
                            </div>
                        </div>
                        <div class="destination-back">
                            <h3>Sapa</h3>
                            <p>Trải nghiệm không khí se lạnh, ngắm nhìn ruộng bậc thang và khám phá văn hóa dân tộc độc đáo.
                            </p>
                            <p class="price">Từ 900.000đ/đêm</p>
                            <a href="/sapa" class="explore-btn">Khám phá ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const voucherList = document.getElementById('voucherList');
            const viewMoreBtn = document.getElementById('viewMoreBtn');
            const viewMoreContainer = document.getElementById('viewMoreContainer');
            const VOUCHERS_PER_PAGE = 6;

            // Initialize vouchers
            const vouchers = Array.from(voucherList.getElementsByClassName('voucher-card'));
            let currentlyShown = VOUCHERS_PER_PAGE;

            // Function to update voucher visibility
            function updateVoucherVisibility() {
                vouchers.forEach((voucher, index) => {
                    if (index < currentlyShown) {
                        voucher.classList.remove('hidden');
                        // Add animation for newly shown vouchers
                        if (index >= currentlyShown - VOUCHERS_PER_PAGE) {
                            voucher.animate([{
                                    opacity: 0,
                                    transform: 'translateY(20px)'
                                },
                                {
                                    opacity: 1,
                                    transform: 'translateY(0)'
                                }
                            ], {
                                duration: 500,
                                easing: 'ease-out',
                                fill: 'forwards'
                            });
                        }
                    } else {
                        voucher.classList.add('hidden');
                    }
                });

                // Update button visibility and text
                if (vouchers.length > VOUCHERS_PER_PAGE) {
                    viewMoreContainer.classList.add('visible');

                    if (currentlyShown >= vouchers.length) {
                        viewMoreBtn.innerHTML = 'Thu gọn <i class="fas fa-arrow-up"></i>';
                    } else {
                        viewMoreBtn.innerHTML = `Xem thêm voucher <i class="fas fa-arrow-right"></i>`;
                    }
                } else {
                    viewMoreContainer.classList.remove('visible');
                }
            }

            // Initial setup
            if (vouchers.length > VOUCHERS_PER_PAGE) {
                vouchers.forEach((voucher, index) => {
                    if (index >= VOUCHERS_PER_PAGE) {
                        voucher.classList.add('hidden');
                    }
                });
                updateVoucherVisibility();
            }

            // View More button click handler
            viewMoreBtn.addEventListener('click', function() {
                if (currentlyShown >= vouchers.length) {

                    currentlyShown = VOUCHERS_PER_PAGE;

                    voucherList.scrollIntoView({
                        behavior: 'smooth'
                    });
                } else {

                    currentlyShown = Math.min(currentlyShown + VOUCHERS_PER_PAGE, vouchers.length);
                }
                updateVoucherVisibility();
            });

            // Copy voucher code function
            window.copyVoucherCode = function(element) {
                const code = element.textContent;
                navigator.clipboard.writeText(code).then(() => {
                    const originalText = element.textContent;
                    element.textContent = 'Đã sao chép!';
                    element.style.background = '#e3f2fd';

                    setTimeout(() => {
                        element.textContent = originalText;
                        element.style.background = '#f1f2f6';
                    }, 1500);
                });
            };

            // Loading state for buttons
            document.querySelectorAll('.use-voucher-btn:not([disabled])').forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.add('loading');
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 1500);
                });
            });
        });
       
        // Loading state for buttons
        document.querySelectorAll('.use-voucher-btn:not([disabled])').forEach(button => {
            button.addEventListener('click', function() {
                this.classList.add('loading');
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 1500);
            });
        });
        const monthNames = [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];

        const currentMonth = new Date().getMonth();

        // Lấy tất cả các phần tử có class 'month' và thay đổi nội dung của chúng
        const monthElements = document.querySelectorAll('.month');
        monthElements.forEach((element) => {
            element.textContent = monthNames[currentMonth];
        });
        // Ẩn các voucher hết hạn sau 10 giây
        // setTimeout(() => {
        //     // Lấy tất cả các phần tử có class "expired-voucher"
        //     const expiredVouchers = document.querySelectorAll('.expired-voucher');

        //     expiredVouchers.forEach(voucher => {
        //         voucher.style.display = 'none'; // Ẩn voucher đã hết hạn
        //     });
        // }, 10000); // 10000ms = 10 giây
    </script>
    {{-- <script src="{{ asset('js/home.js') }}"></script> --}}

@endsection
@section('footer')
    @include('partials.footer')
@endsection
