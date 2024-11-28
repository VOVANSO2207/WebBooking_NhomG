@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/introduce.css') }}">
<!--  -->
@section('header')
@include('partials.header') 
@endsection
<!--  -->

@section('content')
<style>

</style>

<section class="stay-nest-introduce">
    <div class="intro mt-2">
        <div class="container">
            <h2>Chào Mừng Đến Với StayNest</h2>
            <p>StayNest cung cấp giải pháp đặt phòng trực tuyến nhanh chóng và dễ dàng. Với mục tiêu mang đến cho khách
                hàng trải nghiệm lưu trú tuyệt vời, chúng tôi hợp tác với các khách sạn và resort hàng đầu để cung cấp
                phòng ốc sang trọng và tiện nghi. Chúng tôi cam kết mang đến dịch vụ tốt nhất với mức giá hợp lý.</p>
        </div>
    </div>

    <div class="features mt-5">
        <div class="container">
            <div class="row stay-nest-row">
                <div class="col-md-4 stay-nest-col">
                    <div class="feature-card">
                        <i class="fas fa-check-circle"></i>
                        <h3>Đặt Phòng Dễ Dàng</h3>
                        <p>Hệ thống đặt phòng của StayNest cực kỳ đơn giản và nhanh chóng. Bạn chỉ cần vài bước để chọn
                            phòng và thanh toán.</p>
                    </div>
                </div>
                <div class="col-md-4 stay-nest-col">
                    <div class="feature-card">
                        <i class="fas fa-star"></i>
                        <h3>Chất Lượng Dịch Vụ Cao</h3>
                        <p>Chúng tôi cam kết mang đến cho bạn trải nghiệm lưu trú đẳng cấp với các phòng ốc sạch sẽ, đầy
                            đủ tiện nghi và nhân viên hỗ trợ tận tâm.</p>
                    </div>
                </div>
                <div class="col-md-4 stay-nest-col">
                    <div class="feature-card">
                        <i class="fas fa-tags"></i>
                        <h3>Khuyến Mãi Hấp Dẫn</h3>
                        <p>StayNest luôn mang đến cho bạn các chương trình khuyến mãi hấp dẫn, giúp bạn tiết kiệm chi
                            phí cho kỳ nghỉ của mình.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
@include('partials.footer') 
@endsection