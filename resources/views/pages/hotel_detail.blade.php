@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/hotel_detail.css') }}">

@section('header')
@include('partials.header') 
@endsection
@section('content')
<section class="hotel_detail">
    <div class="container">
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
        <div class="detail-info">
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
            <div class="detail-info">
                <div class="row">
                    <div class="col">
                        <h5 class="section-title">Giới thiệu</h5>
                    </div>
                    <div class="col price">

                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('footer')
@include('partials.footer') 
@endsection