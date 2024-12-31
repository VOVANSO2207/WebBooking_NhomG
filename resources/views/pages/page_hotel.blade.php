@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!--  -->
@section('header')
@include('partials.header')
@endsection
@section('search')
@include('partials.search_layout')
@endsection
<!--  -->
@php
    use Carbon\Carbon;
@endphp
@section('content')
<style>
    .all-hotels {
        background-color: #f9f9f9;
    }

    .hotel-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .hotel-card:hover {
        transform: translateY(-10px);
    }

    .hotel-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .hotel-info {
        padding: 15px;
        text-align: center;
    }

    .hotel-name {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .hotel-location {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }

    .hotel-price {
        margin-bottom: 10px;
    }

    .price-old {
        text-decoration: line-through;
        color: #999;
        margin-right: 5px;
    }

    .price-new {
        font-weight: bold;
        color: #ff6f61;
    }

    .hotel-rating span {
        font-size: 1.2rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .filter {
        padding-bottom: 15px;
        border-bottom: 1px solid #a1a1a1a1;
    }

    .filter .form-group {
        display: flex;
        flex-direction: column;
        /* Đảm bảo label và select xếp dọc */
        gap: 8px;
    }

    .filter label {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

    .filter .form-select {
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 400;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .filter .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        outline: none;
    }

    .filter .form-select:hover {
        border-color: #007bff;
    }

    .filter select option {
        padding: 10px;
    }

    .filter .form-select:disabled {
        background-color: #e9ecef;
        color: #6c757d;
    }

    @media (min-width: 768px) {
        /* .filter {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        } */

        .filter .form-group {
            flex-direction: row;
            align-items: center;
            gap: 15px;
        }

        .filter label {
            margin-right: 10px;
            font-size: 18px;
        }

        .filter .form-select {
            width: auto;
            flex: 0 1 300px;
            /* Giới hạn kích thước dropdown */
        }
    }

    .btn {
        display: inline-block;
        padding: 8px 15px;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        /* Màu xanh dương chủ đạo */
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
        /* Màu xanh đậm khi hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn:focus {
        outline: none;
        background-color: #004085;
        /* Màu tối hơn khi focus */
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
    }

    .btn:active {
        background-color: #00376d;
        /* Màu tối hơn khi nhấn */
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.3);
    }

    .btn-sm {
        padding: 6px 12px;
        /* Kích thước nhỏ hơn */
        font-size: 12px;
    }

    .mt-2 {
        margin-top: 8px;
        /* Khoảng cách trên */
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<section class="all-hotels pt-4">
    <div class="container">
        <!-- Thanh lọc -->
        <div class="filter mb-4">
            <form method="GET" action="{{ route('hotels.index') }}">
                <div class="form-group">
                    <label for="sort_filter">Sắp xếp</label>
                    <select name="sort_by" id="sort_filter" class="form-select" onchange="this.form.submit()">
                        <option value="">Mặc định</option>
                        <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Giá từ thấp
                            đến cao</option>
                        <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Giá từ cao
                            đến thấp</option>
                        <option value="stars_desc" {{ request('sort_by') == 'stars_desc' ? 'selected' : '' }}>Hạng sao từ
                            cao đến thấp</option>
                        <option value="reviews_count" {{ request('sort_by') == 'reviews_count' ? 'selected' : '' }}>Được
                            đánh giá nhiều</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Danh sách khách sạn -->
        <div class="row">
            @foreach($hotels as $hotel)
                <div class="col-md-3 mb-4">
                    <div class="hotel-card">
                        <!-- Hiển thị ảnh đầu tiên -->
                        @if($hotel->images->isNotEmpty())
                            <img src="{{ asset('storage/images/' . $hotel->images->first()->image_url) }}"
                                alt="{{ $hotel->hotel_name }}" class="hotel-image">
                        @endif

                        <!-- Thông tin khách sạn -->
                        <div class="hotel-info">
                            <h3 class="hotel-name">{{ $hotel->hotel_name }}</h3>
                            <p class="hotel-location">{{ $hotel->city->city_name }}</p>
                            <p class="hotel-price">
                                <span class="price-old">{{ number_format($hotel->rooms->avg('price'), 0, ',', '.') }}
                                    VNĐ</span>
                                <span
                                    class="price-new">{{ number_format($hotel->rooms->avg('price') * (1 - $hotel->rooms->avg('discount_percent') / 100), 0, ',', '.') }}
                                    VNĐ</span>
                            </p>
                            <p style="font-weight: 500;
                                                                                    font-size: 15px;"
                                class="info-hotel-reviews m-0"><i class="fa-regular fa-comment"></i>
                                {{ $hotel->reviews->count() }} Đánh giá
                            </p>
                            <p class="hotel-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $hotel->rating ? 'gold' : '#ccc' }}">★</span>
                                @endfor
                            </p>
                            <a href="{{ route('pages.hotel_detail', ['hotel_id' => $hotel->hotel_id]) }}"
                                class="btn btn-primary btn-sm mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

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