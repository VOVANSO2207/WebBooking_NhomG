@extends('layouts.app')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="{{asset('css/blog.css')}}">
<!--  -->
@section('header')
@include('partials.header') 
@endsection
<!--  -->

@section('content')
</head>
<body>
    <div class="contact-container">
        
        <!-- Header -->
        <div class="contact-header">
            <h1>Liên Hệ Với Chúng Tôi</h1>
            <p>Chúng tôi rất vui lòng được hỗ trợ bạn. Vui lòng điền thông tin bên dưới.</p>
        </div>

        <!-- Thông tin liên hệ -->
        <div class="contact-info">
            <div class="info-item">
                <h2>Địa Chỉ</h2>
                <p>123 Đường Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</p>
            </div>
            <div class="info-item">
                <h2>Email</h2>
                <p>support@example.com</p>
            </div>
            <div class="info-item">
                <h2>Điện Thoại</h2>
                <p>(+84) 123-456-789</p>
            </div>
        </div>

        <!-- Nội dung chính: bản đồ và form liên hệ -->
        <div class="contact-body">
            
            <!-- Google Maps -->
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.017245063024!2d106.69527061533587!3d10.77440999232417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fcc7664b13f%3A0x2e70d7b9a2b4f615!2zTmfDtSAzLCBOZ3V54buFbiBI4buNYywgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buNYyBDaMOidSwgVMOibiBI4buNYyBDaMOidQ!5e0!3m2!1sen!2s!4v1635931256424!5m2!1sen!2s" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <!-- Form Liên Hệ -->
            <form class="contact-form" action="{{ route('contact') }}" method="post">
                @csrf <!-- Thêm CSRF token -->
                <input type="text" name="name" placeholder="Họ và Tên" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="body" rows="5" placeholder="Nội Dung Tin Nhắn" required></textarea>
                <button type="submit">Gửi Tin Nhắn</button>
            </form>

        </div>
    </div>
</body>
</html>
@endsection