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
/* Thêm hiệu ứng hover đẹp cho card */
.hotel-card {
    background: #fff;
    border-radius: 12px; /* Góc bo tròn mềm mại */
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease-in-out;
    position: relative; /* Để có thể sử dụng hiệu ứng shadow */
    z-index: 0;
}

/* Thêm hiệu ứng khi hover */
.hotel-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
}

/* Thêm hiệu ứng ánh sáng nhẹ khi hover */
.hotel-card:hover::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.2); /* Ánh sáng mờ */
    z-index: -1;
    transition: opacity 0.3s ease;
}

/* Cải thiện phần hình ảnh */
.hotel-image {
    width: 100%;
    height: 220px; /* Thêm chiều cao cho ảnh */
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

/* Thêm hiệu ứng phóng to ảnh khi hover */
.hotel-card:hover .hotel-image {
    transform: scale(1.1); /* Phóng to ảnh */
}

/* Thông tin khách sạn */
.hotel-info {
    padding: 20px;
    text-align: center;
    background-color: #f7f7f7; /* Màu nền nhẹ cho thông tin */
    border-top: 2px solid #e9ecef;
}

/* Tên khách sạn */
.hotel-name {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
    transition: color 0.3s ease;
}

/* Khi hover sẽ thay đổi màu tên */
.hotel-card:hover .hotel-name {
    color: #007bff;
}

/* Vị trí khách sạn */
.hotel-location {
    font-size: 1rem;
    color: #777;
    margin-bottom: 15px;
}

/* Giá khách sạn */
.hotel-price {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

/* Giá cũ và giá mới */
.price-old {
    text-decoration: line-through;
    color: #999;
    font-size: 1rem;
    margin-right: 8px;
}

.price-new {
    color: #ff6f61;
    font-size: 1.4rem;
    font-weight: 700;
}

/* Xếp hạng sao */
.hotel-rating {
    margin-top: 10px;
}

.hotel-rating span {
    font-size: 1.3rem;
    color: gold;
}

/* Thêm chút bóng mờ cho nút */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    padding: 8px 20px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 30px; /* Nút tròn với viền bo */
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Hiệu ứng hover cho nút */
.btn-primary:hover {
    background-color: #0056b3;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

/* Thêm hiệu ứng khi nhấn nút */
.btn-primary:active {
    background-color: #003c8f;
    box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.3);
}
.no-hotels-message {
    background-color: #204481;  /* Màu nền nhẹ nhàng, giống màu cảnh báo */
    color: #ffff;  /* Màu chữ đỏ để nổi bật */
    border: 1px solid #f5c6cb;  /* Viền xung quanh có màu sáng */
    border-radius: 10px;  /* Góc bo tròn */
    padding: 20px;  /* Khoảng cách giữa nội dung và viền */
    text-align: center;  /* Căn giữa nội dung */
    font-size: 18px;  /* Kích thước chữ dễ đọc */
    font-weight: bold;  /* Làm cho chữ đậm */
    margin-top: 20px;  /* Khoảng cách trên */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Đổ bóng nhẹ */
    animation: fadeIn 0.5s ease-out;  /* Thêm hiệu ứng fade in khi hiển thị */
}

/* Hiệu ứng fade-in */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Thêm một chút responsive để tối ưu cho các thiết bị nhỏ */
@media (max-width: 768px) {
    .no-hotels-message {
        font-size: 16px;  /* Chỉnh kích thước chữ nhỏ lại trên thiết bị di động */
        padding: 15px;  /* Điều chỉnh khoảng cách */
    }
}
.no-hotels-message .btn {
    margin-top: 15px;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    text-align: center;
}

.no-hotels-message .btn-secondary {
    background-color: #6c757d;
    color: white;
    border: none;
    transition: background-color 0.3s ease;
}

.no-hotels-message .btn-secondary:hover {
    background-color: #5a6268; /* Thay đổi màu khi hover */
}


</style>
<section class="all-hotels py-5">
    <div class="container">
       

        <!-- Danh sách khách sạn -->
        <h2 style="display: flex;
    justify-content: center;
    color: #204481;">Khách Sạn tại Thành Phố: {{ $city->city_name }}</h2> <!-- Hiển thị tên thành phố -->
        @if ($hotels->count() > 0)
        <div class="row mt-5">
            @foreach($hotels as $hotel)
                <div class="col-md-3 mb-4">
                    <div class="hotel-card">
                        <!-- Hiển thị ảnh đầu tiên -->
                        @if($hotel->images->isNotEmpty())
                            <img src="{{ asset('storage/images/' . $hotel->images->first()->image_url) }}" alt="{{ $hotel->hotel_name }}" class="hotel-image">
                        @else
                            <img src="https://via.placeholder.com/300" alt="Placeholder Image" class="hotel-image">
                        @endif

                        <!-- Thông tin khách sạn -->
                        <div class="hotel-info">
                            <h3 class="hotel-name">{{ $hotel->hotel_name }}</h3>
                            <p class="hotel-location">{{ $hotel->city->city_name }}</p>
                            <p class="hotel-price">
                                <span class="price-old">{{ number_format($hotel->rooms->avg('price'), 0, ',', '.') }} VNĐ</span>
                                <span class="price-new">{{ number_format($hotel->rooms->avg('price') * (1 - $hotel->rooms->avg('discount_percent') / 100), 0, ',', '.') }} VNĐ</span>
                            </p>
                            <p class="hotel-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $hotel->rating ? 'gold' : '#ccc' }}">★</span>
                                @endfor
                            </p>
                            <a href="{{ route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]) }}" class="btn btn-primary btn-sm mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="no-hotels-message">
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
