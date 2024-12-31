@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@section('header')
    @include('partials.header')
@endsection

@php
    use Carbon\Carbon;
@endphp

@section('content')
<style>
/* Thẻ khách sạn */
/* Thẻ khách sạn */
.hotel-card {
    background: linear-gradient(135deg, #ffffff, #f0f4ff); /* Gradient màu nhẹ */
    border-radius: 15px; /* Bo tròn góc mềm mại hơn */
    overflow: hidden; /* Giới hạn nội dung */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); /* Hiệu ứng đổ bóng */
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Hiệu ứng chuyển đổi */
    position: relative; /* Để định vị các phần tử con */
    border: 1px solid #e3e9ff; /* Viền nhạt */
}

/* Hiệu ứng khi di chuột qua thẻ */
.hotel-card:hover {
    transform: translateY(-5px); /* Đẩy card lên một chút */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15); /* Bóng đậm hơn khi hover */
}

/* Header của thẻ - Vị trí */
.hotel-card .hotel-header {
    background-color: #204481; /* Màu xanh nổi bật */
    color: white;
    font-weight: bold;
    font-size: 14px;
    text-align: center;
    padding: 5px;
    position: absolute;
    top: 10px;
    left: 10px;
    border-radius: 5px;
    z-index: 1;
}

/* Thêm phần "Tiết kiệm" */
.hotel-card .discount-badge {
    background-color: #ff6f61; /* Màu cam nổi bật */
    color: white;
    font-size: 12px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    border-radius: 5px;
    z-index: 1;
}

/* Ảnh khách sạn */
.hotel-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px 10px 0 0; /* Chỉ bo góc trên */
}

/* Thông tin khách sạn */
.hotel-info {
    padding: 15px;
    text-align: left;
    background-color: #fff; /* Nền trắng */
}

/* Tên khách sạn */
.hotel-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 8px;
}

/* Giá */
.hotel-price {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ff6f61; /* Màu cam nổi bật */

    
}

.hotel-price .price-old {
    text-decoration: line-through;
    color: #999;
    font-size: 0.9rem;
    margin-right: 8px;
}

/* Ngôi sao đánh giá */
.hotel-rating span {
    display: inline-block;
    font-size: 18px; /* Kích thước sao */
    color: gold; /* Màu vàng cho ngôi sao */
    text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3); /* Hiệu ứng đổ bóng mềm */
    transition: transform 0.2s ease-in-out, color 0.3s ease-in-out; /* Hiệu ứng hover */
    border-radius: 50%; /* Bo tròn góc mềm mại */
}

/* Ngôi sao chưa đánh giá (inactive) */
.hotel-rating span.inactive {
    color: #ddd; /* Màu xám nhạt */
    text-shadow: none; /* Loại bỏ bóng cho sao chưa đạt */
    background: none; /* Không nền */
}

/* Hiệu ứng khi di chuột qua sao */
.hotel-rating span:hover {
    transform: scale(1.2); /* Phóng to nhẹ khi hover */
    cursor: pointer; /* Hiển thị con trỏ khi hover */
}

/* Nút CTA */
.btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
    font-size: 14px;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 20px;
    display: inline-block;
    text-align: center;
    margin-top: 10px;
    transition: background-color 0.3s ease-in-out;
    text-decoration: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>

<section class="all-hotels py-5">
    <div class="container">
        <!-- Danh sách khách sạn -->
        <h2 style="text-align: center; color: #204481;">Khách Sạn tại Thành Phố: {{ $city->city_name }}</h2>
        
        @if ($hotels->count() > 0)
        <div class="row mt-5">
            @foreach($hotels as $hotel)
                <div class="col-md-3 mb-4">
                    <div class="hotel-card">
                        <!-- Hiển thị vị trí khách sạn -->
                        <div class="hotel-header">{{ $hotel->city->city_name }}</div>

                        <!-- Hiển thị tiết kiệm -->
                        @if($hotel->rooms->avg('discount_percent') > 0)
                            <div class="discount-badge">Tiết kiệm {{ number_format($hotel->rooms->avg('discount_percent')) }}%</div>
                        @endif

                        <!-- Ảnh khách sạn -->
                        @if($hotel->images->isNotEmpty())
                            <img src="{{ asset('storage/images/' . $hotel->images->first()->image_url) }}" alt="{{ $hotel->hotel_name }}" class="hotel-image">
                        @else
                            <img src="https://via.placeholder.com/300" alt="Placeholder Image" class="hotel-image">
                        @endif

                        <!-- Thông tin khách sạn -->
                        <div class="hotel-info">
                            <h3 class="hotel-name">{{ $hotel->hotel_name }}</h3>
                            <p class="hotel-price">
                                @if($hotel->rooms->avg('discount_percent') > 0)
                                    <span class="price-old">{{ number_format($hotel->rooms->avg('price'), 0, ',', '.') }} VNĐ</span>
                                @endif
                                <span class="price-new" style="font-weight: 700">{{ number_format($hotel->rooms->avg('price') * (1 - $hotel->rooms->avg('discount_percent') / 100), 0, ',', '.') }} VNĐ</span>
                            </p>
                            <p class="hotel-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $hotel->rating ? '' : 'inactive' }}">★</span>
                                @endfor
                            </p>
                            <p style="font-size: 15px; font-weight: 500;">
                                <i class="fa-regular fa-comment"></i> {{ $hotel->reviews->count() }} Đánh giá
                            </p>
                            <a href="{{ route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]) }}" class="btn btn-primary btn-sm mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="no-hotels-message text-center">
            <p>Không có khách sạn nào trong thành phố này.</p>
            <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Quay lại</a>
        </div>
        @endif

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3 pagination-voucher">
            {{ $hotels->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>

@endsection

@section('footer')
    @include('partials.footer')
@endsection
