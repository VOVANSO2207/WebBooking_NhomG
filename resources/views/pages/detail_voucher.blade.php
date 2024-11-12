

@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!--  -->
@section('header')
@include('partials.header') 
@endsection
<!--  -->
@php
    use Carbon\Carbon;
@endphp
@section('content')
<style>
  :root {
        --primary-blue: #1e88e5;
        --secondary-blue: #1565c0;
        --light-blue: #e3f2fd;
        --accent-blue: #64b5f6;
    }

    /* Banner styles - Updated with blue theme */
    .promo-banner {
        background: linear-gradient(45deg, var(--primary-blue), var(--secondary-blue));
        color: white;
        padding: 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(30, 136, 229, 0.2);
    }

    .promo-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            45deg,
            transparent,
            rgba(255, 255, 255, 0.1),
            transparent
        );
        transform: rotate(45deg);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% {
            transform: translateX(-100%) rotate(45deg);
        }
        100% {
            transform: translateX(100%) rotate(45deg);
        }
    }

    .promo-banner h2 {
        font-size: 28px;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .promo-banner p {
        font-size: 18px;
        opacity: 0.9;
    }

    /* Existing styles */
    .vouchers-container {
        padding: 20px;
        background: #e3f1fe;
        border-radius: 12px;
    }
    
    .voucher-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px 0;
    }
    
    .voucher-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        position: relative;
    }
    
    .voucher-card:hover {
        transform: translateY(-5px);
    }
    
    .voucher-header {
        background: linear-gradient(45deg, #FF6B6B, #FFB8B8);
        color: white;
        padding: 15px;
        position: relative;
    }
    
    .voucher-amount {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }
    
    .voucher-type {
        font-size: 14px;
        opacity: 0.9;
    }
    
    .voucher-body {
        padding: 20px;
        position: relative;
    }
    
    .voucher-body::before,
    .voucher-body::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 20px;
        height: 20px;
        background: #f8f9fa;
        border-radius: 50%;
        transform: translateY(-50%);
    }
    
    .voucher-body::before {
        left: -10px;
    }
    
    .voucher-body::after {
        right: -10px;
    }
    
    .voucher-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2d3436;
    }
    
    .voucher-description {
        font-size: 14px;
        color: #636e72;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    
    .voucher-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px dashed #dfe6e9;
    }
    
    .voucher-expiry {
        font-size: 12px;
        color: #b2bec3;
    }
    
    .voucher-code {
        padding: 8px 12px;
        background: #f1f2f6;
        border-radius: 6px;
        font-family: monospace;
        font-size: 14px;
        color: #2d3436;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .voucher-code:hover {
        background: #dfe6e9;
    }
    
    .voucher-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-active {
        background: #c8ffd4;
        color: #2d8a4e;
    }
    
    .status-expired {
        background: #ffe0e0;
        color: #cb2d3e;
    }
    
    .voucher-action {
        text-align: center;
        padding: 15px;
        background: #fafafa;
        border-top: 1px solid #eee;
    }
    
    .use-voucher-btn {
        background: #FF6B6B;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-weight: 500;
    }
    
    .use-voucher-btn:hover {
        background: #ff5252;
    }
    
    .use-voucher-btn.loading {
        position: relative;
        color: transparent;
    }
    
    .use-voucher-btn.loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin: -8px 0 0 -8px;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: button-loading-spinner 1s ease infinite;
    }
    
    @keyframes button-loading-spinner {
        from {
            transform: rotate(0turn);
        }
        to {
            transform: rotate(1turn);
        }
    }

    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .destinations-container {
        padding: 40px 20px;
        background: #fff;
    }

    .section-title {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
        color: #2d3436;
    }

    .destinations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        padding: 20px 0;
    }

    /* Enhanced 3D card effects */
    .destination-card {
        height: 400px;
        perspective: 2000px;
        cursor: pointer;
    }

    .destination-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .destination-card:hover .destination-inner {
        transform: rotateY(180deg);
    }

    .destination-front, .destination-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .destination-front {
        background: #fff;
        transform: rotateY(0deg);
    }

    .destination-back {
        background: #fff;
        transform: rotateY(180deg);
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .destination-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .destination-card:hover .destination-image {
        transform: scale(1.1);
    }

    .destination-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        transform: translateY(0);
        transition: transform 0.5s ease;
    }

    .destination-card:hover .destination-overlay {
        transform: translateY(100%);
    }

    .destination-overlay h3 {
        font-size: 24px;
        margin-bottom: 5px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .destination-overlay p {
        font-size: 16px;
        opacity: 0.9;
    }

    .destination-back h3 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #2d3436;
    }

    .destination-back p {
        font-size: 16px;
        color: #636e72;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .price {
        font-size: 18px;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 20px;
    }

    .explore-btn {
        background: #FF6B6B;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .explore-btn:hover {
        background: #ff5252;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
    }

    
      /* Updated View More styles */
      .view-more-container {
        text-align: center;
        margin-top: 30px;
        opacity: 0;
        height: 0;
        transition: opacity 0.3s ease, height 0.3s ease;
    }

    .view-more-container.visible {
        opacity: 1;
        height: 60px;
        padding-top: 20px;
        border-top: 1px solid rgba(30, 136, 229, 0.1);
    }

    .view-more-btn {
        background: white;
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .view-more-btn:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
    }

    .view-more-btn i {
        transition: transform 0.3s ease;
    }

    .view-more-btn:hover i {
        transform: translateX(5px);
    }

    /* Animation for voucher cards */
    .voucher-card {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .voucher-card.hidden {
        display: none;
        opacity: 0;
        transform: translateY(20px);
    }
    
</style>

<div class="page-container">
    <!-- New Promo Banner -->
    <div class="promo-banner">
        <h2>🌟 Ưu Đãi Đặc Biệt Tháng 11! 🌟</h2>
        <p>Giảm đến 50% cho tất cả các đặt phòng - Số lượng có hạn!</p>
    </div>

    <!-- Existing Vouchers Section -->
    <div class="vouchers-container">

        <h2 class="section-title">Khám Phá Ưu Đãi Hấp Dẫn Cho Mọi Kỳ Nghỉ Tại Khách Sạn</h2>
        
        <div class="voucher-list" id="voucherList">
       
        @foreach($vouchers as $key => $voucher)
    @if ($voucher->status == 'expired')
        <!-- Voucher Card 3: Đã hết hạn -->
        <div class="voucher-card expired-voucher">
            <div class="voucher-header" style="background: linear-gradient(45deg, #636e72, #b2bec3);">
                <p class="voucher-amount">Giảm {{ number_format($voucher->discount_amount, 0, ',', '.') }} VND</p>
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
                    <span class="voucher-code" onclick="copyVoucherCode(this)">{{ $voucher->promotion_code }}</span>
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
                <p class="voucher-amount">Giảm {{ number_format($voucher->discount_amount, 0, ',', '.') }} VND</p>
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
                    <span class="voucher-code" onclick="copyVoucherCode(this)">{{ $voucher->promotion_code }}</span>
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
                <p class="voucher-amount">Giảm {{ number_format($voucher->discount_amount, 0, ',', '.') }} VND</p>
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
                    <span class="voucher-code" onclick="copyVoucherCode(this)">{{ $voucher->promotion_code }}</span>
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
        <h2 class="section-title">Khám phá những điểm đến hấp dẫn trong tháng 11</h2>
        <div class="destinations-grid">
            <!-- Đà Lạt Card -->
            <div class="destination-card">
                <div class="destination-inner">
                    <div class="destination-front">
                        <img src="https://static.vinwonders.com/production/gioi-thieu-ve-da-lat-1.jpg" alt="Đà Lạt" class="destination-image" />
                        <div class="destination-overlay">
                            <h3>Đà Lạt</h3>
                            <p>Thành phố ngàn hoa</p>
                        </div>
                    </div>
                    <div class="destination-back">
                      
                        <h3>Đà Lạt</h3>
                        <p>Khám phá thành phố mộng mơ với khí hậu mát mẻ, những đồi thông xanh và các khu vườn hoa tuyệt đẹp.</p>
                        <p class="price">Từ 1.200.000đ/đêm</p>
                        <a href="/dalat" class="explore-btn">Khám phá ngay</a>
                    </div>
                </div>
            </div>

            <!-- Phú Quốc Card -->
            <div class="destination-card">
                <div class="destination-inner">
                    <div class="destination-front">
                        <img src="https://vcdn1-dulich.vnecdn.net/2022/06/03/cauvang-1654247842-9403-1654247849.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=Swd6JjpStebEzT6WARcoOA" alt="Phú Quốc" class="destination-image" />
                        <div class="destination-overlay">
                            <h3>Phú Quốc</h3>
                            <p>Đảo Ngọc</p>
                        </div>
                    </div>
                    <div class="destination-back">
                        <h3>Phú Quốc</h3>
                        <p>Thiên đường biển đảo với bãi cát trắng mịn, nước biển trong xanh và ẩm thực hải sản phong phú.</p>
                        <p class="price">Từ 1.500.000đ/đêm</p>
                        <a href="/phuquoc" class="explore-btn">Khám phá ngay</a>
                    </div>
                </div>
            </div>

            <!-- Sapa Card -->
            <div class="destination-card">
                <div class="destination-inner">
                    <div class="destination-front">
                        <img src="https://letsflytravel.vn/assets/source/2_5_2024_Up/nha-trang-city-tour/nha-trang-letsflytravel.jpg" alt="Sapa" class="destination-image" />
                        <div class="destination-overlay">
                            <h3>Sapa</h3>
                            <p>Thành phố trong sương</p>
                        </div>
                    </div>
                    <div class="destination-back">
                        <h3>Sapa</h3>
                        <p>Trải nghiệm không khí se lạnh, ngắm nhìn ruộng bậc thang và khám phá văn hóa dân tộc độc đáo.</p>
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
                    voucher.animate([
                        { opacity: 0, transform: 'translateY(20px)' },
                        { opacity: 1, transform: 'translateY(0)' }
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
        
            voucherList.scrollIntoView({ behavior: 'smooth' });
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
// Ẩn các voucher hết hạn sau 10 giây
setTimeout(() => {
    // Lấy tất cả các phần tử có class "expired-voucher"
    const expiredVouchers = document.querySelectorAll('.expired-voucher');
    
    expiredVouchers.forEach(voucher => {
        voucher.style.display = 'none'; // Ẩn voucher đã hết hạn
    });
}, 10000); // 10000ms = 10 giây
</script>
@endsection
@section('footer')
@include('partials.footer') 
@endsection