
@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!--  -->
@section('header')
@include('partials.header') 
@endsection
<!--  -->

@section('content')
    <style>
        /* Reset mặc định */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        section {
            padding: 60px 0;
        }

        .intro h2 {
            font-size: 3rem;
            font-weight: bold;
            color: #003366;
            text-align: center;
            margin-bottom: 20px;
        }

        .intro p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .feature-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .feature-card h3 {
            font-size: 1.75rem;
            color: #003366;
            margin-bottom: 20px;
        }

        .feature-card p {
            color: #777;
            font-size: 1rem;
        }

        .row {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .col-md-4 {
            flex: 1;
            max-width: 350px;
            margin-bottom: 40px;
        }

        .feature-card i {
            font-size: 50px;
            color: #003366;
            margin-bottom: 20px;
        }
        .profile-header {
            display: none !important;
        }
    </style>
</head>
<body>

    <section class="intro">
        <div class="container">
            <h2>Chào Mừng Đến Với StayNest</h2>
            <p>StayNest cung cấp giải pháp đặt phòng trực tuyến nhanh chóng và dễ dàng. Với mục tiêu mang đến cho khách hàng trải nghiệm lưu trú tuyệt vời, chúng tôi hợp tác với các khách sạn và resort hàng đầu để cung cấp phòng ốc sang trọng và tiện nghi. Chúng tôi cam kết mang đến dịch vụ tốt nhất với mức giá hợp lý.</p>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-check-circle"></i>
                        <h3>Đặt Phòng Dễ Dàng</h3>
                        <p>Hệ thống đặt phòng của StayNest cực kỳ đơn giản và nhanh chóng. Bạn chỉ cần vài bước để chọn phòng và thanh toán.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-star"></i>
                        <h3>Chất Lượng Dịch Vụ Cao</h3>
                        <p>Chúng tôi cam kết mang đến cho bạn trải nghiệm lưu trú đẳng cấp với các phòng ốc sạch sẽ, đầy đủ tiện nghi và nhân viên hỗ trợ tận tâm.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-tags"></i>
                        <h3>Khuyến Mãi Hấp Dẫn</h3>
                        <p>StayNest luôn mang đến cho bạn các chương trình khuyến mãi hấp dẫn, giúp bạn tiết kiệm chi phí cho kỳ nghỉ của mình.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
@endsection
@section('footer')
@include('partials.footer') 
@endsection